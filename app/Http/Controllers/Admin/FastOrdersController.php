<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\DeliveryMan;
use App\Models\FastOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class FastOrdersController extends Controller
{
    //
    public function index()
    {

        $appsettings = AppSetting::all()->toArray();

        $fast_orders = FastOrders::all();
        return view('admin.fastorder.index', compact('fast_orders', 'appsettings'));
    }


    public function detail($id)
    {
        $appsettings = AppSetting::all()->toArray();
        $alldelivery_boys = DeliveryMan::all()->where('status', 'pending');
        $fast_orders = FastOrders::with('user')->find($id);
        //  dd($alldelivery_boys);
        return view('admin.fastorder.detail', compact('appsettings', 'fast_orders', 'alldelivery_boys'));
    }

    public function updateStatus(Request $request)
    {
        $fast_order = FastOrders::find($request->input('order_id'));
        // dd($update);
        if ($fast_order) {
            // dd($fast_order);
            $fast_order->status = $request->input('order_status');
            $fast_order->save();

            $orderDetails = FastOrders::with('user')->where('id', $request->input('order_id'))->first()->toArray();

            $email = $orderDetails['user']['email'];
            // dd($email);
            $messageData = [
                'email' => $email,
                'name' => $orderDetails['user']['name'],
                'order_id' => $request->input('order_id'),
                'orderDetails' => $orderDetails,
                'status' => $request->input('order_status'),
            ];

            Mail::send('emails.fast_order_status', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Fast Order Item Status Updated - Byt Developers.in');
            });

            Alert::toast('Order status updated ', 'success');
            return back();
        } else {
            Alert::toast('Something Went wrong!', 'error');
            return back();
        }
    }

    public function assign_to_delivery_boy(Request $request)
    {
        // dd($request->all());
        $fast_order = FastOrders::find($request->input('order_id'));
        // dd($fast_order);
        if (($fast_order->delivery_boy_id) == ($request->input('delivery_boy_id'))) {
            notify()->error('This fast_order is already assigned to this delivery boy', 'Error');
            return back();
        }

        $fast_order->delivery_boy_id = $request->input('delivery_boy_id');
        $fast_order->save();


        $deliveryDetails = DeliveryMan::select('first_name', 'last_name', 'email')->where('id', $request->input('delivery_boy_id'))->first()->toArray();
        $orderDetails = FastOrders::with('user')->where('id', $request->input('order_id'))->first()->toArray();

        // dd($orderDetails);
        //Send Order Status Update Email
        $email = $deliveryDetails['email'];
        $messageData = [
            'email' => $email,
            'first_name' => $deliveryDetails['first_name'],
            'last_name' => $deliveryDetails['last_name'],
            'order_id' => $request->input('order_id'),
            'orderDetails' => $orderDetails,
            'status' => $request->input('order_status'),
        ];

        Mail::send('emails.assing_fast_order_to_delivery_boy', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('New fast order has been assigned to you for delivery - Byt Developers.in');
        });


        $email = $orderDetails['user']['email'];
        // dd($email);
        $messageData = [
            'email' => $email,
            'name' => $orderDetails['user']['name'],
            'order_id' => $request->input('order_id'),
            'orderDetails' => $orderDetails,
            'status' => $request->input('order_status'),
        ];

        Mail::send('emails.send_to_user_fast_order', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('Order Confirmation - Your Recent Purchase with BYT Developers');
        });

        Alert::toast('order has been assigned to delivery boy', 'success');
        return redirect()->back();
    }
}
