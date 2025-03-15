<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VendorReportController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view vendor reports')) {
                return view('admin.errors.unauthorized');
            }

            $vendor = Vendor::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.vendor_reports', compact('vendor', 'appsettings'));
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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $confirm = $request->input('confirm');
            $appsettings = AppSetting::all()->toArray();


            if ($confirm && $startDate && $endDate) {
                $vendor = Vendor::whereBetween('created_at', [$startDate, $endDate])->where('confirm', $confirm)->get();
            } else if ($confirm) {
                $vendor = Vendor::where('confirm', $confirm)->get();
            } else {
                $vendor = Vendor::whereBetween('created_at', [$startDate, $endDate])->get();
            }
            return view('admin.reports.vendor_reports', compact('appsettings', 'vendor'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
