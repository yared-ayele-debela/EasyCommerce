<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CmsPage;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    //
    public function orders($id = null)
    {
        try {

            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            if (empty($id)) {
                $orders = Order::with('orders_products')->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
                // dd($orders);
                return view('NewFrontEndPage.orders.orders')->with(compact('cms_pages', 'orders', 'appsettings'));
            } else {
                $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
                $return_order=ReturnRequest::where('order_id',$id)->get();
                $check_return_order=ReturnRequest::where('order_id',$id)->first();

                // echo "order details"; die;
                return view('NewFrontEndPage.orders.orders_details', compact('check_return_order','return_order','cms_pages', 'orderDetails', 'appsettings'));
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function orderCancel($id, Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                //           echo "<pre>"; print_r($data);die;
                if (isset($data['reason']) && empty($data['reason'])) {
                    return redirect()->back();
                }
                $user_id_auth = Auth::user()->id;
                $user_id_order = Order::select('user_id')->where('id', $id)->first();
                //        echo $user_id_auth;
                //        echo  $user_id_order;
                if ($user_id_auth == $user_id_order->user_id) {
                    Order::where('id', $id)->update(
                        ['order_status' => 'Cancelled']
                    );
                    $log = new OrderLog();
                    $log->order_id = $id;
                    $log->order_status = "User Cancelled";
                    $log->reason = $data['reason'];
                    $log->updated_by = "User";
                    $log->save();

                    Alert::toast('Order has been cancelled!', 'error');
                    return redirect()->back();
                } else {
                    Alert::toast('Your Order cancellation Request is not valid', 'success');
                    redirect('orders');
                }
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

    public function orderreturn($id, Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $user_id_auth = Auth::user()->id;
                $user_id_order = Order::select('user_id')->where('id', $id)->first();

                $productInfos = $data['product_info'];
                $returnRequests = [];

                if ($user_id_auth == $user_id_order->user_id) {
                    foreach ($productInfos as $productInfo) {
                    $productArr = explode("--", $productInfo);
                    $product_code = $productArr[0];
                    $product_size = $productArr[1];
                    // dd($product_code);

                    OrderProduct::where(['order_id' => $id, 'product_code' => $product_code, 'product_size' => $product_size])
                        ->update(['item_status' => 'Return Initiated']);

                    $return = new ReturnRequest();
                    $return->order_id = $id;
                    $return->user_id = $user_id_auth;
                    $return->product_size = $product_size;
                    $return->product_code = $product_code;
                    $return->return_reason = $data['return_reason'];
                    $return->return_status = "Pending";
                    $return->comment = $data['comment'];
                    $return->save();

                    $returnRequests[] = $return; // Store the ReturnRequest instances for further use or reference

                    }
                    Alert::toast('Return request has been placed for the ordered product', 'success');
                    return redirect()->back();
                  }

                } else {
                    Alert::toast('Your Order Return Request is not valid', 'error');
                    return  redirect('orders');
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