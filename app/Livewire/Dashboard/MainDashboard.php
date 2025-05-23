<?php

namespace App\Livewire\Dashboard;
use App\Models\{ActivityLog, Admin as ModelsAdmin, AppSetting, Coupon, CustomOrder, CustomOrderProduct, DeliveryMan, Order, OrderProduct, Product, ProductAttribute, SalesUser, User, Vendor};
use App\Charts\{MonthlyUsersChart, MonthlyOrderChart, MonthlyUserRegisterChart, Order_Payment_StatusChart};
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class MainDashboard extends Component
{
    use WithPagination;

    public $admin_activity;
    public $total_shipping_charge;
    public $totalTax;
    public $totalPayment;
    public $totalProfit;
    public $commission;
    public $orderCount;
    public $allproducts;
    public $latestOrdersproducts;
    public $paidorderproducts;
    public $deliverdorderproducts;
    public $pendingorderproducts;
    public $appsettings;
    public $allcoupons;
    public $all_order_products;
    public $latestproducts;
    public $alladmins;
    public $orders;
    public $profits;
    public $total_profit;
    public $totalTaxPayments;
    public $latestcustomorder;
    public $alldeliveryboys;
    public $pendingorders;
    public $deliverdorders;
    public $allcustomorder;
    public $paidorders;
    public $latestOrders;
    public $orderproducts;
    public $vendorproducts;
    public $allusers;
    public $allorders;
    public $allvendors;
    public $chart;
    public $user;
    public $payment;
    public $userCount;
    public $c;
    public $total_sales_person;

    // for vendor
    public $lastMonthVendors;
    public $percentageChange;

    // for customer
    public $lastMonthCustomer;
    public $percentageCustomer;

    public $neworder;
    public $pendingorder;
    public $cancelledorder;
    public $processingorder;
    public $pickedorder;
    public $deliveredorder;
    public $completedorder;
    public $paidorder;

    // to filter activity
    public $filter = 'today';

    // to order charts
    public $ordersData = [];
    public $usersData = [];
    public $productsData = [];
    public $orderStatusData = [];
    public $salesData = [];
    public $customerData = [];

    public $topSellingProductsData = [];
    public $startDate;
    public $endDate;
    public $productStockData;

    public $outOfStockProducts;


    public function mount(MonthlyUsersChart $chart, MonthlyOrderChart $c, MonthlyUserRegisterChart $user, Order_Payment_StatusChart $payment)
    {
        // Generate report for users
        $this->orders = Order::with(['orders_products', 'orders_products.product'])->get();
                   $this->outOfStockProducts = Product::where('quantity','<','1')->get();


        $this->appsettings = AppSetting::all()->toArray();

        $order_profile = new Order();

        $this->profits = $order_profile->calculateProfits();

        $this->total_profit = $order_profile->calculateProfit();
        $this->totalPayment = $order_profile->calculateTotalPayment();
        $this->totalTaxPayments = $order_profile->calculateTotalTaxPayments();

        $this->userCount = [
            User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count(),
            User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count(),
            User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count(),
            User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3))->count()
        ];

        $vendor_id = Auth::guard('admin')->user()->vendor_id;

        $this->orderproducts = OrderProduct::where('vendor_id', $vendor_id)->get();
        $this->vendorproducts = Product::where('vendor_id', $vendor_id)->count();
        $this->allproducts = Product::where('status', 1)->count();

        // order
        $this->allorders = Order::count();
        $this->pendingorder = Order::where('order_status', 'pending')->count();
        $this->deliveredorder = Order::where('order_status', 'delivered')->count();
        $this->paidorder = Order::where('order_status', 'paid')->count();
        $this->neworder= Order::where('order_status', 'new')->count();
        $this->cancelledorder = Order::where('order_status', 'cancelled')->count();
        $this->processingorder = Order::where('order_status', 'processing')->count();
        $this->pickedorder = Order::where('order_status', 'picked')->count();
        $this->completedorder = Order::where('order_status', 'completed')->count();
        $this->paidorder = Order::where('order_status', 'paid')->count();

        // for customer
        $this->allusers = User::where('status', 1)->count();
        $this->lastMonthCustomer = User::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        // Calculate the percentage change
         if ($this->lastMonthCustomer > 0) {
            $this->percentageCustomer = (($this->allusers - $this->lastMonthCustomer) / $this->lastMonthCustomer) * 100;
        } else {
            $this->percentageCustomer = 0;
        }
        // end customer


        // for vendor
        $this->allvendors = Vendor::where('status', 1)->count();
        $this->lastMonthVendors = Vendor::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        //  Calculate the percentage change
         if ($this->lastMonthVendors > 0) {
            $this->percentageChange = (($this->allvendors - $this->lastMonthVendors) / $this->lastMonthVendors) * 100;
        } else {
            $this->percentageChange = 0; // To avoid division by zero
        }
        // end vendor

        $this->latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $this->latestproducts = Product::orderBy('created_at', 'desc')->take(5)->get();
        $this->alldeliveryboys = DeliveryMan::count();
        $this->allcustomorder=CustomOrder::count();
        $this->latestcustomorder = CustomOrderProduct::orderBy('created_at', 'desc')->take(5)->get();
        $this->admin_activity = ActivityLog::where('user_id', Auth::guard('admin')->user()->id)->orderBy('created_at', 'desc')->get();
        $this->alladmins = ModelsAdmin::count();
        $this->total_sales_person= SalesUser::count();

        if (Auth::guard('admin')->user()->type == "vendor" || Auth::guard('admin')->user()->type == "Ecommerce Manager") {
            $vendor_id = Auth::guard('admin')->user()->vendor_id;

            $this->allproducts = Product::where('vendor_id', $vendor_id)->where('status', 1)->count();
            $this->allcoupons = Coupon::where('vendor_id', $vendor_id)->count();
            $this->all_order_products = OrderProduct::where('vendor_id', $vendor_id)->count();

            $this->orderCount = OrderProduct::whereHas('order', function ($query) use ($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            })->count();

            $vendor_order_product = OrderProduct::whereHas('order', function ($query) use ($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            })->get();

            if ($vendor_order_product->count() != 0) {
                $getVendorCommission = Vendor::getVendorCommission($vendor_id);
                $total_price = 0;
                foreach ($vendor_order_product as $product) {
                    $total_price += ($product->product_price * $product->product_qty);
                }
                $this->commission = round($total_price * $getVendorCommission / 100, 2);
            } else {
                $this->commission = 0;
            }

            $vendor_order = Order::with('orders_products')->whereHas('orders_products', function ($query) use ($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            })->get();

            $this->totalPayment = 0;
            $this->totalTax = 0;
            $this->totalProfit = 0;
            $this->total_shipping_charge = 0;

            foreach ($vendor_order as $order) {
                $this->totalPayment += $order->grand_total;
                $this->totalTax += $order->tax_charge;
                $this->total_shipping_charge += $order->shipping_charges;
            }

            $total_sub = $this->totalTax + $this->total_shipping_charge;
            $this->totalProfit = $this->totalPayment - $total_sub;

            $this->pendingorderproducts = OrderProduct::where('vendor_id', $vendor_id)->where('item_status', 'pending')->count();
            $this->deliverdorderproducts = OrderProduct::where('vendor_id', $vendor_id)->where('item_status', 'delivered')->count();
            $this->paidorderproducts = OrderProduct::where('vendor_id', $vendor_id)->where('item_status', 'paid')->count();
            $this->latestOrdersproducts = OrderProduct::where('vendor_id', $vendor_id)->orderBy('created_at', 'desc')->take(5)->get();
            $this->outOfStockProducts = Product::where('vendor_id', $vendor_id)->where('quantity','<','1')->get();
            $this->latestproducts = Product::where('vendor_id', $vendor_id)->orderBy('created_at', 'desc')->take(5)->get();
        }

        // chart
        $this->loadActivity();
        $this->loadOrderData();
        $this->loadUserData();
        $this->loadProductData();
        $this->loadOrderStatusData();
        $this->loadSalesData();
        $this->loadCustomerData();
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
        $this->loadTopSellingProductsData();
        $this->loadProductStockData();

    }


    public function loadUserData()
    {
        // Fetch user distribution by city
        $users = User::selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->get();

        // Format data for Chart.js
        $this->usersData = [
            'labels' => $users->pluck('city')->toArray(),
            'data' => $users->pluck('count')->toArray()
        ];
    }
    public function loadActivity()
    {
        $query = ActivityLog::where('user_id', Auth::guard('admin')->user()->id);

        if ($this->filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($this->filter === 'month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        } elseif ($this->filter === 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $this->admin_activity = $query->orderBy('created_at', 'desc')->get();
    }

    public function updatedFilter()
    {
        $this->loadActivity();
    }

    // order chart
    public function loadOrderData()
    {
        // Example data: Orders grouped by month for the current year
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // dump($orders);

        // Format data for Chart.js
        $this->ordersData = [
            'labels' => $orders->pluck('month')->map(function ($month) {
                return Carbon::create()->month($month)->format('F');
            })->toArray(),
            'data' => $orders->pluck('count')->toArray()
        ];
    }



    public function loadProductData()
    {
        // Fetch product stock data
        $products = DB::table('products_attributes')
            ->select('product_id', 'stock')
            ->where('status', 1)
            ->orderBy('product_id')
            ->get();

        // Format data for Chart.js
        $productNames = Product::whereIn('id', $products->pluck('product_id'))->pluck('product_name', 'id')->toArray();

        $this->productsData = [
            'labels' => array_map(fn($product_id) => $productNames[$product_id] ?? 'Unknown', $products->pluck('product_id')->toArray()),
            'data' => $products->pluck('stock')->toArray()
        ];
    }

    //to display order status data
    public function loadOrderStatusData()
    {
        $statuses = Order::select('order_status', DB::raw('count(*) as count'))
                         ->groupBy('order_status')
                         ->get();

        $this->orderStatusData = [
            'labels' => $statuses->pluck('order_status')->toArray(),
            'data' => $statuses->pluck('count')->toArray(),
            'colors' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'] // Add more colors if needed
        ];
    }

    public function loadSalesData()
    {
        $sales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(grand_total) as total_sales')
        )->groupBy('date')->get();

        $this->salesData = [
            'labels' => $sales->pluck('date')->toArray(),
            'data' => $sales->pluck('total_sales')->toArray()
        ];
    }
    public function loadCustomerData()
    {
        $customers = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_customers')
        )->groupBy('date')->get();

        $this->customerData = [
            'labels' => $customers->pluck('date')->toArray(),
            'data' => $customers->pluck('total_customers')->toArray()
        ];
    }

    public function loadTopSellingProductsData()
    {
        $topProducts = OrderProduct::select('product_id', DB::raw('sum(product_qty) as total_quantity'))
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->take(10)
            ->get();

            $productNames = Product::whereIn('id', $topProducts->pluck('product_id'))->pluck('product_name', 'id')->toArray();

        $this->topSellingProductsData = [
            'labels' => array_map(fn($product_id) => $productNames[$product_id] ?? 'Unknown', $topProducts->pluck('product_id')->toArray()),
            'data' => $topProducts->pluck('total_quantity')->toArray(),
            'backgroundColor' => 'rgba(75, 192, 120, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)'
        ];

    }

    public function loadProductStockData()
    {
        $productStocks = ProductAttribute::with('warehouse')->get();
        $this->productStockData = [
            'labels' => $productStocks->map(function ($stock) {
                return $stock->warehouse->name;
            })->toArray(),
            'data' => $productStocks->pluck('stock')->toArray(),
            'colors' => $productStocks->map(function () {
                return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            })->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.main-dashboard');
    }
}