
<style type="text/css">

    body {
        font-family: 'Roboto Condensed', sans-serif;
        margin: 0;
        padding: 0;
        /* background-color: #f9f9f9; Setting a light background color */
    }

        .m-0{
            margin: 0px;
        }
        .p-0{
            padding: 0px;
        }
        .pt-5{
            padding-top:5px;
        }
        .mt-10{
            margin-top:10px;
        }
        .text-center{
            text-align:center !important;
        }
        .w-100{
            width: 100%;
        }
        .w-50{
            width:50%;
        }
        .w-85{
            width:85%;
        }
        .w-15{
            width:15%;
        }
        .logo img{
            width:200px;
            height:60px;
        }
        .gray-color{
            color:#5D5D5D;
        }
        .text-bold{
            font-weight: bold;
        }
        .border{
            border:1px solid black;
        }
        table tr,th,td{
            border: 1px solid #d2d2d2;
            border-collapse:collapse;
            padding:7px 8px;
        }
        table tr th{
            background: #F4F4F4;
            font-size:15px;
        }
        table tr td{
            font-size:13px;
        }
        table{
            border-collapse:collapse;
        }
        .box-text p{
            line-height:10px;
        }
        .float-left{
            float:left;
        }
        .total-part{
            font-size:16px;
            line-height:12px;
        }
        .total-right p{
            padding-right:20px;
        }
        /* Styles for the download button */

    </style>

    <div class="head-title">
        <h1 class="text-center m-0 p-0">Delivery Note</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">Order Id : <span class="gray-color">{{ $custom_order->id }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">Order Date : <span class="gray-color">{{ $custom_order->created_at->format('d/m/Y') }}</span></p>
        </div>
        <div class="w-50 float-left logo mt-10">
            <h1 class="text-center m-0 p-0">{{ $appsettings[0]['application_title'] }}</h1>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">

        <table class="table w-50 mt-10">
            <tr>
                <th class="w-50">Customer Information</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p class="card-text"><b>Customer Name : </b> {{$custom_order->customer_name }}</p>
                        <p class="card-text"><b>Phone Number :</b> {{$custom_order->phone_number }}</p>
                        <p class="card-text"><b>Delivery by :</b> {{$custom_order->deliveryBoy->first_name  }} {{$custom_order->deliveryBoy->last_name  }}</p>
                    </div>
                </td>

            </tr>
        </table>
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-10">Id</th>
                <th class="w-30">Product Name</th>
                <th class="w-10">Qty</th>
                <th class="w-50">Description</th>
                <th class="w-10">Status</th>
                <th class="w-20">Order Date</th>

            </tr>
            <tr align="center">
                @foreach ($custom_order->custom_order_product as $product)
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['product_name'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>{{ $product['description'] }}</td>
                <td>{{ $product['delivery_status'] }}</td>
                <td>{{ $product['created_at']->format('d/m/Y') }}</td>

                @endforeach
            </tr>
            <tr>
                <td colspan="6">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="right">
                            <p>Order Status</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>
                                <strong>{{$custom_order->status }}</strong>
                            </p>
                        </div>
                        <div style="clear: both;">
                        <!-- HTML !-->
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
