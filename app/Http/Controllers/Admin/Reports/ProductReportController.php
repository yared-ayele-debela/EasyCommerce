<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProductReportController extends Controller
{
    //
    public function index()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view product reports')) {
                return view('admin.errors.unauthorized');
            }

            $products = Product::paginate(30);

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;

            if ($adminType == 'vendor') {
                $products = Product::where('vendor_id', $vendor_id)->paginate(30);
            }

            $brand = Brand::all();
            $category = Category::where('parent_id', 0)->get();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.product_reports', compact('brand', 'category', 'products', 'appsettings'));
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
            $query = Product::query();
            $appsettings = AppSetting::all()->toArray();
            $brand = Brand::all();
            $category = Category::where('parent_id', 0)->get();

            // Retrieve filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $status = $request->input('status');
            $isfeatured = $request->input('isfeatured');
            $categories = $request->input('category');
            $brands = $request->input('brand');

            // Filter by Start Date and End Date
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            if ($startDate && $endDate && $categories) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('category_id', $categories);
            }
            if ($startDate && $endDate && $brands) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('brand_id', $brands);
            }


            if ($brands !== null && $categories !== null && $startDate && $endDate) {
                $query->where('brand_id', $brands)->where('category_id', $categories)->whereBetween('created_at', [$startDate, $endDate]);
            }

            if ($brands !== null && $categories !== null) {
                $query->where('brand_id', $brands)->where('category_id', $categories);
            }

            if ($brands !== null && $categories !== null) {
                $query->where('brand_id', $brands)->where('category_id', $categories);
            }
            if ($brands !== null) {
                $query->where('brand_id', $brands);
            }
            if ($categories !== null) {
                $query->where('category_id', $categories);
            }

            // Fetch the filtered orders
            $products = $query->paginate(30);

            // Render the HTML table with the filtered orders and return as a response
            return view('admin.reports.product_reports', compact('brand', 'category', 'products', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
