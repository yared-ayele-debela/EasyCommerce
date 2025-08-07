<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced;
use App\Models\AppSetting;
use App\Models\Bank;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\DeliverySetting;
use App\Models\Discount;
use App\Models\EcommerceOrderPaymentInfo;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Restaurant\OrderPaymentInfo;
use App\Models\SalesCommission;
use App\Models\SalesMainCommission;
use App\Models\ShippingCharge;
use App\Models\Tip;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Services\NotificationService;
use App\Services\SmsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DirectCheckoutController extends Controller
{
    //
    public function calculateShipping(Request $request)
    {

        $addressId = $request->address_id;

        $productId = $request->product_id;
        $qty = (int)$request->quantity;

        $address = DeliveryAddress::find($addressId);
        $product = Product::find($productId);

        if (!$product) {
        return response()->json(['success' => false, 'message' => 'Invalid product']);
    }

        if ($addressId === 'current_address') {
        if (!$request->has('current_lat') || !$request->has('current_lng')) {
            return response()->json(['success' => false, 'message' => 'Missing current location']);
        }

        $address = (object)[
            'latitude' => $request->current_lat,
            'longitude' => $request->current_lng
        ];
    } else {
        $address = DeliveryAddress::find($addressId);
        if (!$address) {
            return response()->json(['success' => false, 'message' => 'Invalid address']);
        }
    }



        // Calculate total weight
        $weight = $product->product_weight * $qty;

        // Get vendor zone
        $zone = $product->vendor->zone ?? 'default';

        // Base shipping from database
        $baseShipping = ShippingCharge::getShippingCharges($weight, $zone);

        // Optional: Distance-based shipping
        $distanceShipping = 0;
        $delivery_settings=DeliverySetting::first();
        if ($product->vendor->latitude && $product->vendor->longitude && $address->latitude && $address->longitude) {
            $distance = $this->calculateDistance(
                $product->vendor->latitude,
                $product->vendor->longitude,
                $address->latitude,
                $address->longitude
            );
            $distanceShipping = $distance * $delivery_settings->fee_per_km; // 10 ETB per KM
        }

        $finalShipping = $baseShipping + $distanceShipping;

        return response()->json([
            'success' => true,
            'shipping_fee' => round($finalShipping, 2)
        ]);
    }

    // Haversine formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // distance in KM
    }
    public function directCheckout(Request $request)
    {

        $product = Product::findOrFail($request->product_id);
        $final_price=$request->final_price;
        $unit_price=$request->unit_price;
        $qty=$final_price / $unit_price;
        $qty= number_format($qty,0);


        $countries = Country::where('status', 1)->get();
        $deliveryAddresses = DeliveryAddress::where('user_id', Auth::user()->id)->get();

        $totalPrice = $final_price;
        $totalTax = 0;

        $taxPercent = $product->product_tax;
        $totalTax += round($final_price * $taxPercent / 100, 2);

        $weight = $product->product_weight;
        $zone = $product->vendor->zone;
        $shipping = ShippingCharge::getShippingCharges($weight, $zone);


        $tips=Tip::all();

        $banks=Bank::all();

        $item = [
            'product' => $product,
            'quantity' => $qty,
            'size' => $request->size??'',
            'total' => $final_price
        ];

         $addresses = DeliveryAddress::where('user_id', Auth::user()->id)->get();


        return view('Ecommerce.checkout.direct_checkout', [
            'cartItems' => [$item],
            'total' => $final_price,
            'totalPrice' =>$totalPrice,
            'totalTax' =>$totalTax,
            'tips' =>$tips,
            'banks' =>$banks,
            'countries'=>$countries,
            'address'=>$addresses
        ]);

    }

    public function placeOrder(Request $request)
    {
        // dd($request->all());
        if($request->payment_method==="Bank Transfer"){
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                // 'address_id' => 'required|exists:delivery_address,id',
                'bank_name' => 'nullable|string|max:255',
                'transaction_number' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        }else{
            // dd("other");
            $request->validate([
                // 'address_id' => 'required',
                'payment_method' => 'required',
            ]);
        }
        $data = $request->all();
        // dd($data);

        if($request->input('address')==="current_address"){
            $current_lat= $request->input('current_lat');
            $current_long= $request->input('current_lng');
            $user_delivery_address=Auth::user();
            // dd($user_delivery_address);
        }elseif($request->input('address_id')){
            $deliveryAddresses = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
            $delivery_address = DeliveryAddress::find($request->input('address_id'));
            // dd($delivery_address);
        }else{
        }
        $tipAmount = 0;
        if ($request->tip_option) {
            if (is_numeric($request->tip_option)) {
                $tipAmount = $request->tip_option;
            }
        }
        // dd($tipAmount);
        DB::beginTransaction();

        $grand_total = $data['final_price'] + $data['shipping'] + $tipAmount+ $data['tax'] - Session::get('couponAmount');

        Session::put('grand_total', $grand_total);

        $user_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->order_code = $user_code;
        if($request->input('address')==="current_address"){
            $order->name = $user_delivery_address->name;
            $order->address = $user_delivery_address->address;
            $order->city = $user_delivery_address->city;
            $order->state = $user_delivery_address->state;
            $order->country = $user_delivery_address->country;
            $order->pincode = $user_delivery_address->pincode;
            $order->mobile = $user_delivery_address->mobile;
            $order->latitude = $request->input('current_lat', null);
            $order->longitude = $request->input('current_lng', null);
        }else{
            $order->name = $deliveryAddresses['name'];
            $order->address = $deliveryAddresses['address'];
            $order->city = $deliveryAddresses['city'];
            $order->state = $deliveryAddresses['state'];
            $order->country = $deliveryAddresses['country'];
            $order->pincode = $deliveryAddresses['pincode'];
            $order->mobile = $deliveryAddresses['mobile'];
            $order->latitude = $delivery_address->latitude ?? $request->input('current_lat', null);
            $order->longitude = $delivery_address->longitude ?? $request->input('current_lng', null);
        }

        $order->email = Auth::user()->email;
        $order->shipping_charges = $data['shipping'];
        $order->tax_charge = $data['tax'];
        $order->coupon_code = Session::get('couponCode');
        $order->coupon_amount = Session::get('couponAmount');
        $order->order_status = 'new';
        $order->payment_method = $data['payment_method'];
        $order->payment_gateway = $data['payment_method'];
        $order->grand_total = $grand_total;
        $order->tip_amount= $tipAmount;
        $order->save();

        $order_id = DB::getPdo()->lastInsertId();

        if($request->payment_method==="Bank Transfer"){
        $payment= new EcommerceOrderPaymentInfo();
        $payment->orders_id=$order_id;
        $payment->user_id=Auth::id();
        $payment->bank_name=$request->input('bank_name');
        $payment->transaction_number=$request->input('transaction_number');
        $payment->receipt=$request->file('receipt')->store('ecommerce', 'public');;
        $payment->amount_paid=$grand_total;
        $payment->save();
        }
            $cartItem = new OrderProduct();
            $cartItem->order_id = $order_id;
            $cartItem->user_id = Auth::user()->id;
            $getProductDetails = Product::select('product_code', 'product_name', 'product_color', 'admin_id', 'vendor_id')->where('id', $data['product_id'])->first()->toArray();
            $vendor_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $cartItem->admin_id = $getProductDetails['admin_id'];
            $cartItem->vendor_id = $getProductDetails['vendor_id'];
            $cartItem->order_product_code = $vendor_code;
            $cartItem->product_id = $data['product_id'];
            $cartItem->product_code = $getProductDetails['product_code'];
            $cartItem->product_name = $getProductDetails['product_name'];
            $cartItem->product_color = $getProductDetails['product_color'];
            $cartItem->product_size = $data['size']??'';

            if ($data['size']) {
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);
            }else{
            $getDiscountAttributePrice = Product::getDiscountProductPrice($data['product_id']);

            }
            $discount = Discount::where('product_id', operator: $data['product_id'])
                ->where('min_product', '<=', value: $data['quantity'])
                ->where('max_product', '>=', $data['quantity'])
                ->where('status', 1)
                ->first();

            $total_prices = 0;
            $product_total_price = $getDiscountAttributePrice['final_price'];

            $product_total_price_for_commication = $product_total_price;
            $total_item_price = $product_total_price_for_commication * $data['quantity'];

            $product_total_price_after_discount=0;
            if ($discount) {
                if ($discount->discount_type === "Discounted Price") {
                    $product_total_price_after_discount = $product_total_price - $discount->amount;
                }
                if ($discount->discount_type === "Percentage") {
                    $discountAmount = $product_total_price * ($discount->amount / 100);
                    $product_total_price_after_discount = $product_total_price - $discountAmount;
                }
            }
                  $itemSubtotal = $product_total_price_after_discount * $data['quantity'];
                // dd($itemSubtotal);

                $product = Product::find($data['product_id']);
                $vendor = Vendor::find($product->vendor_id);
                $commissionRate = $vendor->commission ?? 5; // default to 10%

                // Admin commission and vendor earning
                $adminCommission = round($itemSubtotal * $commissionRate / 100, 2);
                $vendorEarning = $itemSubtotal - $adminCommission;

                $vendorId=$vendor->id;
                $vendorWallet = VendorWallet::firstOrCreate(['vendor_id' => $vendorId]);
                $vendorWallet->available_balance += $vendorEarning;
                $vendorWallet->save();

                VendorWalletTransaction::create([
                    'vendor_id' => $vendorId,
                    'type' => 'credit',
                    'amount' => $vendorEarning,
                    'description' => 'Earning from order #'.$order_id
                ]);
            $total_prices += $product_total_price_after_discount;
            if ($discount) {
                $cartItem->discounted_price = $total_prices;
            }

            $cartItem->product_price = $product_total_price;
            $cartItem->product_qty = $data['quantity'];

            if ($discount) {
                $cartItem->discount_type = $discount->discount_type;
                $cartItem->specail_discount = $discount->amount;
            }
            $cartItem->save();
            if ($data['size']) {
                $getProductStock = ProductAttribute::isStokAvailable(product_id: $data['product_id'], size: $data['size']);
                $newStock = $getProductStock - $data['quantity'];
                ProductAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->update(['stock' => $newStock]);
            }else{
                $getProductStock = Product::getProductStock($data['product_id']); // your custom method
                $newStock = $getProductStock - $data['quantity'];
                Product::where('id', $data['product_id'])->update(['quantity' => $newStock]);
            }
            if (Session::has('referral_token')) {
                $commission_amount = SalesMainCommission::first();
                $token = Session::get('referral_token');
                $commissionAmount = $total_item_price * ($commission_amount->commission_amount / 100);
                $commission = new SalesCommission();
                $commission->salesperson_id = SalesCommission::getSalespersonIdFromToken($token);
                $commission->order_id = $order_id;
                $commission->product_id = $data['product_id'];
                $commission->amount = $commissionAmount;
                $commission->save();
            }

        Session::forget('referral_token');
        Session::put('order_id', $order_id);
        DB::commit();
        $order = Order::with('orders_products')->where('id', $order_id)->first();

         NotificationService::send(
                userId: $order->user_id,
                title: 'Goods Order Placed',
                message: "Your goods order has been successfully placed."
        );

         $phone = $order->user->mobile ?? null;
         if ($phone) {
            $message = "Hi {$order->user->name}, Your Goods Order has been placed.";
            try {
            SmsService::send($phone, $message);
            } catch (\Exception $e) {
            }
         }

        // $pdf = Pdf::loadView('Ecommerce.order.receipt', ['order' => $order]);
        // $pdfPath = storage_path('app/public/receipts/order_' . $order->order_code . '.pdf');
        // $pdf->save($pdfPath); // Save to storage

        // Mail::to($order->email)->queue(new OrderPlaced($order, $pdfPath));
        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully!',
            'redirect_url' => url('/thanks')
        ]);

    }
}
