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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function showOrderSummary(Request $request)
{
    $getCartItems = Cart::getCartItems();
    if (count($getCartItems)==0) {
        return redirect('my-cart')->with('error', 'Shopping Cart is empty! Please add products to checkout.');
    }
        // dd($getCartItems);


    $countries = Country::where('status', 1)->get();
    $deliveryAddresses = DeliveryAddress::where('user_id', Auth::id())->get();

    $totalPrice = 0;
    $totalTax = 0;
    $totalShipping = 0;

    foreach ($getCartItems as $item) {
        $product = Product::with('vendor')->find($item['product_id']);
        if(!empty($item['size'])){
                $discountPriceData = Product::getDiscountAttributePrice($product->id, $item['size']);    
        }else{
            $discountPriceData=Product::getDiscountProductPrice($item['product_id']);
        }

        $quantity = $item['quantity'];
        $basePrice = $discountPriceData['final_price'];
        $itemTotal = $basePrice * $quantity;

        // Apply volume discount if available
        $discount = Discount::where('product_id', $product->id)
            ->where('min_product', '<=', $quantity)
            ->where('max_product', '>=', $quantity)
            ->where('status', 1)
            ->first();

        if ($discount) {
            $itemTotal -= $discount->discount_type === "Discounted Price"
                ? $discount->amount
                : $itemTotal * ($discount->amount / 100);
        }

        $totalPrice += $itemTotal;

        // Calculate tax
        $taxPercent = $product->product_tax;
        $totalTax += round($itemTotal * $taxPercent / 100, 2);

        // Calculate shipping
        $weight = $item['product']['product_weight'];
        
        $vendor_city=Vendor::where('id',$product->vendor_id)->first();

        // dd($vendor_city);
        $zone = $vendor_city->zone;
        // dd(vars: $zone);
        $shipping = ShippingCharge::getShippingCharges($weight, $zone);
        $totalShipping += $shipping;
    }
    $banks=Bank::all();
    // dd($totalShipping);

    $totalPrice += $totalShipping;
    $tips=Tip::all();

    return view('Ecommerce.checkout.index', compact(
        'countries',
        'getCartItems',
        'totalPrice',
        'totalTax',
        'totalShipping',
        'tips',
        'banks'
    ));
}


    // Place the Order
    public function placeOrder(Request $request)
    {
        // dd($request->all());
        if($request->payment_method==="manual"){
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                'address_id' => 'required|exists:delivery_address,id',
                'bank_name' => 'nullable|string|max:255',
                'transaction_number' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
                // 'accept' => 'required',
            ]);
        }else{
            // dd("other");
            $request->validate([
                'address_id' => 'required',
                'payment_method' => 'required',
                // 'accept' => 'required',
            ]);
        }

        // dd("helldsf");
        $data = $request->all();

        $getCartItems = Cart::getCartItems();
        if (count($getCartItems) == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shopping Cart is empty! Please add products to checkout',
                'redirect_url' => url('my-cart')
            ]);
        }
        $totalShipping = 0;
        $total_price = 0;
        $totalTax = 0;
        foreach ($getCartItems as $item) {
            $totalWeight = 0;

            if(!empty($item['size'])){
              $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            }else{
              $getDiscountAttributePrice = Product::getDiscountProductPrice($item['product_id']);
    
            }
            $product_price = $getDiscountAttributePrice['final_price'];
            $product_quantity = $item['quantity'];

            $product_total_price = $product_price * $product_quantity;

            $product_weight = $item['product']['product_weight'];
            $totalWeight += $product_weight;

            $discount = Discount::where('product_id', $item['product_id'])
                ->where('min_product', '<=', $product_quantity)
                ->where('max_product', '>=', $product_quantity)
                ->where('status', 1)
                ->first();

            if ($discount) {
                if ($discount->discount_type === "Discounted Price") {
                    $product_total_price_after_discount = $product_total_price - $discount->amount;
                }
                if ($discount->discount_type === "Percentage") {
                    $discountAmount = $product_total_price * ($discount->amount / 100);
                    $product_total_price_after_discount = $product_total_price - $discountAmount;
                }
            } else {
                $product_total_price_after_discount = $product_total_price;
            }

            $total_price += $product_total_price_after_discount;

            $get_tax_percent = Product::select('product_tax')->where('id', $item['product_id'])->first();
            $tax_percent = $get_tax_percent->product_tax;
            $tax_amount = round($product_total_price_after_discount * $tax_percent / 100, 2);
            $totalTax += $tax_amount;

            $product=Product::where('id',$item['product_id'])->first();
            // dd($product);
            $vendor_city=Vendor::where('id',$product->vendor_id)->first();
            $city=$vendor_city->zone;

            $shipping = ShippingCharge::getShippingCharges($totalWeight, $city);
            $totalShipping += $shipping;

        }

        foreach ($getCartItems as $item) {
            $product_status = Product::getProductStatus($item['product_id']);
            if ($product_status == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.",
                    'redirect_url' => url('my-cart')
                ]);

            }
            if(!empty($item['size'])){
                //prvent sold out product to order
                $getProductStock = ProductAttribute::isStokAvailable($item['product_id'], $item['size']);
                if ($getProductStock == 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.",
                        'redirect_url' => url('my-cart')
                    ]);

                }
         
            //Prevent Disabled out ProductAttributes to Order
            $getAttributeStatus = ProductAttribute::getAttributeStatus($item['product_id'], $item['size']);
            if ($getAttributeStatus == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.",
                    'redirect_url' => url('my-cart')
                ]);
            }
              }
            //Prevent disabled Categories product to order
            $getCategoryStatus = Category::getCategoryStatus($item['product']['category_id']);
            if ($getCategoryStatus == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.",
                    'redirect_url' => url('my-cart')
                ]);
            }
        }

        $deliveryAddresses = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();

        $tipAmount = 0;
        if ($request->tip_option) {
            if (is_numeric($request->tip_option)) {
                $tipAmount = $request->tip_option;
            }
        }
        // dd($tipAmount);
        DB::beginTransaction();


        $grand_total = $total_price + $totalShipping + $tipAmount+ $totalTax - Session::get('couponAmount');

        // dd($grand_total);
        $get_currency = Session::get('currency_code');
        Session::put('grand_total', $grand_total);

        $user_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->order_code = $user_code;
        $order->name = $deliveryAddresses['name'];
        $order->address = $deliveryAddresses['address'];
        $order->city = $deliveryAddresses['city'];
        $order->state = $deliveryAddresses['state'];
        $order->country = $deliveryAddresses['country'];
        $order->pincode = $deliveryAddresses['pincode'];
        $order->mobile = $deliveryAddresses['mobile'];
        $order->email = Auth::user()->email;
        $order->shipping_charges = $totalShipping;
        $order->tax_charge = $totalTax;
        $order->coupon_code = Session::get('couponCode');
        $order->coupon_amount = Session::get('couponAmount');
        $order->order_status = 'new';
        $order->payment_method = $data['payment_method'];
        $order->payment_gateway = $data['payment_method'];
        $order->grand_total = $grand_total;
        $order->tip_amount= $tipAmount;
        $order->save();

        $order_id = DB::getPdo()->lastInsertId();

        if($request->payment_method==="manual"){
        $payment= new EcommerceOrderPaymentInfo();
        $payment->orders_id=$order_id;
        $payment->user_id=Auth::id();
        $payment->bank_name=$request->input('bank_name');
        $payment->transaction_number=$request->input('transaction_number');
        $payment->receipt=$request->file('receipt')->store('ecommerce', 'public');;
        $payment->amount_paid=$grand_total;
        $payment->save();
        }
        foreach ($getCartItems as $item) {
            $cartItem = new OrderProduct();
            $cartItem->order_id = $order_id;
            $cartItem->user_id = Auth::user()->id;
            $getProductDetails = Product::select('product_code', 'product_name', 'product_color', 'admin_id', 'vendor_id')->where('id', $item['product_id'])->first()->toArray();
            $vendor_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $cartItem->admin_id = $getProductDetails['admin_id'];
            $cartItem->vendor_id = $getProductDetails['vendor_id'];
            $cartItem->order_product_code = $vendor_code;
            $cartItem->product_id = $item['product_id'];
            $cartItem->product_code = $getProductDetails['product_code'];
            $cartItem->product_name = $getProductDetails['product_name'];
            $cartItem->product_color = $getProductDetails['product_color'];
            $cartItem->product_size = $item['size']??'';

             if(!empty($item['size'])){
              $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            }else{
              $getDiscountAttributePrice = Product::getDiscountProductPrice($item['product_id']);
    
            }
            $discount = Discount::where('product_id', $item['product_id'])
                ->where('min_product', '<=', $product_quantity)
                ->where('max_product', '>=', $product_quantity)
                ->where('status', 1)
                ->first();

            $total_prices = 0;
            $product_total_price = $getDiscountAttributePrice['final_price'];

            $product_total_price_for_commication = $product_total_price;
            $total_item_price = $product_total_price_for_commication * $item['quantity'];

            if ($discount) {
                if ($discount->discount_type === "Discounted Price") {
                    $product_total_price_after_discount = $product_total_price - $discount->amount;
                }
                if ($discount->discount_type === "Percentage") {
                    $discountAmount = $product_total_price * ($discount->amount / 100);
                    $product_total_price_after_discount = $product_total_price - $discountAmount;
                }
            }

            $total_prices += $product_total_price_after_discount;
            if ($discount) {
                $cartItem->discounted_price = $total_prices;
            }

            $cartItem->product_price = $product_total_price;
            $cartItem->product_qty = $item['quantity'];

            if ($discount) {
                $cartItem->discount_type = $discount->discount_type;
                $cartItem->specail_discount = $discount->amount;
            }
            $cartItem->save();
            if ($item['size']) {
                $getProductStock = ProductAttribute::isStokAvailable(product_id: $item['product_id'], size: $item['size']);
                $newStock = $getProductStock - $item['quantity'];
                ProductAttribute::where(['product_id' => $item['product_id'], 'size' => $item['size']])->update(['stock' => $newStock]);
            }else{
                $getProductStock = Product::getProductStock($item['product_id']); // your custom method
                $newStock = $getProductStock - $item['quantity'];
                Product::where('id', operator: $item['product_id'])->update(['quantity' => $newStock]);
            }
          
            if (Session::has('referral_token')) {
                $commission_amount = SalesMainCommission::first();
                $token = Session::get('referral_token');
                $commissionAmount = $total_item_price * ($commission_amount->commission_amount / 100);
                $commission = new SalesCommission();
                $commission->salesperson_id = SalesCommission::getSalespersonIdFromToken($token);
                $commission->order_id = $order_id;
                $commission->product_id = $item['product_id'];
                $commission->amount = $commissionAmount;
                $commission->save();
            }
        }

        Session::forget('referral_token');
        Session::put('order_id', $order_id);
        DB::commit();
        $order = Order::with('orders_products')->where('id', $order_id)->first();

        $pdf = Pdf::loadView('Ecommerce.order.receipt', ['order' => $order]);
        $pdfPath = storage_path('app/public/receipts/order_' . $order->order_code . '.pdf');
        $pdf->save($pdfPath); // Save to storage

        Mail::to($order->email)->queue(new OrderPlaced($order, $pdfPath));
        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully!',
            'redirect_url' => url('/thanks')
        ]);

    }

    // app/Http/Controllers/CheckoutController.php
    public function calculateShipping(Request $request)
    {
        $request->validate(['address_id' => 'required|exists:delivery_address,id']);
        $address=DeliveryAddress::where('id',$request->address_id)->first();
        $getCartItems = Cart::getCartItems();

        $totalShipping = 0;

        foreach ($getCartItems as $item) {
            $totalWeight = 0;

            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            $product=Product::where('id',$item['product_id'])->first();
            // dd($product);
            $vendor_city=Vendor::where('id',$product->vendor_id)->first();
            $city=$vendor_city->city;

            // dd($vendor_city);
            $product_quantity = $item['quantity'];
            $product_weight = $item['product']['product_weight'];
            $totalWeight += $product_weight;


            // dd($product_weight);
            $shipping = ShippingCharge::getShippingCharges($totalWeight, $city);
            // dd($shipping);
            $totalShipping += $shipping;
        }

        return response()->json(['fee' => $totalShipping]);
    }



}