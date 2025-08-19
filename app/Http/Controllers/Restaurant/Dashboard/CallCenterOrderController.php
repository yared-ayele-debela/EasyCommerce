<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\DeilverySettingRestaurant;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\OrderItem;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Vendor;
use DB;
use Illuminate\Http\Request;
use Str;

class CallCenterOrderController extends Controller
{



      public function getProducts($id)
    {
        $products = Product::where('restaurant_id', $id)->get();
        return response()->json($products);
    }

    //
    public function create()
    {
                        $delivery_settings = DeilverySettingRestaurant::first();


        $restaurants = Restaurant::select('id', 'name', 'latitude', 'longitude')->get();
        return view('Restaurant.dashboard.callcenter.create', compact('restaurants','delivery_settings'));
    }

    /**
     * Calculate shipping between restaurant and user location
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // KM
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // KM
    }

    // Place order for one or multiple restaurants
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $userLat = $request->latitude;
            $userLon = $request->longitude;
            $ordersInput = $request->orders;

            // dd( $request->all());

            foreach ($ordersInput as $restaurantId => $orderData) {
                $restaurant = Restaurant::findOrFail($restaurantId);

                // Calculate delivery fee ($1 per km)
                $distance = $this->calculateDistance(
                    $restaurant->latitude,
                    $restaurant->longitude,
                    $userLat,
                    $userLon
                );
                $delivery_settings = DeilverySettingRestaurant::first();
                $distanceFeePerKm = $delivery_settings->fee_per_km; // ETB per KM

                if ($distance > 1) {
                    $deliveryFee = $delivery_settings->base_amount + ($distance - 1) * $distanceFeePerKm;
                } else {
                    $deliveryFee = $delivery_settings->base_amount;
                }


                // dd($distance, $deliveryFee);
                // Calculate subtotal and total tax for this restaurant order
                $subtotal = 0;
                $totalTax = 0;
                foreach ($orderData['items'] as $item) {
                    $subtotal += $item['total'];
                    $totalTax += isset($item['tax']) ? $item['tax'] : 0;
                }

                $total = $subtotal + $totalTax + $deliveryFee;

                // dd($subtotal, $totalTax, $deliveryFee, $total);
                // Save order
                $order = Order::create([
                    'user_id' => null, // Call center orders may not have user_id
                    'restaurant_id' => $restaurantId,
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'delivery_fee' => $deliveryFee,
                    'total' => $total,
                    'tax' => $totalTax,
                    'tip_amount' => 0,
                    'delivery_code' => strtoupper(Str::random(6)),
                    'status' => 'pending',
                    'delivery_status' => 'pending',
                    'payment_status' => 'unpaid',
                    'payment_method' => 'cash_on_delivery',
                    'address' => $request->address,
                    'city' => $request->city,
                    'sub_city' => $request->sub_city,
                    'street' => $request->street,
                    'state' => $request->state,
                    'mobile' => $request->phone,
                    'latitude' => $userLat,
                    'longitude' => $userLon,
                    'is_call_center' =>1,
                    'is_old' => false, // Assuming new orders
                ]);

                // Save order items
                foreach ($orderData['items'] as $item) {

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
                        'size' => $item['size'] ?? null,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['total'],
                        'picked_code' => strtoupper(Str::random(6)),
                        'admin_commission' => $adminCommission,
                        'vendor_earning' => $vendorEarning
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order(s) placed successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
