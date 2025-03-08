<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RatingController extends Controller
{
    //
    public function ratings()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_product_rating')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $user_type = Auth::guard('admin')->user()->type;

            if ($user_type === "vendor") {
                $ratings = Rating::with(['user', 'product'])
                    ->whereHas('product', function ($query) {
                        $query->where('admin_id', Auth::guard('admin')->user()->id);
                    })
                    ->get()
                    ->toArray();
            } else {
                $ratings = Rating::with(['user', 'product'])->get()->toArray();
            }

            return view('admin.ratings.ratings', compact('ratings', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit product rating')) {
                return view('admin.errors.unauthorized');
            }
            $ratings = Rating::find($id);
            $ratings->status = 1;
            $ratings->update();
            Alert::toast('Active', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit product rating')) {
                return view('admin.errors.unauthorized');
            }
            $ratings = Rating::find($id);
            $ratings->status = 0;
            $ratings->update();
            Alert::toast('Inactivated', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_product_rating')) {
                return view('admin.errors.unauthorized');
            }
            $ratings = Rating::find($id);
            $ratings->delete();

            Alert::toast('Deleted', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
