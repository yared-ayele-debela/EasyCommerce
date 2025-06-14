<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\MonthlyOrderChart;
use App\Charts\MonthlyUserRegisterChart;
use App\Charts\MonthlyUsersChart;
use App\Charts\Order_Payment_StatusChart;
use App\Charts\paymentChart;
use App\Http\Controllers\Controller;
use App\Livewire\Sales\Salesman;
use App\Models\ActivityLog;
use App\Models\Admin as ModelsAdmin;
use App\Models\AppSetting;
use App\Models\Coupon;
use App\Models\CustomOrder;
use App\Models\CustomOrderProduct;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\SalesUser;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    //

    public function fetch(Request $request)
{
    $filter = $request->query('filter', 'today');
    $page = $request->query('page', 1);
    $perPage = 10;

    $query = ActivityLog::where('user_id', Auth::guard('admin')->user()->id);

    if ($filter === 'today') {
        $query->whereDate('created_at', Carbon::today());
    } elseif ($filter === 'month') {
        $query->whereMonth('created_at', Carbon::now()->month)
              ->whereYear('created_at', Carbon::now()->year);
    } elseif ($filter === 'year') {
        $query->whereYear('created_at', Carbon::now()->year);
    }

    $activities = $query->orderBy('created_at', 'desc')
                        ->skip(($page - 1) * $perPage)
                        ->take($perPage)
                        ->get();

    return response()->json($activities);
}
    public function dashboard()
    {

        $appsettings = AppSetting::all()->toArray();


        $admin=Auth::guard('admin')->user();
        $isVendor=in_array($admin->type, ['vendor', 'Ecommerce Manager']);

         $newCustomers = Order::select('user_id')->distinct()->count();
        $repeatCustomers = Order::select('user_id')->groupBy('user_id')->havingRaw('COUNT(*) > 1')->count();

        $repeatData = ['new' => $newCustomers - $repeatCustomers, 'repeat' => $repeatCustomers];

        if(!$isVendor){
            $counts = [
            'customers'   => User::count(),
            'vendors'     => ModelsAdmin::whereIn('type', ['vendor', 'Ecommerce Manager'])->count(),
            'admins'      => ModelsAdmin::count(),
            'deliverymen' => DeliveryMan::count(),
            'salesmen'    => SalesUser::count(),
        ];

        // Count orders by status
        $orderStatus = [
            'all'        => Order::count(),
            'new'    => Order::where('order_status', 'new')->count(),
            'pending'    => Order::where('order_status', 'pending')->count(),
            'confirmed'    => Order::where('order_status', 'confirmed')->count(),
            'picked'    => Order::where('order_status', 'picked')->count(),
            'delivering'    => Order::where('order_status', 'delivering')->count(),
            'delivered'  => Order::where('order_status', 'delivered')->count(),
            'cancelled'  => Order::where('order_status', 'cancelled')->count(),
        ];

        // Latest orders (limit to 5)

        $admin_activity = ActivityLog::where('user_id', Auth::guard('admin')->user()->id)->orderBy('created_at', 'desc')->get();
        $outOfStockProducts = Product::where('quantity', '<', '1')->get();

        $topProducts = OrderProduct::select('product_name as name', DB::raw('SUM(product_qty) as total'))
            ->groupBy('product_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $orderStatuses = Order::select('order_status', DB::raw('COUNT(*) as total'))
            ->groupBy('order_status')
            ->pluck('total', 'order_status');

        $topVendors = OrderProduct::with('vendor')
            ->select('vendor_id', DB::raw('SUM(product_price * product_qty) as total'))
            ->groupBy('vendor_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->vendor->name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        $topCustomers = Order::with('user')
            ->select('user_id', DB::raw('SUM(grand_total) as total'))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->user->name ?? 'N/A',
                    'total' => $item->total,
                ];
            });
        $monthlySales = Order::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, SUM(grand_total) as total")
            ->groupBy('month')->orderByRaw('MIN(created_at)')->take(12)->get();

        $paymentBreakdown = Order::select('payment_method', DB::raw('SUM(grand_total) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        $citySales = Order::select('city', DB::raw('SUM(grand_total) as total'))
            ->groupBy('city')
            ->orderByDesc('total')->take(10)->get();


        $salesByVendor = OrderProduct::select('vendor_id', DB::raw('SUM(product_price * product_qty) as total_sales'))
            ->groupBy('vendor_id')
            ->with('vendor') // Ensure vendor relationship exists in OrderProduct model
            ->get();

        $vendorLabels = $salesByVendor->map(fn($v) => $v->vendor->name ?? 'Unknown')->toArray();
        $vendorLabels = json_encode($vendorLabels);
        $vendorSales = $salesByVendor->pluck('total_sales')->toArray();
        $vendorSales = json_encode($vendorSales);

        $return_request=ReturnRequest::all()->count();
        }else{
                $vendorId = $admin->vendor_id;

                $vendorOrderIds = OrderProduct::where('vendor_id', $vendorId)->pluck('order_id')->unique();

                $orderStatus = [
                    'all'        => Order::whereIn('id', $vendorOrderIds)->count(),
                    'new'        => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'new')->count(),
                    'pending'    => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'pending')->count(),
                    'confirmed'  => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'confirmed')->count(),
                    'picked'     => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'picked')->count(),
                    'delivering' => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'delivering')->count(),
                    'delivered'  => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'delivered')->count(),
                    'cancelled'  => Order::whereIn('id', $vendorOrderIds)->where('order_status', 'cancelled')->count(),
                ];

                // Out of stock products for this vendor
                $outOfStockProducts = Product::where('vendor_id', $vendorId)->where('quantity', '<', 1)->get();

                // Top-selling products for this vendor
                $topProducts = OrderProduct::where('vendor_id', $vendorId)
                    ->select('product_name as name', DB::raw('SUM(product_qty) as total'))
                    ->groupBy('product_name')
                    ->orderByDesc('total')
                    ->take(5)
                    ->get();

                // Monthly sales for this vendor
                $monthlySales = OrderProduct::where('vendor_id', $vendorId)
                    ->join('orders', 'orders.id', '=', 'orders_products.order_id')
                    ->selectRaw("DATE_FORMAT(orders.created_at, '%b %Y') as month, SUM(product_price * product_qty) as total")
                    ->groupBy('month')->orderByRaw('MIN(orders.created_at)')->take(12)->get();
                    // dd($monthlySales);

                // Payment methods used in this vendor's orders
                $paymentBreakdown = Order::whereIn('id', $vendorOrderIds)
                    ->select('payment_method', DB::raw('SUM(grand_total) as total'))
                    ->groupBy('payment_method')->pluck('total', 'payment_method');

                // City-wise sales
                $citySales = Order::whereIn('id', $vendorOrderIds)
                    ->select('city', DB::raw('SUM(grand_total) as total'))
                    ->groupBy('city')->orderByDesc('total')->take(10)->get();

                // Prepare Chart.js variables
                $vendorLabels = [$admin->name];
                $vendorSales = [
                    OrderProduct::where('vendor_id', $vendorId)->sum(DB::raw('product_price * product_qty'))
                ];

                $vendorLabels = json_encode($vendorLabels);
                $vendorSales = json_encode($vendorSales);

                $return_request = ReturnRequest::whereHas('order', function ($query) use ($vendorId) {
                    $query->whereHas('orders_products', function ($q) use ($vendorId) {
                        $q->where('vendor_id', $vendorId);
                    });
                })->count();

                return view('admindashboard.dashboard', compact(
                'appsettings',
                'return_request',
                'orderStatus',
                'outOfStockProducts',
                'topProducts',
                'paymentBreakdown',
                'citySales',
                'monthlySales',
                'repeatData',
                'vendorLabels',
                'vendorSales'
            ));
        }

        return view('admindashboard.dashboard', compact('return_request','appsettings', 'counts', 'orderStatus', 'admin_activity', 'outOfStockProducts', 'topProducts', 'orderStatuses', 'topVendors', 'topCustomers', 'paymentBreakdown', 'citySales', 'repeatData', 'monthlySales', 'vendorSales', 'vendorLabels'));
    }


    public function index(){

        return view('admindashboard.maindashboard')->withComponent(MainDashboard::class);;
    }

    public function order_reports(){

        $appsettings=AppSetting::all()->toArray();
        $current_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $before_1_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        $before_2_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        $before_3_month_order=Order::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();

        $ordersCount=array($current_month_order,$before_1_month_order,$before_2_month_order,$before_3_month_order);
//        dd($ordersCount);die;
        return view('layouts.orders_reports',compact('appsettings','ordersCount'));
    }
    public function userscity(){

        $appsettings=AppSetting::all()->toArray();
        $getUserCity=User::select('city',DB::raw('count(city) as count'))->groupBy('city')->get();
//        dd($getUserCity);die;
       return view('layouts.city_reports',compact('getUserCity','appsettings'));
    }


    public function filterOrders(Request $request,MonthlyUsersChart $chart,MonthlyOrderChart $c,MonthlyUserRegisterChart $user,Order_Payment_StatusChart $payment)
    {
        try {

            if(!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }

            $appsettings = AppSetting::all()->toArray();


            // Retrieve filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Filter by Start Date and End Date
            if ($startDate && $endDate) {
                $orders = Order::with(['orders_products','orders_products.product'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->paginate(30);
            }

        $order_profile=new Order();

        $profits=$order_profile->calculateProfits();
        // dd($profits);

       $total_profit=$order_profile->calculateProfit();
       $totalPayment = $order_profile->calculateTotalPayment();
       $totalTaxPayments = $order_profile->calculateTotalTaxPayments();

        // dd($total_profit," ",$totalPayment," ",$totalTaxPayments);

        $current_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $before_1_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
        $before_2_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
        $before_3_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();
        $userCount=array($current_month_users,$before_1_month_users,$before_2_month_users,$before_3_month_users);
        $orderproducts=OrderProduct::all()->where('vendor_id',Auth::guard ('admin')->user()->vendor_id);
        $vendorproducts=Product::all()->where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();

        // dd($appsettings);
        $allproducts=Product::all()->where('status',1)->count();
        $allusers=User::all()->where('status',1)->count();
        $allorders=Order::all()->count();
        $pendingorders=Order::where('order_status','pending')->count();
        $deliverdorders=Order::where('order_status','delivered')->count();
        $paidorders=Order::where('order_status','paid')->count();

        $allvendors=Vendor::all()->where('status',1)->count();
        $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $latestproducts = Product::orderBy('created_at', 'desc')->take(5)->get();
        $alldeliveryboys= DeliveryMan::all()->count();
        $latestcustomorder = CustomOrderProduct::orderBy('created_at','desc')->take(5)->get();

        return view('layouts.payments.all_payments',compact('orders','profits','total_profit','totalPayment','totalTaxPayments','latestcustomorder','alldeliveryboys','pendingorders','deliverdorders','paidorders','latestproducts','latestOrders','orderproducts','vendorproducts','appsettings','allproducts','allusers','allorders','allvendors'),['c'=>$c->build(),'chart'=>$chart->build(),'user'=>$user->build(),'payment'=>$payment->build()]);
            } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function payments_report(Request $request, MonthlyUsersChart $chart,MonthlyOrderChart $c,MonthlyUserRegisterChart $user,Order_Payment_StatusChart $payment){

        try {
            //generate report for a users
            $orders = Order::with(['orders_products','orders_products.product'])->paginate(30);
            // dd($orders);
            $appsettings=AppSetting::all()->toArray();

            $order_profile=new Order();

            $profits=$order_profile->calculateProfits();
            // dd($profits);

            $total_profit=$order_profile->calculateProfit();
            $totalPayment = $order_profile->calculateTotalPayment();
            $totalTaxPayments = $order_profile->calculateTotalTaxPayments();

            // dd($total_profit," ",$totalPayment," ",$totalTaxPayments);

            $current_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
            $before_1_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(1))->count();
            $before_2_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(2))->count();
            $before_3_month_users=User::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->subMonth(3))->count();
            $userCount=array($current_month_users,$before_1_month_users,$before_2_month_users,$before_3_month_users);
            $orderproducts=OrderProduct::all()->where('vendor_id',Auth::guard ('admin')->user()->vendor_id);
            $vendorproducts=Product::all()->where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();

            // dd($appsettings);
            $allproducts=Product::all()->where('status',1)->count();
            $allusers=User::all()->where('status',1)->count();
            $allorders=Order::all()->count();
            $pendingorders=Order::where('order_status','pending')->count();
            $deliverdorders=Order::where('order_status','delivered')->count();
            $paidorders=Order::where('order_status','paid')->count();

            $allvendors=Vendor::all()->where('status',1)->count();
            $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
            $latestproducts = Product::orderBy('created_at', 'desc')->take(5)->get();
            $alldeliveryboys= DeliveryMan::all()->count();
            $latestcustomorder = CustomOrderProduct::orderBy('created_at','desc')->take(5)->get();

        return view('layouts.payments.all_payments',compact('orders','profits','total_profit','totalPayment','totalTaxPayments','latestcustomorder','alldeliveryboys','pendingorders','deliverdorders','paidorders','latestproducts','latestOrders','orderproducts','vendorproducts','appsettings','allproducts','allusers','allorders','allvendors'),['c'=>$c->build(),'chart'=>$chart->build(),'user'=>$user->build(),'payment'=>$payment->build()]);

        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
