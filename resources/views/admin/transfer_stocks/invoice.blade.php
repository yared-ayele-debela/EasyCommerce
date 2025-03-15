<!DOCTYPE html>
<html>
<head>
    <title>How To Generate Invoice PDF In Laravel 9 - Techsolutionstuff</title>
</head>
<style type="text/css">

    body{
        font-family: 'Roboto Condensed', sans-serif;
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
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Transfer Id : <span class="gray-color">{{ $stock_products->transfer_stock_product->id }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Transfer Date : <span class="gray-color">{{ $stock_products->transfer_stock_product->transfer_date }}</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">
        <h1 class="text-center m-0 p-0">{{ $appsettings[0]['application_title'] }}</h1>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">From : {{ $stock_products->transfer_stock_product->fromWarehouse->name }}</th>
            <th class="w-50">To : {{ $stock_products->transfer_stock_product->toWarehouse->name }}</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p class="card-text"><b>Address : </b> {{ $stock_products->transfer_stock_product->fromWarehouse->address }}</p>
                    <p class="card-text"><b>Mobile Number : </b> {{ $stock_products->transfer_stock_product->fromWarehouse->phone }}</p>
                    <p class="card-text"><b>Email :</b> {{ $stock_products->transfer_stock_product->fromWarehouse->email }}</p>
                    <p class="card-text"><b>State :</b> {{ $stock_products->transfer_stock_product->fromWarehouse->state }}</p>
                    <p class="card-text"><b>Country : </b> {{ $stock_products->transfer_stock_product->fromWarehouse->country }}</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p class="card-text"><b>Address : </b> {{ $stock_products->transfer_stock_product->toWarehouse->address }}</p>
                    <p class="card-text"><b>Mobile Number : </b> {{ $stock_products->transfer_stock_product->toWarehouse->phone }}</p>
                    <p class="card-text"><b>Email :</b> {{ $stock_products->transfer_stock_product->toWarehouse->email }}</p>
                    <p class="card-text"><b>State :</b> {{ $stock_products->transfer_stock_product->toWarehouse->state }}</p>
                    <p class="card-text"><b>Country : </b> {{ $stock_products->transfer_stock_product->toWarehouse->country }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
=            <th class="w-50">Product Name</th>
=            <th class="w-50">Product Code</th>
            <th class="w-50">Category</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Transfer Note</th>
        </tr>
        <tr align="center">
            <td>{{ $stock_products->transfer_stock_product->product->product_name }}</td>
            <td>{{ $stock_products->transfer_stock_product->product->product_code }}</td>
            <td> {{ $stock_products->transfer_stock_product->product->category->name }}</td>
            <td>{{ $stock_products->transfer_stock_product->quantity }}</td>
            <td>{{ $stock_products->transfer_stock_product->notes }}</td>
        </tr>
        <tr>
            <td colspan="5">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Transfer Status</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p> 
                         {{ $stock_products->transfer_stock_product->delivery_status }}
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
</html>

