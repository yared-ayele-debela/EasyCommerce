<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use App\Models\DeliveryMan;
use App\Models\EmailTemplate;
use App\Models\InvoiceSetting;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderItemStatus;
use Illuminate\Support\Str;

use App\Models\OrderLog;
use App\Models\OrderProduct;
use Dompdf\Dompdf;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vendor;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OrdersController extends Controller
{
    //

    public function orders()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_orders')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            Session::put('page', 'orders');

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;

            if ($adminType == "vendor") {
                $vendorStatus = Auth::guard('admin')->user()->status;

                if ($vendorStatus == 0) {
                    return redirect("admin/update-vendor-details/personal")
                        ->with('error_message', 'Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business, and bank details');
                }

                $orders = Order::with(['orders_products' => function ($query) use ($vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                }])
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

            } else {
                $orders = Order::with('orders_products')
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();
            }

            // dd($orders);

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_orders')) {
                return view('admin.errors.unauthorized');
            }
            $order_status = OrderStatus::all();


            return view('admin.orders.orders', compact('appsettings', 'orders','order_status'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function filterOrders(Request $request)
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
            $order_id=$request->input("order_id");
            $product_name=$request->input('product_name');
            $customer_name=$request->input('customer_name');
            $phone_number=$request->input('phone_number');

            if ($order_id) {
                $query->where('id', $order_id);
            }


            if ($customer_name) {
                $query->where('name', 'LIKE', "%$customer_name%");
            }

            if ($product_name) {
                // Assuming 'order_product' is the relationship between Order and Product
                $query->whereHas('orders_products', function ($productQuery) use ($product_name) {
                    $productQuery->where('product_name', 'LIKE', "%$product_name%");
                });
            }

            if ($phone_number) {
                $query->where('mobile', $phone_number);
            }


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
            return view('admin.orders.orders', compact('order_status', 'orders', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    public function orderDetails($order_id)
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('view_orders_details')) {
                return view('admin.errors.unauthorized');
            }

            Session::put('page', 'orders');
            $adminType = $user->type;
            $vendor_id = $user->vendor_id;

            if ($adminType == "vendor") {
                $vendorStatus = $user->status;

                if ($vendorStatus == 0) {
                    return redirect("admin/update-vendor-details/personal")
                        ->with('error_message', 'Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business, and bank details');
                }

                $orderDetails = Order::with(['paymentInfo','orders_products' => function ($query) use ($vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                }])
                    ->where('id', $order_id)
                    ->first()
                    ->toArray();
            } else {
                $orderDetails = Order::with('orders_products','paymentInfo')
                    ->where('id', $order_id)
                    ->first()
                    ->toArray();
                    // dd($orderDetails);
            }

            $userDetails = User::find($orderDetails['user_id'])->toArray();

            $orderStatus = OrderStatus::where('status', 1)->get()->toArray();
            $orderItemStatus = OrderItemStatus::where('status', 1)->get()->toArray();
            $orderLog = OrderLog::with('orders_products')->where('order_id', $order_id)->orderBy('id', 'DESC')->get()->toArray();

            // Calculate Total Items in Cart
            $total_items = 0;
            foreach ($orderDetails['orders_products'] as $product) {
                $total_items += $product['product_qty'];
            }

            // Calculate Item Discount
            $item_discount = ($orderDetails['coupon_amount'] > 0) ? round($orderDetails['coupon_amount'] / $total_items, 2) : 0;

            $appsettings = AppSetting::all()->toArray();
            $alldelivery_boys = DeliveryMan::all()->toArray();

            return view('admin.orders.order_details', compact('alldelivery_boys', 'appsettings', 'item_discount', 'orderDetails', 'orderLog', 'userDetails', 'orderStatus', 'orderItemStatus'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function updateOrderStatus(Request $request)
{
    try {
        $admin = Auth::guard('admin')->user();
        if (!$admin || !$admin->hasPermissionByRole('update_order_status')) {
            return view('admin.errors.unauthorized');
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            $order = Order::with('user')->find($data['order_id']);

            if (!$order) {
                Alert::toast('Order not found.', 'error');
                return redirect()->back();
            }

            $oldStatus = $order->order_status;

            // Handle Paid status and create Payment
            if ($data['order_status'] === 'Paid') {
                Payment::create([
                    'order_id'       => $order->id,
                    'user_id'        => $order->user_id,
                    'payment_id'     => Str::random(16),
                    'payer_id'       => $order->user_id,
                    'payer_email'    => $order->email,
                    'amount'         => $order->grand_total,
                    'currency'       => 'Birr',
                    'payment_status' => 'approved',
                ]);
            }

            // Ensure user code matches if Delivered or Paid
            if (in_array($data['order_status'], ['Delivered', 'Paid'])) {
                if ($order->order_code !== $data['user_code']) {
                    Alert::toast('Invalid user code. Order status not updated.', 'error');
                    return redirect()->back();
                }

                // Set delivery man status to Pending
                $deliveryMan = Auth::guard(name: 'deliverymen')->user();
                if ($deliveryMan) {
                    $deliveryMan->status = 'avalilable';
                    $deliveryMan->save();
                }
            }

            // Set delivery man status for Shipped
            if ($data['order_status'] === 'Shipped') {
                $deliveryMan = Auth::guard('deliverymen')->user();
                if ($deliveryMan) {
                    $deliveryMan->status = 'delivering';
                    $deliveryMan->save();
                }
            }

            // Update order status
            $updateData = ['order_status' => $data['order_status']];

            if (!empty($data['courier_name']) && !empty($data['tracking_number'])) {
                $updateData['courier_name'] = $data['courier_name'];
                $updateData['tracking_number'] = $data['tracking_number'];
            }

            $order->update($updateData);

            // Save Order Log
            OrderLog::create([
                'order_id'     => $order->id,
                'order_status' => $data['order_status'],
            ]);

            // Notification
            NotificationService::send(
                userId: $order->user_id,
                title: 'Goods Order Status Updated',
                message: "Your goods order #{$order->id} status has changed from '{$oldStatus}' to '{$data['order_status']}'."
            );

            // SMS
            $phone = $order->user->mobile ?? null;
            if ($phone) {
                try {
                    SmsService::send(
                        $phone,
                        "Hi {$order->user->name}, Your goods order #{$order->id} status has changed from '{$oldStatus}' to '{$data['order_status']}'."
                    );
                } catch (\Exception $e) {
                    // optionally log SMS failure
                }
            }

            // Email Notification
            $emailTemplate = EmailTemplate::first();
            $email = $order->user->email;

            Mail::send('emails.order_status', [
                'email_template' => $emailTemplate,
                'email'          => $email,
                'name'           => $order->user->name,
                'order_id'       => $order->id,
                'orderDetails'   => $order->load('orders_products')->toArray(),
                'order_status'   => $data['order_status'],
            ], function ($message) use ($email) {
                $message->to($email)->subject('Order Status Updated');
            });

            Alert::toast('Order status has been updated!', 'success');
            return redirect()->back();
        }

        // If not POST method
        return redirect()->back();
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator->errors())->withInput();
    } catch (\Exception $e) {
        Alert::toast('Something went wrong!', 'error');
        return redirect()->back();
    }
}

    public function updateOrderPaymentStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        // dd($order);
        $oldStatus=$order->payment_status;
        $order->payment_status = $request->order_status;
        $order->save();

        NotificationService::send(
            userId: $order->user_id,
            title: 'Goods Order Payment Status Updated',
            message: "Your goods order #{$order->id} payment status has changed from '{$oldStatus}' to '{$request->order_status}'."
        );

        // SMS
        $phone = $order->user->mobile ?? null;
        if ($phone) {
            try {
                SmsService::send(
                    $phone,
                    "Hi {$order->user->name}, Your goods order #{$order->id} payment status has changed from '{$oldStatus}' to '{$request->order_status}'."
                );
            } catch (\Exception $e) {
                // optionally log SMS failure
            }
        }
        
            Alert::toast('Order payment status has been updated!', 'success');
            return redirect()->back();
    }


    public function updateOrderItemStatus(Request $request)
{
    // try {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->hasPermissionByRole('update_order_item_status')) {
            return view('admin.errors.unauthorized');
        }

        if (!$request->isMethod('post')) {
            return redirect()->back();
        }

        $data = $request->all();
        $orderItem = OrderProduct::find($data['order_item_id']);

        if (!$orderItem) {
            Alert::toast('Order item not found.', 'error');
            return redirect()->back();
        }

        $oldStatus = $orderItem->item_status;

        // Validate vendor code for "Shipped" status
        if ($data['order_item_status'] === 'Shipped' && $orderItem->order_product_code !== $data['vendor_code']) {
            Alert::toast('Invalid Vendor code. Ordered Product Status not updated.', 'error');
            return redirect()->back();
        }

        // Update order item status and optional tracking info
        $updateFields = ['item_status' => $data['order_item_status']];
        if (!empty($data['item_courier_name']) && !empty($data['item_tracking_number'])) {
            $updateFields['courier_name'] = $data['item_courier_name'];
            $updateFields['tracking_number'] = $data['item_tracking_number'];
        }
        $orderItem->update(attributes: $updateFields);

        // Log the status update
        $this->logOrderItemStatusChange($orderItem->order_id, $orderItem->id, $data['order_item_status']);

        // Fetch order, user, and delivery details
        $order = Order::with(['user', 'orders_products' => fn($q) => $q->where('id', $orderItem->id)])
            ->findOrFail($orderItem->order_id);
        $user = $order->user;

        // Send email
        $this->sendOrderItemStatusEmail($user, $order, $orderItem, $data);

        // Send app notification
        NotificationService::send(
            userId: $user->id,
            title: 'Order Item Status Updated',
            message: "Your order #{$order->id} status has changed from '{$oldStatus}' to '{$orderItem->item_status}'."
        );

        // Send SMS if mobile exists
        if (!empty($user->mobile)) {
            $sms = "Hi {$user->name}, Your goods order item #{$order->id} status has changed from '{$oldStatus}' to '{$orderItem->item_status}'.";
            try {
                SmsService::send($user->mobile, $sms);
            } catch (\Exception $e) {
                // log or ignore
            }
        }

        Alert::toast('Order item status has been updated!', 'success');
        return redirect()->back();

    // } catch (\Illuminate\Validation\ValidationException $e) {
    //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
    // } catch (\Exception $e) {
    //     Alert::toast('Something went wrong!', 'error');
    //     return redirect()->back();
    // }
}




    private function logOrderItemStatusChange($orderId, $orderItemId, $status)
    {
        OrderLog::create([
            'order_id' => $orderId,
            'order_item_id' => $orderItemId,
            'order_status' => $status,
        ]);
    }

    private function sendOrderItemStatusEmail($user, $order, $orderItem, $data)
    {
        $email = $user->email;
        $emailTemplate = EmailTemplate::first();

        $messageData = [
            'email_template' => $emailTemplate,
            'email' => $email,
            'name' => $user->name,
            'order_id' => $order->id,
            'orderDetails' => $order->toArray(),
            'order_status' => $data['order_item_status'],
        ];

        if (!empty($data['item_courier_name']) && !empty($data['item_tracking_number'])) {
            $messageData['courier_name'] = $data['item_courier_name'];
            $messageData['tracking_number'] = $data['item_tracking_number'];
        }

        Mail::send('emails.order_item_status', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('Order Item Status Updated');
        });
    }


    public function viewOrderInvoice($order_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if ($user && !$user->hasPermissionByRole('view_order_invoice')) {
                return view('admin.errors.unauthorized');
            }

            // Fetch order details based on the user role
            if ($user) {
                $orderDetails = Order::with('orders_products', 'deliveryBoy')
                    ->where('id', $order_id)
                    ->first();

                if (!$orderDetails) {
                    throw new \Exception('Order details not found.');
                }

                $orderDetails = $orderDetails->toArray();

                $userDetails = User::where('id', $orderDetails['user_id'])
                    ->first();

                if (!$userDetails) {
                    throw new \Exception('User details not found.');
                }

                $userDetails = $userDetails->toArray();
            } elseif ($delivery_user) {
                // Fetch order details for delivery personnel
                // Modify this section according to the data structure for delivery users
                $orderDetails = Order::with('orders_products', 'deliveryBoy')
                    ->where('id', $order_id)
                    ->first();

                if (!$orderDetails) {
                    throw new \Exception('Order details not found.');
                }

                $orderDetails = $orderDetails->toArray();

                // Fetch user details associated with the order
                $userDetails = User::where('id', $orderDetails['user_id'])
                    ->first();

                if (!$userDetails) {
                    throw new \Exception('User details not found.');
                }

                $userDetails = $userDetails->toArray();
            }

            return view('admin.orders.order_invoice', compact('orderDetails', 'userDetails'));
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function viewPDFInvoice($order_id)
    {
        $user = Auth::guard('admin')->user();
        if ($user && !$user->hasPermissionByRole('view_order_invoice')) {
            return view('admin.errors.unauthorized');
        }

        $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();
        $invoice_settings = InvoiceSetting::first();

        $userDetails = User::where('id', $orderDetails['user_id'])->first()->toArray();
        $dompdf = new Dompdf();

        $invoiceHTML = '
                         <!DOCTYPE html>
                        <html>
                        <head>
                            <title>HTML to API - Invoice</title>
                            <meta content="width=device-width, initial-scale=1.0" name="viewport">
                            <meta http-equiv="content-type" content="text-html; charset=utf-8">
                            <style type="text/css">
                                html, body, div, span, applet, object, iframe,
                                h1, h2, h3, h4, h5, h6, p, blockquote, pre,
                                a, abbr, acronym, address, big, cite, code,
                                del, dfn, em, img, ins, kbd, q, s, samp,
                                small, strike, strong, sub, sup, tt, var,
                                b, u, i, center,
                                dl, dt, dd, ol, ul, li,
                                fieldset, form, label, legend,
                                table, caption, tbody, tfoot, thead, tr, th, td,
                                article, aside, canvas, details, embed,
                                figure, figcaption, footer, header, hgroup,
                                menu, nav, output, ruby, section, summary,
                                time, mark, audio, video {
                                    margin: 0;
                                    padding: 0;
                                    border: 0;
                                    font: inherit;
                                    font-size: 100%;
                                    vertical-align: baseline;
                                }

                                html {
                                    line-height: 1;
                                }

                                ol, ul {
                                    list-style: none;
                                }

                                table {
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                }

                                caption, th, td {
                                    text-align: left;
                                    font-weight: normal;
                                    vertical-align: middle;
                                }

                                q, blockquote {
                                    quotes: none;
                                }
                                q:before, q:after, blockquote:before, blockquote:after {
                                    content: "";
                                    content: none;
                                }

                                a img {
                                    border: none;
                                }

                                article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
                                    display: block;
                                }

                                body {
                                    font-family: "Source Sans Pro", sans-serif;
                                    font-weight: 300;
                                    font-size: 12px;
                                    margin: 0;
                                    padding: 0;
                                }
                                body a {
                                    text-decoration: none;
                                    color: inherit;
                                }
                                body a:hover {
                                    color: inherit;
                                    opacity: 0.7;
                                }
                                body .container {
                                    min-width: 500px;
                                    margin: 0 auto;
                                    padding: 0 20px;
                                }
                                body .clearfix:after {
                                    content: "";
                                    display: table;
                                    clear: both;
                                }
                                body .left {
                                    float: left;
                                }
                                body .right {
                                    float: right;
                                }
                                body .helper {
                                    display: inline-block;
                                    height: 100%;
                                    vertical-align: middle;
                                }
                                body .no-break {
                                    page-break-inside: avoid;
                                }

                                header {
                                    margin-top: 20px;
                                    margin-bottom: 50px;
                                }
                                header figure {
                                    float: left;
                                    width: 60px;
                                    height: 60px;
                                    margin-right: 10px;
                                    background-color: ' . $invoice_settings->background_color . ';
                                    border-radius: 50%;
                                    text-align: center;
                                }
                                header figure img {
                                    margin-top: 13px;
                                }
                                header .company-address {
                                    float: left;
                                    max-width: 150px;
                                    line-height: 1.7em;
                                }
                                header .company-address .title {
                                    color: ' . $invoice_settings->background_color . ';
                                    font-weight: 400;
                                    font-size: 1.5em;
                                    text-transform: uppercase;
                                }
                                header .company-contact {
                                    float: right;
                                    height: 60px;
                                    padding: 0 10px;
                                    background-color: ' . $invoice_settings->background_color . ';
                                    color: white;
                                }
                                header .company-contact span {
                                    display: inline-block;
                                    vertical-align: middle;
                                }
                                header .company-contact .circle {
                                    width: 20px;
                                    height: 20px;
                                    background-color: white;
                                    border-radius: 50%;
                                    text-align: center;
                                }
                                header .company-contact .circle img {
                                    vertical-align: middle;
                                }
                                header .company-contact .phone {
                                    height: 100%;
                                    margin-right: 20px;
                                }
                                header .company-contact .email {
                                    height: 100%;
                                    min-width: 100px;
                                    text-align: right;
                                }

                                section .details {
                                    margin-bottom: 55px;
                                }
                                section .details .client {
                                    width: 50%;
                                    line-height: 20px;
                                }
                                section .details .client .name {
                                    color: ' . $invoice_settings->background_color . ';
                                }
                                section .details .data {
                                    width: 50%;
                                    text-align: right;
                                }
                                section .details .title {
                                    margin-bottom: 15px;
                                    color: ' . $invoice_settings->background_color . ';
                                    font-size: 3em;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                }
                                section table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                    font-size: 0.9166em;
                                }
                                section table .qty, section table .unit, section table .total {
                                    width: 15%;
                                }
                                section table .desc {
                                    width: 55%;
                                }
                                section table thead {
                                    display: table-header-group;
                                    vertical-align: middle;
                                    border-color: inherit;
                                }
                                section table thead th {
                                    padding: 5px 10px;
                                    background: ' . $invoice_settings->background_color . ';
                                    border-bottom: 5px solid #FFFFFF;
                                    border-right: 4px solid #FFFFFF;
                                    text-align: right;
                                    color: white;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                }
                                section table thead th:last-child {
                                    border-right: none;
                                }
                                section table thead .desc {
                                    text-align: left;
                                }
                                section table thead .qty {
                                    text-align: center;
                                }
                                section table tbody td {
                                    padding: 10px;
                                    background: ' . $invoice_settings->background_color . ';
                                    color:white;
                                    text-align: right;
                                    border-bottom: 5px solid #FFFFFF;
                                    border-right: 4px solid #E8F3DB;
                                }
                                section table tbody td:last-child {
                                    border-right: none;
                                }
                                section table tbody h3 {
                                    margin-bottom: 5px;
                                    color: ' . $invoice_settings->background_color . ';
                                    font-weight: 600;
                                }
                                section table tbody .desc {
                                    text-align: left;
                                }
                                section table tbody .qty {
                                    text-align: center;
                                }
                                section table.grand-total {
                                    margin-bottom: 45px;
                                }
                                section table.grand-total td {
                                    padding: 5px 10px;
                                    border: none;
                                    color: #777777;
                                    text-align: right;
                                }
                                section table.grand-total .desc {
                                    background-color: transparent;
                                }
                                section table.grand-total tr:last-child td {
                                    font-weight: 600;
                                    color: ' . $invoice_settings->background_color . ';
                                    font-size: 1.18181818181818em;
                                }

                                footer {
                                    margin-bottom: 20px;
                                }
                                footer .thanks {
                                    margin-bottom: 40px;
                                    color: ' . $invoice_settings->background_color . ';
                                    font-size: 1.16666666666667em;
                                    font-weight: 600;
                                }
                                footer .notice {
                                    margin-bottom: 25px;
                                }
                                footer .end {
                                    padding-top: 5px;
                                    border-top: 2px solid ' . $invoice_settings->background_color . ';
                                    text-align: center;
                                }
                            </style>
                        </head>

                        <body>
                            <header class="clearfix">
                                <div class="container">
                                    <h1 style="text-align:center;font-size:40px;">Delivery Note </h1>
                                    <div class="company-address">
                                        <h2 class="title">' . $invoice_settings->name . '</h2>
                                        <p>
                                          ' . $invoice_settings->address . '
                                        </p><br>
                                        <p>
                                         ' . $invoice_settings->email . '
                                        </p><br>
                                        <p>
                                        ' . $invoice_settings->phone . '

                                        </p>

                                    </div>
                                </div>
                            </header>

                            <section>
                                <div class="container">
                                    <div class="details clearfix">
                                        <div class="client left">
                                            <p>INVOICE TO:</p>
                                            <p class="name">' . $orderDetails['name'] . '</p>
                                            <p>' . $orderDetails['address'] . ', ' . $orderDetails['city'] . ', ' . $orderDetails['state'] . ',
                                            ' . $orderDetails['country'] . ', ' . $orderDetails['pincode'] . '
                                            </p>
                                            <a href="mailto:' . $orderDetails['email'] . '">' . $orderDetails['email'] . '</a>
                                        </div>
                                        <div class="data right">
                                            <div class="title">Order ID: ' . $orderDetails['id'] . '</div>
                                            <div class="date">
                                                Order Date: ' . date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) . '<br>
                                                Order Amount : ' . $orderDetails['grand_total'] . ' BIRR <br>
                                                Order Status : ' . $orderDetails['order_status'] . ' <br>
                                               Payment Method : ' . $orderDetails['payment_method'] . ' <br>

                                            </div>
                                        </div>
                                    </div>

                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="desc">Product Code</th>
                                                <th class="qty">Size</th>
                                                <th class="qty">Color</th>
                                                <th class="qty">Quantity</th>
                                                <th class="unit">Unit Price</th>
                                                <th class="total">Total </th>

                                            </tr>
                                        </thead>
                                        <tbody>';
        $subTotal = 0;
        foreach ($orderDetails['orders_products'] as $product) {
            $invoiceHTML .= '<tr>
                                                <td class="desc">' . $product['product_code'] . '</td>
                                                <td class="qty">' . $product['product_size'] . '</td>
                                                <td class="qty">' . $product['product_color'] . '</td>
                                                <td class="qty">' . $product['product_qty'] . '</td>
                                                <td class="unit">' . $product['product_price'] . 'BIRR</td>
                                                <td class="total">' . $product['product_price'] * $product['product_qty'] . ' BIRR</td>
                                            </tr>';
            $subTotal = $subTotal + ($product['product_price'] * $product['product_qty']);
        }
        $invoiceHTML .= '</tbody>
                                    </table>
                                    <div class="no-break">
                                        <table cl ass="grand-total">
                                            <tbody>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="unit" colspan=2>SUBTOTAL:</td>
                                                    <td class="total">' . $subTotal . ' BRR</td>
                                                </tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="unit" colspan=2>SHIPPING</td>
                                                    <td class="total"> 0 BIRR</td>
                                                </tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="unit" colspan=2>DISCOUNT</td>';
        if ($orderDetails['coupon_amount'] > 0) {
            $invoiceHTML .= '<td class="total">' . $orderDetails['coupon_amount'] . ' BIRR</td>';
        } else {
            $invoiceHTML .= '<td class="total"> 0 BIRR </td>';
        }
        $invoiceHTML .= '</tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="total" colspan="2">TOTAL:</td>
                                                    <td class="total">' . $orderDetails['grand_total'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <footer>
                                <div class="container">
                                    <div class="thanks">Thank you!</div>
                                    <div class="end">' . $invoice_settings->footer_text . '</div>
                                </div>
                            </footer>

                        </body>

                        </html>

            ';

        $dompdf->loadHtml($invoiceHTML);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

        return view('admin.orders.order_invoice', compact('orderDetails', 'userDetails'));
    }
    public function return_request()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_return_request')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();

            $vendor_type=Auth::guard('admin')->user()->type;
            $vendor_id=Auth::guard('admin')->user()->vendor_id;

            if($vendor_type=="vendor"){
                $order = DB::table('orders')
                ->join('orders_products', 'orders.id', '=', 'orders_products.order_id')
                ->where('orders_products.vendor_id', $vendor_id)->get();
                $return_request = []; // Initialize an empty array

             if (count($order) != 0) {
                    foreach ($order as $order) {
                        $return_requests = ReturnRequest::where('order_id',$order->order_id)->get()->toArray();
                        if (!empty($return_requests)) {
                            $return_request = array_merge($return_request, $return_requests);
                        }
            }
                return view('admin.return_request.list_return_request', compact('appsettings', 'return_request'));
             }else{
                return view('admin.return_request.list_return_request',compact('appsettings','return_request'));
            }

            }
            else
            {

            $return_request = ReturnRequest::get()->toArray();
            return view('admin.return_request.list_return_request', compact('appsettings', 'return_request'));
            }

        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function return_requestUpdate(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('edit_return_request')) {
                return view('admin.errors.unauthorized');
            }

            if ($request->isMethod('post')) {
                $data = $request->all();
                $returnDetails = ReturnRequest::where('id', $data['return_id'])->first();

                // dd($returnDetails);
                if (!$returnDetails) {
                    throw new \Exception('Return details not found.');
                }

                $returnDetails = $returnDetails->toArray();

                ReturnRequest::where('id', $data['return_id'])->update(['return_status' => $data['return_status']]);

                OrderProduct::where([
                    'order_id' => $returnDetails['order_id'],
                    'product_code' => $returnDetails['product_code']
                ])->update(['item_status' => 'Return ' . $returnDetails['return_status']]);

                $userDetails = User::select('name', 'email')->where('id', $returnDetails['user_id'])->first();

                if (!$userDetails) {
                    throw new \Exception('User details not found.');
                }

                $userDetails = $userDetails->toArray();
                $email_template = EmailTemplate::first();

                $email = $userDetails['email'];
                $return_status = $data['return_status'];
                $messageData = [
                    'email_template' => $email_template,
                    'userDetails' => $userDetails,
                    'returnDetails' => $returnDetails
                ];

                Mail::send('emails.return_request', $messageData, function ($message) use ($email, $return_status) {
                    $message->to($email)->subject('Return Request ' . $return_status);
                });


                Alert::toast('Return Request has been ' . $return_status, 'success');
                return redirect('admin/return_request');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong', 'error');
            return redirect()->back();
        }
    }
}