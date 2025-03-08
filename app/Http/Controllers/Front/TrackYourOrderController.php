<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CmsPage;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use RealRashid\SweetAlert\Facades\Alert;

class TrackYourOrderController extends Controller
{
    //

    public function index()
    {

        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::all()->toArray();
            return view('fontend.layout.track_order', compact('appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function showOrderDetails($order_code)
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::all()->toArray();
            $order = Order::where('order_code', $order_code)->first();
            if ($order) {
                return view('fontend.layout.view_tracking_order', ['order' => $order, 'appsettings' => $appsettings, 'cms_pages' => $cms_pages]);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function check(Request $request)
    {
        try {
            if ($request->method('post')) {
                $request->validate([
                    'order_code' => 'required|string',
                    // 'billing_email' => 'required|email',
                ]);
                if ($request->input('billing_email')) {

                    $order = Order::with('deliveryBoy', 'orders_products')->where('order_code', $request->input('order_code'))
                        ->where('email', $request->input('billing_email'))
                        ->first();
                    if ($order) {
                        $appsettings = AppSetting::all()->toArray();
                        $cms_pages = CmsPage::all()->toArray();
                        Alert::toast("your order found", 'success');
                        return redirect()->route('order-detailss', ['order_code' => $order->order_code]);
                    } else {
                        Alert::toast('Your order code or billing email is not correct!', 'error');
                        return redirect()->back();
                    }
                } else {
                    $order = Order::with('deliveryBoy', 'orders_products')->where('order_code', $request->input('order_code'))->first();
                    if ($order) {
                        $appsettings = AppSetting::all()->toArray();
                        $cms_pages = CmsPage::all()->toArray();
                        Alert::toast("your order found", 'success');
                        return redirect()->route('order-detailss', ['order_code' => $order->order_code]);
                    } else {
                        Alert::toast('Your order code or billing email is not correct!', 'error');
                        return redirect()->back();
                    }
                }
            } else {
                abort(404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
