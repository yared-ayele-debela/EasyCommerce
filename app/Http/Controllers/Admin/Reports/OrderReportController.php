<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Models\Admin as ModelsAdmin;
use App\Models\AppSetting;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrderReportController extends Controller
{
    //
    public function index()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view order reports')) {
                return view('admin.errors.unauthorized');
            }

            $orders = Order::paginate(30);
            $order_status = OrderStatus::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.order_reports', compact('orders', 'order_status', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    public function filterByDate(Request $request)
    {
        try {
            if(!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }

            $query = Order::query();
            $order_status = OrderStatus::all();
            $appsettings = AppSetting::all()->toArray();


            // Retrieve filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $orderStatus = $request->input('order_status');

            // Filter by Start Date and End Date
            if ($startDate && $endDate && !$orderStatus) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Filter by Order Status only
            if ($orderStatus && !$startDate && !$endDate) {
                $query->where('order_status', $orderStatus);
            }

            // Filter by Start Date, End Date, and Order Status
            if ($startDate && $endDate && $orderStatus) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('order_status', $orderStatus);
            }

            // Fetch the filtered orders
            $orders = $query->paginate(30);

            // Render the HTML table with the filtered orders and return as a response
            return view('admin.reports.order_reports', compact('order_status', 'orders', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
