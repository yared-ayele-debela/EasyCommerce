<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\OrderItemStatus;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrderProductReportController extends Controller
{
    //
    public function index()
    {
        // try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view order product reports')) {
                return view('admin.errors.unauthorized');
            }


            $orders = OrderProduct::paginate(30);
            $order_status = OrderItemStatus::all();
            $appsettings = AppSetting::all()->toArray();

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;

            if ($adminType == 'vendor') {

                $orders = OrderProduct::where('vendor_id', $vendor_id)->paginate(30);
            }
            if(!$orders){
                Alert::toast('Order Product is not found!!');
            }


            return view('admin.reports.order_product_reports', compact('orders', 'order_status', 'appsettings'));
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }


    public function filterByDate(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $query = OrderProduct::query();
            $order_status = OrderItemStatus::all();
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
                $query->where('item_status', $orderStatus);
            }

            // Filter by Start Date, End Date, and Order Status
            if ($startDate && $endDate && $orderStatus) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('item_status', $orderStatus);
            }

            // Fetch the filtered orders
            $orders = $query->paginate(30);

            // Render the HTML table with the filtered orders and return as a response
            return view('admin.reports.order_product_reports', compact('order_status', 'orders', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
