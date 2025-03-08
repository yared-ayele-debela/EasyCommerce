<?php

namespace App\Http\Controllers\Admin\Reports\Charts;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Transfer_stock_product;
use App\Models\WereHouses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ChartController extends Controller
{

    // }
    public function order()
    {
        $last30Days = Carbon::now()->subDays(30);
        $appsettings = AppSetting::all()->toArray();
        $orderData = Order::select(\DB::raw('DATE(created_at) as order_date'), \DB::raw('COUNT(*) as order_count'))
            ->where('created_at', '>=', $last30Days)
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get();

        return view('admin.reports.chart.order', compact('orderData', 'appsettings'));
    }

    public function order_products()
    {
        $appsettings = AppSetting::all()->toArray();
        $orderProductData = OrderProduct::select('product_name', \DB::raw('SUM(product_qty) as total_quantity'))
            ->groupBy('product_name')
            ->get();

        return view('admin.reports.chart.order_product', compact('orderProductData', 'appsettings'));
    }

    public function stock()
    {
        $appsettings = AppSetting::all()->toArray();
        $stockData = ProductAttribute::select('product_id', \DB::raw('SUM(stock) as total_stock'))
            ->groupBy('product_id')
            ->get();
        foreach ($stockData as $data) {
            $product = Product::find($data->product_id);
            $data->product_name = ($product) ? $product->product_name : 'Unknown Product';
        }


        return view('admin.reports.chart.stock', compact('stockData', 'appsettings'));
    }

    public function transfer()
    {
        $appsettings = AppSetting::all()->toArray();

        $transferData = Transfer_stock_product::select('product_id', 'from_warehouse_id', 'to_warehouse_id', \DB::raw('SUM(quantity) as total_quantity'), 'transfer_date')
            ->groupBy('product_id', 'from_warehouse_id', 'to_warehouse_id', 'transfer_date')
            ->get();

        // Fetch warehouse names for from_warehouse_id and to_warehouse_id
        foreach ($transferData as $data) {
            $fromWarehouse = WereHouses::find($data->from_warehouse_id);
            $toWarehouse = WereHouses::find($data->to_warehouse_id);
            $data->from_warehouse_name = ($fromWarehouse) ? $fromWarehouse->name : 'Unknown Warehouse';
            $data->to_warehouse_name = ($toWarehouse) ? $toWarehouse->name : 'Unknown Warehouse';
        }
        return view('admin.reports.chart.stock_transfer_chart', compact('transferData', 'appsettings'));
    }

    public function product()
    {
        $appsettings = AppSetting::all()->toArray();
        $productData = Product::select('category_id', \DB::raw('COUNT(*) as product_count'))
            ->groupBy('category_id')
            ->get();
        foreach ($productData as $data) {
            $category = Category::find($data->category_id);
            $data->category_name = ($category) ? $category->name : 'Unknown Category';
        }

        return view('admin.reports.chart.product', compact('productData', 'appsettings'));
    }
}
