<?php

namespace App\Http\Controllers\Restaurant\Frontend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Restaurant\OrderConfirmationMail;
use App\Models\Bank;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\DeliverySetting;
use App\Models\Restaurant\Coupon;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use App\Models\Restaurant\OrderPaymentInfo;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantCartItem;
use App\Models\ShippingCharge;
use App\Models\Tip;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    //

    public function calculateShipping(Request $request)
{
    $addressId = $request->address_id;
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
    $cart = Helper::RestaurantCartItems();

    $vendorShipping = [];
    $subtotal = 0;

    foreach ($cart as $item) {
        $product = Product::find($item['product_id']);
        if (!$product || !$product->restaurant) continue;

        $vendorId = $product->restaurant->admin_id;

        $vendorLat = $product->restaurant->latitude;
        $vendorLng = $product->restaurant->longitude;

        $customerLat = $address->latitude;
        $customerLng = $address->longitude;

        $distance = $this->calculateDistances($vendorLat, $vendorLng, $customerLat, $customerLng);
        $weight = $product->weight ?? 1;
        $zone = $product->restaurant->zone;

        // Get shipping charge per vendor
        $baseShipping = ShippingCharge::getShippingCharges($weight, zone: $zone); // ← Modify this method to accept vendor

        $delivery_settings=DeliverySetting::first();
        $distanceFeePerKm = $delivery_settings->fee_per_km; // ETB per KM
        $distanceShipping = $distance * $distanceFeePerKm;

        $shipping = $baseShipping + $distanceShipping;

        // Grouping shipping per vendor
        if (!isset($vendorShipping[$vendorId])) {
            $vendorShipping[$vendorId] = [
                'shipping' => 0,
                'products' => [],
            ];
        }

        $vendorShipping[$vendorId]['shipping'] += $shipping;
        $vendorShipping[$vendorId]['products'][] = $product->id;

        $subtotal += $item['price'];
    }
    // Sum final shipping from all vendors
    $finalShipping = collect($vendorShipping)->sum('shipping');

    $totalAmount = $subtotal + $finalShipping;

    // dd($finalShipping, $totalAmount, $vendorShipping);
    return response()->json([
        'success' => true,
        'shipping_fee' => number_format($finalShipping, 2),
        'total_amount' => number_format($totalAmount, 2),
        'vendor_details' => $vendorShipping // Optional: useful for debugging
    ]);
}
    public function orderNowcalculateShipping(Request $request)
{
    $addressId = $request->address_id;
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
    $cart = session()->get('order_now_cart', []);
    // dd($cart);

    $vendorShipping = [];
    $subtotal = 0;

    foreach ($cart as $item) {
        $product = Product::find($item['product_id']);
        if (!$product || !$product->restaurant) continue;

        $vendorId = $product->restaurant->admin_id;

        $vendorLat = $product->restaurant->latitude;
        $vendorLng = $product->restaurant->longitude;

        $customerLat = $address->latitude;
        $customerLng = $address->longitude;

        $distance = $this->calculateDistances($vendorLat, $vendorLng, $customerLat, $customerLng);
        $weight = $product->weight ?? 1;
        $zone = $product->restaurant->zone;

        // Get shipping charge per vendor
        $baseShipping = ShippingCharge::getShippingCharges($weight, zone: $zone); // ← Modify this method to accept vendor

        $delivery_settings=DeliverySetting::first();
        $distanceFeePerKm = $delivery_settings->fee_per_km; // ETB per KM
        $distanceShipping = $distance * $distanceFeePerKm;

        $shipping = $baseShipping + $distanceShipping;

        // Grouping shipping per vendor
        if (!isset($vendorShipping[$vendorId])) {
            $vendorShipping[$vendorId] = [
                'shipping' => 0,
                'products' => [],
            ];
        }

        $vendorShipping[$vendorId]['shipping'] += $shipping;
        $vendorShipping[$vendorId]['products'][] = $product->id;

        $subtotal += $item['price'];
    }
    // Sum final shipping from all vendors
    $finalShipping = collect($vendorShipping)->sum('shipping');

    $totalAmount = $subtotal + $finalShipping;

    // dd($finalShipping, $totalAmount, $vendorShipping);
    return response()->json([
        'success' => true,
        'shipping_fee' => number_format($finalShipping, 2),
        'total_amount' => number_format($totalAmount, 2),
        'vendor_details' => $vendorShipping // Optional: useful for debugging
    ]);
}


private function calculateDistances($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Radius in KM
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earthRadius * $c;

    return $distance;
}

    public function index()
    {
        $cart =Helper::RestaurantCartItems();
        // Check if cart is empty
        if (count($cart) === 0) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        session(['cart_subtotal' => $subtotal]);
        $countries = Country::all();
        $tips = Tip::all();

        // dd($cart);
        $totalTax = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue; // Skip if product doesn't exist
            $restaurant = Restaurant::find($product->restaurant_id);
            if (!$restaurant) continue; // Skip if restaurant not found


            $subtotal = $product->price * $item['quantity'];
            $taxAmount = round($subtotal * ($product->product_tax / 100), 2);
            $totalTax += $taxAmount;

        }
        // dd($totalShipping);
        $banks=Bank::all();
        $addresses = DeliveryAddress::where('user_id', Auth::user()->id)->get();

        return view('Restaurant.frontend.checkout.index', compact('addresses','totalTax','banks','tips', 'cart', 'subtotal', 'countries'));
    }


    public function placeOrder(Request $request)
    {
        // dd( session()->get('cart_subtotal', 0));
        // try{
        if ($request->payment_method === "Bank Transfer") {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                // 'address_id' => 'required|exists:delivery_address,id',
                'bank_name' => 'nullable|string|max:255',
                'transaction_number' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                // 'address_id' => 'required|exists:delivery_address,id',
            ]);
        }

       if($request->input('address')==="current_address"){

        } elseif( $request->input('address_id')){
            $delivery_address = DeliveryAddress::find($request->input('address_id'));
        }
        else{
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cart = Helper::RestaurantCartItems();
        // Check if cart is empty
        if (count($cart) === 0) {
            return back()->with('error', 'Your cart is empty.');
        }
        $tipAmount = 0;
        if ($request->tip_option) {
            if (is_numeric($request->tip_option)) {
                $tipAmount = $request->tip_option;
            }
        }


        // dd($tipAmount);
        $subtotal = session()->get('cart_subtotal', 0);
        $discount = session()->get('discount', 0);
        $delivery_fee = $request->input('delivery_fee', 0);
        $totalTax= $request->input('tax', 0);
        // dd($subtotal,$discount,$delivery_fee,$tipAmount);
        $total = max(($subtotal - $discount), 0) + $delivery_fee + $tipAmount + $totalTax;

        // dd($total);
        DB::beginTransaction();

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->delivery_fee = $delivery_fee;
        $order->total = $total;
        $order->tax = $request->input('tax', 0);
        $order->tip_amount = $tipAmount;
        $order->delivery_code = strtoupper(Str::random(6));
        $order->status = 'pending';
        $order->payment_method = $request->input('payment_method');

        if($request->input('address')==="current_address"){
            $order->address = Auth::user()->address ?? '';
            $order->city = Auth::user()->city ?? '';
            $order->state = Auth::user()->state ?? '';
            $order->mobile = Auth::user()->mobile;
            $order->latitude = $request->input('current_lat', null);
            $order->longitude = $request->input('current_lng', null);
        }elseif($request->input('address_id')){
         $order->delivery_address_id = $delivery_address->id;

        $order->address = $delivery_address->address ?? '';
        $order->city = $delivery_address->city ?? '';
        $order->sub_city = $delivery_address->sub_city ?? '';
        $order->street = $delivery_address->street ?? '';
        $order->state = $delivery_address->state ?? '';
        $order->mobile = $delivery_address->mobile ?? Auth::user()->mobile;
        $order->latitude = $delivery_address->latitude ?? $request->input('current_lat', null);
        $order->longitude = $delivery_address->longitude ?? $request->input('current_lng', null);
        }else{

        }
        $order->save();

        foreach ($cart as $item) {

            $itemSubtotal=$item['price'] * $item['quantity'];
                $product=Product::findOrFail($item['product_id']);
                $vendor = Vendor::find($product->vendor_id);
                $commissionRate = $vendor->commission ?? 5; // default to 10%

                // Admin commission and vendor earning
                $adminCommission = round( $itemSubtotal * $commissionRate / 100, 2);
                $vendorEarning = $itemSubtotal - $adminCommission;


                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'size' => $item['size'] ? $item['size'] : '',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                    'picked_code' => strtoupper(Str::random(6)),
                    'admin_commission'=>$adminCommission,
                    'vendor_earning'=>$vendorEarning
                ]);


                if(isset($vendor->id)){
                $vendorId=$vendor->id;
                $vendorWallet = VendorWallet::firstOrCreate(['vendor_id' => $vendorId]);
                $vendorWallet->available_balance += $vendorEarning;
                $vendorWallet->save();

                VendorWalletTransaction::create([
                    'vendor_id' => $vendorId,
                    'type' => 'credit',
                    'amount' => $vendorEarning,
                    'description' => 'Earning from Restaurant order #'.$order->id
                ]);
            }

        }



        if ($request->payment_method === "Bank Transfer") {
            $payment = new OrderPaymentInfo();
            $payment->restaurant_orders_id = $order->id;
            $payment->user_id = Auth::user()->id;
            $payment->bank_name = $request->input('bank_name');
            $payment->transaction_number = $request->input('transaction_number');
            $payment->receipt = $request->file('receipt')->store('restaurant', 'public');;
            $payment->amount_paid = $total;
            $payment->save();
        }

         NotificationService::send(
                userId: $order->user_id,
                title: 'Food Order Placed',
                message: "Your food order has been successfully placed."
            );


        $phone = $order->user->mobile ?? null;
        if ($phone) {
            // dd($phone);
            $message = "Hi {$order->user->name}, Your Food Order has been placed.";
            try {
            SmsService::send($phone, $message);
            } catch (\Exception $e) {
            }
        }

        // Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

        DB::commit();
        session()->forget(['cart', 'cart_subtotal', 'discount']); // Clear cart session after successful order
        session()->forget(['order_now_cart', 'order_now_cart_subtotal', 'order_now_discount']); // Clear cart session after successful order

        $cart= RestaurantCartItem::where('user_id', Auth::id())->delete(); // Clear cart from database
        return redirect()->route('restaurant.order.success', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully.');
        // } catch (\Exception $e) {
        //     DB::rollBack(); // Rollback transaction on error
        //     return back()->with('error', 'Something went wrong. Please try again.')->withErrors($e->getMessage());
        // }
    }

    public function orderNowPage(Request $request)
    {

        // dd($request->all());
        $countries = Country::all();
        $banks=Bank::all();
        $tips=Tip::all();
        $order_now_cart = session()->get('order_now_cart', []);
        if (empty($order_now_cart)) {
            return redirect()->back()->with('error', 'No items in the order now cart.');
        }
        $subtotal = collect($order_now_cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        session(['order_now_cart_subtotal' => $subtotal]);
        $totalTax = 0;
        $totalShipping = 0;

        foreach ($order_now_cart as $item) {
            $product = Product::find(id: $item['product_id']);
            if (!$product) continue; // Skip if product doesn't exist
            $restaurant = Restaurant::find($product->restaurant_id);
            if (!$restaurant) continue; // Skip if restaurant not found
            $zone = $restaurant->zone;
            $weight = $item['quantity'] * $product->weight; // Assume 1kg per product, customize this as needed
            $shipping = ShippingCharge::getShippingCharges($weight, $zone);

            $totalShipping += $shipping;

            $subtotal = $product->price * $item['quantity'];
            $taxAmount = round($subtotal * ($product->product_tax / 100), 2);
            $totalTax += $taxAmount;

        }

        $addresses = DeliveryAddress::where('user_id', Auth::user()->id)->get();


        return view('Restaurant.frontend.checkout.order_now.index', compact('addresses','countries', 'banks', 'tips', 'subtotal', 'totalTax', 'totalShipping'));
    }

    public function PlaceOrderNow(Request $request)
    {

        // dd($request->all());
        if ($request->payment_method === "Bank Transfer") {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                // 'address_id' => 'required|exists:delivery_address,id',
                'bank_name' => 'nullable|string|max:255',
                'transaction_number' => 'nullable|string|max:255',
                'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|string',
                // 'address_id' => 'required|exists:delivery_address,id',
            ]);
        }
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if($request->input('address')==="current_address"){

        }elseif( $request->input('address_id')){
            $delivery_address = DeliveryAddress::find($request->input('address_id'));
        }else{
        }

        $order_now_cart = session()->get('order_now_cart', []);
        if (empty($order_now_cart)) {
            return back()->with('error', 'Your order now cart is empty.');
        }
         $totalTax = 0;

        foreach ($order_now_cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue; // Skip if product doesn't exist
            $restaurant = Restaurant::find($product->restaurant_id);
            if (!$restaurant) continue; // Skip if restaurant not found

            $subtotal = $product->price * $item['quantity'];
            $taxAmount = round($subtotal * ($product->product_tax / 100), 2);
            $totalTax += $taxAmount;

        }
        // dd($totalTax);
        $tipAmount = 0;
        if ($request->tip_option) {
            if (is_numeric($request->tip_option)) {
                $tipAmount = $request->tip_option;
            }
        }

        $subtotal = session()->get('order_now_cart_subtotal', 0);
        $discount = session()->get('order_now_discount', 0);
        // dd($discount);
        $delivery_fee = $request->input('delivery_fee', 0);
    //    dd($delivery_fee);

        $total = max(($subtotal - $discount), 0) + $delivery_fee + $tipAmount + $totalTax;


        // dd($total);
        DB::beginTransaction();


        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->delivery_fee = $request->delivery_fee;
        $order->total = $total;
        $order->tax = $request->input('tax', 0);
        $order->tip_amount = $tipAmount;
        $order->delivery_code = strtoupper(Str::random(6));
        $order->status = 'pending';
        $order->payment_method = $request->input('payment_method');
        if($request->input('address_id')==="current_address"){
            $order->address = Auth::user()->address ?? '';
            $order->city = Auth::user()->city ?? '';
            $order->state = Auth::user()->state ?? '';
            $order->mobile = Auth::user()->mobile;
            $order->latitude = $request->input('current_lat', null);
            $order->longitude = $request->input('current_lng', null);
        }else{
        $order->delivery_address_id = $delivery_address->id;
        $order->address = $delivery_address->address ?? '';
        $order->city = $delivery_address->city ?? '';
        $order->sub_city = $delivery_address->sub_city ?? '';
        $order->street = $delivery_address->street ?? '';
        $order->state = $delivery_address->state ?? '';
        $order->mobile = $delivery_address->mobile ?? Auth::user()->mobile;
        $order->latitude = $delivery_address->latitude ?? $request->input('current_lat', null);
        $order->longitude = $delivery_address->longitude ?? $request->input('current_lng', null);
        }
        $order->save();

        foreach ($order_now_cart as $item) {
                $itemSubtotal=$item['price']* $item['quantity'];
                $product=Product::findOrFail($item['product_id']);
                $vendor = Vendor::find($product->vendor_id);
                $commissionRate = $vendor->commission ?? 5; // default to 10%

                // Admin commission and vendor earning
                $adminCommission = round( $itemSubtotal * $commissionRate / 100, 2);
                $vendorEarning = $itemSubtotal - $adminCommission;


            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'size' => isset($item['size']) ? $item['size'] : '',
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
                'picked_code' => strtoupper(Str::random(6)),
                'admin_commission'=>$adminCommission,
                'vendor_earning'=>$vendorEarning
            ]);

                if(isset($vendor->id)){
                $vendorId=$vendor->id;
                $vendorWallet = VendorWallet::firstOrCreate(['vendor_id' => $vendorId]);
                $vendorWallet->available_balance += $vendorEarning;
                $vendorWallet->save();

                VendorWalletTransaction::create([
                    'vendor_id' => $vendorId,
                    'type' => 'credit',
                    'amount' => $vendorEarning,
                    'description' => 'Earning from Restaurant order #'.$order->id
                ]);
            }

        }
        if ($request->payment_method === "Bank Transfer") {
            $payment = new OrderPaymentInfo();
            $payment->restaurant_orders_id = $order->id;
            $payment->user_id = Auth::user()->id;
            $payment->bank_name = $request->input('bank_name');
            $payment->transaction_number = $request->input('transaction_number');
            if ($request->hasFile('receipt')) {
                $payment->receipt = $request->file('receipt')->store('restaurant', 'public');
            }
            $payment->amount_paid = $total;
            $payment->save();
        }

          NotificationService::send(
                userId: $order->user_id,
                title: 'Food Order Placed',
                message: "Your food order has been successfully placed."
            );

             $phone = $order->user->mobile ?? null;
            if ($phone) {
                // dd($phone);
                $message = "Hi {$order->user->name}, Your Food Order has been placed.";
                try {
                SmsService::send($phone, $message);
                } catch (\Exception $e) {
                }
            }

        // Mail::to(Auth::user()->email)->send(mailable: new OrderConfirmationMail($order));
        DB::commit();
        session()->forget(['order_now_cart', 'order_now_cart_subtotal', 'order_now_discount']); // Clear order now cart session after successful order
        return redirect()->route('restaurant.order.success', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully.');
        // } catch (\Exception $e) {
        //     DB::rollBack(); // Rollback transaction on error
        //     return back()->with('error', 'Something went wrong. Please try again.')->withErrors($e->getMessage());
        // }
    }

    public function orderNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|integer|min:1',
        ]);


        $product = Product::findOrFail($request->product_id);

        $restaurant = $product->restaurant;

        $userLat = $request->input('user_lat');
        $userLng = $request->input('user_lng');

        if (!$userLat || !$userLng) {
            return back()->withErrors("Location is required to place the order.");
        }

        $distance = $this->calculateDistance($userLat, $userLng, $restaurant->latitude, $restaurant->longitude);
        if ($distance > $restaurant->delivery_radius) {
            return back()->withErrors("You are out of the delivery range.");
        }
        // Clear existing cart
        session()->forget(keys: ['order_now_cart', 'order_now_cart_subtotal', 'order_now_discount']); // Clear cart session after successful order

        $quantity = $request->qty;
        $price = $request->price;

        $order_now_cart = [
            $product->id => [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'size' => $request->size,
            ],
        ];

        // Save to session
        session([
            'order_now_cart' => $order_now_cart,
            'order_now_cart_subtotal' => $price,
            'order_now_discount' => 0, // No coupon applied yet
        ]);

        return redirect()->route('restaurant.checkout.orderNowPage');
    }

    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = 6371; // km

    $latFrom = deg2rad($lat1);
    $lonFrom = deg2rad($lng1);
    $latTo = deg2rad($lat2);
    $lonTo = deg2rad($lng2);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    return $earthRadius * $angle;
}

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;

        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', 1)
            ->whereDate('validated_date', '>=', now())
            ->first();
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.'], 400);
        }
        $discountAmount = $coupon->type === 'fixed'
            ? $coupon->value
            : ($coupon->value) / 100;
        session(['discount' => $discountAmount]);
        session(['order_now_discount' => $discountAmount]);

        return response()->json(['success' => true]);
    }
}
