<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserReportController extends Controller
{
    //
    public function index()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view customer reports')) {
                return view('admin.errors.unauthorized');
            }

            $users = User::all();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.user_reports', compact('users', 'appsettings'));
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
            $users = User::whereBetween('created_at', [$startDate, $endDate])->get();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.reports.user_reports', compact('appsettings', 'users'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
