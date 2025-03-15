<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\WereHouses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StockReportController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view stock product reports')) {
                return view('admin.errors.unauthorized');
            }

            $stock_product = ProductAttribute::paginate(30);
            $instock_product = ProductAttribute::all();
            $warehouse = WereHouses::all();
            $products = Product::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.stock_product_reports', compact('products', 'instock_product', 'warehouse', 'stock_product', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function filterByDate(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $warehouse = WereHouses::all();
            $query = ProductAttribute::query();
            $instock_product = ProductAttribute::all();
            $products = Product::all();

            $appsettings = AppSetting::all()->toArray();

            // Retrieve filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $product = $request->input('product_id');
            $store_warehouse = $request->input('warehouse_id');

            // Filter by Start Date and End Date
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            if ($startDate && $endDate && $store_warehouse) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('warehouse_id', $store_warehouse);
            }

            if ($startDate && $endDate && $product) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('product_id', $product);
            }

            if ($store_warehouse !== null && $product !== null) {
                $query->where('warehouse_id', $store_warehouse)->where('product_id', $product);
            }

            if ($store_warehouse !== null) {
                $query->where('warehouse_id', $store_warehouse);
            }
            if ($product !== null) {
                $query->where('product_id', $product);
            }


            // Fetch the filtered orders
            $stock_product = $query->paginate(30);

            // Render the HTML table with the filtered orders and return as a response
            return view('admin.reports.stock_product_reports', compact('products', 'instock_product', 'warehouse', 'stock_product', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
