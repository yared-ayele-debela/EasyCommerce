<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CustomOrder;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CustomReportController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view custom order reports')) {
                return view('admin.errors.unauthorized');
            }
           
            $custom = CustomOrder::with('custom_order_product')->paginate(30);
            $appsettings = AppSetting::all()->toArray();
            $order_status = OrderStatus::all();

            return view('admin.reports.custom_reports', compact('order_status', 'custom', 'appsettings'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            // Handle the error and redirect with an error message
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
            $appsettings = AppSetting::all()->toArray();
            $order_status = OrderStatus::all();

            // Retrieve filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $status = $request->input('status');
            $query = CustomOrder::with('custom_order_product');

            // Filter by Start Date and End Date
            if ($startDate && $endDate && !$status) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Filter by Order Status only
            if ($status && !$startDate && !$endDate) {
                $query->where('status', $status);
            }

            // Filter by Start Date, End Date, and Order Status
            if ($startDate && $endDate && $status) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', $status);
            }

            // Fetch the filtered orders
            $custom = $query->paginate(30);

            return view('admin.reports.custom_reports', compact('order_status', 'custom', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
