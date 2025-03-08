{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">

@print {
    @page :footer {
        display: none
    }

    @page :header {
        display: none
    }
}
        body {
            font-family: 'Roboto Condensed', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9; /* Setting a light background color */
        }
            .container {
            max-width: 800px; /* Adjust the max-width of the container for better readability */
            margin: 0 auto;
            margin-top: 20px; /* Center the container */
            padding: 20px;
            background-color: #fff; /* White background for the invoice */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Adding a subtle shadow */
            border-radius: 5px; /* Rounded corners */
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
            .float-right{
                float:right;
            }
            .total-part{
                font-size:16px;
                line-height:12px;
            }
            .total-right p{
                padding-right:20px;
            }
            /* Styles for the download button */
        .download-button {
            text-align: right;
            margin-bottom: 20px;
        }

        .btn-download {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-download:hover {
            background-color: #45a049;
        }
        </style>

</head>
<body>
            <div class="container">
        <div class="head-title">
            <h1 class="text-center m-0 p-0">Good receiving voucher (GRV)</h1>
            <div class="download-button">
                <a onclick="window.print()">
                    <svg style="height:20px; width:30px;color:black;" class="w-1 h-1 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 20h10a1 1 0 0 0 1-1v-5H4v5a1 1 0 0 0 1 1Z"/>
                        <path d="M18 7H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2v-3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-1-2V2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3h14Z"/>
                      </svg>
                </a>
            </div>
        </div>
        <div class="add-detail mt-10">
            <div class="w-50 float-left mt-10">
                <div id="barcode" class="gray-color"></div>
                <p class="m-0 pt-5 text-bold  d-flex">Transfer ID : <span class="gray-color"><?php echo DNS1D::getBarcodeHTML($all_product_stocks->id, 'C39'); ?></span></p>
                <p class="m-0 pt-5 text-bold w-100">Transfer Date : <span class="gray-color">{{ $all_product_stocks->transfer_date }}</span></p>
            </div>
            <div class="float-right logo mt-10">
                <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['logo']) }}" style="max-width: 200px; height: auto; left:0%">
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <tr>
                    <th class="w-50">From : {{ $all_product_stocks->fromWarehouse->name }}</th>
                    <th class="w-50">To : {{ $all_product_stocks->toWarehouse->name }}</th>
                </tr>
                <tr>
                    <td>
                        <div class="box-text">
                            <p class="card-text"><b>Address : </b> {{ $all_product_stocks->fromWarehouse->address }}</p>
                            <p class="card-text"><b>Mobile Number : </b> {{ $all_product_stocks->fromWarehouse->phone }}</p>
                            <p class="card-text"><b>Email :</b> {{ $all_product_stocks->fromWarehouse->email }}</p>
                            <p class="card-text"><b>State :</b> {{ $all_product_stocks->fromWarehouse->state }}</p>
                            <p class="card-text"><b>Country : </b> {{ $all_product_stocks->fromWarehouse->country }}</p>
                        </div>
                    </td>
                    <td>
                        <div class="box-text">
                            <p class="card-text"><b>Address : </b> {{ $all_product_stocks->toWarehouse->address }}</p>
                            <p class="card-text"><b>Mobile Number : </b> {{ $all_product_stocks->toWarehouse->phone }}</p>
                            <p class="card-text"><b>Email :</b> {{ $all_product_stocks->toWarehouse->email }}</p>
                            <p class="card-text"><b>State :</b> {{ $all_product_stocks->toWarehouse->state }}</p>
                            <p class="card-text"><b>Country : </b> {{ $all_product_stocks->toWarehouse->country }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <tr>
                    <th class="w-50">Product Name</th>
                    <th class="w-50">Product Code</th>
                    <th class="w-50">Category</th>
                    <th class="w-50">Qty</th>
                    <th class="w-50">Transfer Note</th>
                </tr>
                <tr align="center">
                    <td>{{ $all_product_stocks->product->product_name }}</td>
                    <td>{{ $all_product_stocks->product->product_code }}</td>
                    <td> {{ $all_product_stocks->product->category->name }}</td>
                    <td>{{ $all_product_stocks->quantity }}</td>
                    <td>{{ $all_product_stocks->notes }}</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="total-part">
                            <div class="total-left w-85 float-left" align="right">
                                <p>Transfer Status</p>
                            </div>
                            <div class="total-right w-15 float-left text-bold" align="right">
                                <p>
                                 {{ $all_product_stocks->delivery_status }}
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
        </div>


</body>
</html> --}}
