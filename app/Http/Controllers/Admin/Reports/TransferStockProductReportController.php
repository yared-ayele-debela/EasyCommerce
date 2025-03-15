<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Transfer_stock_product;
use App\Models\WereHouses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TransferStockProductReportController extends Controller
{
    //
    public function index()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view stock transferred reports')) {
                return view('admin.errors.unauthorized');
            }

            $transfer_stock_product = Transfer_stock_product::paginate(30);
            $warehouse = WereHouses::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.transfer_stock_product_reports', compact('warehouse', 'transfer_stock_product', 'appsettings'));
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
            $query = Transfer_stock_product::query();

            $appsettings = AppSetting::all()->toArray();

            // Retrieve filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $from_warehouse = $request->input('from_warehouse');
            $to_warehouse = $request->input('to_warehouse');

            // Filter by Start Date and End Date
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            if ($startDate && $endDate && $from_warehouse) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('from_warehouse_id', $from_warehouse);
            }

            if ($startDate && $endDate && $to_warehouse) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('to_warehouse_id', $to_warehouse);
            }

            if ($from_warehouse !== null && $to_warehouse !== null) {
                $query->where('from_warehouse_id', $from_warehouse)->where('to_warehouse_id', $to_warehouse);
            }

            if ($from_warehouse !== null) {
                $query->where('from_warehouse_id', $from_warehouse);
            }
            if ($to_warehouse !== null) {
                $query->where('to_warehouse_id', $to_warehouse);
            }


            // Fetch the filtered orders
            $transfer_stock_product = $query->paginate(30);

            // Render the HTML table with the filtered orders and return as a response
            return view('admin.reports.transfer_stock_product_reports', compact('warehouse', 'transfer_stock_product', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
