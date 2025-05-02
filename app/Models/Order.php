<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable = [
        'user_id', 'order_code', 'delivery_boy_id', 'name', 'address', 'city', 'state', 
        'country', 'pincode', 'latitude', 'longitude', 'mobile', 'email', 
        'shipping_charges', 'tax_charge', 'coupon_code', 'coupon_amount', 
        'order_status', 'payment_method', 'payment_gateway', 'grand_total', 
        'transaction_id', 'payment_currency', 'courier_name', 'tracking_number','screenshot_path'
    ];


    public function deliveryBoy()
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders_products(){

      return $this->hasMany('App\Models\OrderProduct','order_id');
    }

    public static function getOrderStatus($order_id){
        $getOrderStatus=Order::select('order_status')->where('id',$order_id)->first();
        return $getOrderStatus->order_status;
    }

    public static function countOrdersForVendor($vendorId) {
        $ordersCount = DB::table('orders')
        ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
        ->where('orders_products.vendor_id', $vendorId)
        ->count();

        return $ordersCount;
    }


    //to count order return request for vendor
    public static function countReturnRequestForVendor($vendorId){

        $vendor_type=Auth::guard('admin')->user()->type;

        if($vendor_type=="vendor"){
            $order = DB::table('orders')
            ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
            ->where('orders_products.vendor_id', $vendorId)->get();
            $count=0;
            foreach ($order as $order) {
                // Access each order's order_id here
                $return_request = ReturnRequest::where('order_id',$order->order_id)->get()->toArray();
                if($return_request){
                    $count++;
                }
            }
            return $count;
        }
    }

    public static function checkOrderProductAvalible($id){
        $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
        foreach($orderDetails['orders_products'] as $product){
            if($product['item_status']!="Return Initiated"){
                return true;
            }else{
                continue;
            }

        }
        return false;
    }


    //to calculate profit.....

    public function calculateProfit()
    {
        $orders = Order::all();
        $totalRevenue = $orders->sum('grand_total');
        $totalCosts = $orders->sum('shipping_charges') + $orders->sum('tax_charge');
        $profit = $totalRevenue - $totalCosts;
        return $profit;
    }

    public function calculateTotalPayment()
    {
        $orders = Order::all();
        $totalPayment = $orders->sum('grand_total');

        return $totalPayment;
    }


    public function calculateTotalTaxPayments()
    {
        $orders = Order::all();

        $totalTaxPayments = $orders->sum('tax_charge');

        return $totalTaxPayments;
    }


    public function calculateProfits()
     {

    $orders = Order::all();
    // Calculate current date and time
    $now = Carbon::now();

    // Last week start date and end date
    $lastWeekStartDate = $now->startOfWeek()->subWeek()->startOfDay();
    $lastWeekEndDate = $now->startOfWeek()->subDay()->endOfDay();

        // This week start date and end date
    $thisWeekStartDate = $now->startOfWeek();
    $thisWeekEndDate = $now->endOfWeek();


    // This month start date and end date
    $thisMonthStartDate = $now->startOfMonth();
    $thisMonthEndDate = $now->endOfMonth();

    // Last month start date and end date
    $lastMonthStartDate = $now->subMonth()->startOfMonth();
    $lastMonthEndDate = $now->subMonth()->endOfMonth();

    // This year start date and end date
    $thisYearStartDate = $now->startOfYear();
    $thisYearEndDate = $now->endOfYear();

    // Filter orders for last week
    $lastWeekOrders = Order::where('created_at', '>', Carbon::now()->startOfWeek()->subWeek()->startOfDay())
    ->where('created_at', '<', Carbon::now()->startOfWeek()->subDay()->endOfDay())
    ->get();


    $thisWeekOrders = Order::where('created_at', '>', Carbon::now()->startOfWeek())
    ->where('created_at', '<', Carbon::now()->endOfWeek())
    ->get();

    // Filter orders for this month
    $thisMonthOrders =  Order::where('created_at', '>', Carbon::now()->startOfMonth())
    ->where('created_at', '<', Carbon::now()->endOfMonth())
    ->get();


    // Filter orders for last month
    $lastMonthOrders = Order::where('created_at', '>', Carbon::now()->subMonth()->startOfMonth())
    ->where('created_at', '<', Carbon::now()->subMonth()->endOfMonth())
    ->get();



    // Filter orders for this year
    $thisYearOrders =Order::where('created_at', '>', Carbon::now()->startOfYear())
    ->where('created_at', '<', Carbon::now()->subMonth()->endOfYear())
    ->get();


    // Calculate profits for each period
    $profitLastWeek = $this->calculateProfitForOrders($lastWeekOrders);
    $profitthisWeek = $this->calculateProfitForOrders($thisWeekOrders);
    $profitThisMonth = $this->calculateProfitForOrders($thisMonthOrders);
    $profitLastMonth = $this->calculateProfitForOrders($lastMonthOrders);
    $profitThisYear = $this->calculateProfitForOrders($thisYearOrders);

    return [
        'profit_this_week' => $profitthisWeek,
        'profit_last_week' => $profitLastWeek,
        'profit_this_month' => $profitThisMonth,
        'profit_last_month' => $profitLastMonth,
        'profit_this_year' => $profitThisYear,
    ];
}

protected function calculateProfitForOrders($orders)
{
    $totalRevenue = $orders->sum('grand_total');
    $totalCosts = $orders->sum('shipping_charges') + $orders->sum('tax_charge');
    $profit = $totalRevenue - $totalCosts;
    return $profit;
}


}
