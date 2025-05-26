<!DOCTYPE html>
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
            background-color: #ffffff; /* Setting a light background color */
        }
            .container {
            max-width: 800px; /* Adjust the max-width of the container for better readability */
            margin: 0 auto;
            margin-top: 20px; /* Center the container */
            padding: 20px;
            background-color: #ffffff; /* White background for the invoice */
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
            <h1 class="text-center m-0 p-0">Delivery Note</h1>
            <div class="download-button">
                <a onclick="window.print()" href="javascript:void(0);">
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
                <p class="m-0"><b>Order Id:</b> <span class="text-muted">{{ $custom_order->id }}</span></p>
                <p class="m-0"><b>Order Date:</b> <span class="text-muted">{{ $custom_order->created_at->format('d/m/Y') }}</span></p>
            </div>
            <div class="float-right logo mt-10">
                <img src="{{ asset('/storage/appsettings/'.$appsettings[0]['logo']) }}" style="max-width: 200px; height: auto; left:0%">
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="row mt-4" >
            <div class="col-md-6">
              <br>
              <p><b>Customer information</b></p>
              <p class="card-text mt-2"><b>Name:</b> </b> {{$custom_order->customer_name }}</p>
              <p class="card-text"><b>Mobile number:</b></b> {{$custom_order->phone_number }}</p>
              <p class="card-text"><b>Delivery by:</b>
                 @if($custom_order->deliveryBoy)
                 {{$custom_order->deliveryBoy->first_name  }} {{$custom_order->deliveryBoy->last_name  }}
                 @else

                 @endif
                </p>

            </div>
          </div>
        <div class="table-responsive mt-4" >
            <table class="table" style="width: 100%">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Product Name</th>
                  <th>Qty</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Order Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($custom_order->custom_order_product as $product)
                <tr>
                  <td><?php echo DNS1D::getBarcodeHTML($product['id'], 'C39'); ?>
                  </td>
                  <td>{{ $product['product_name'] }}</td>
                  <td>{{ $product['quantity'] }}</td>
                  <td>{{ $product['description'] }}</td>
                  <td>
                    @if($product['delivery_status'])
                    {{ $product['delivery_status'] }}
                    @else
                    Pending
                    @endif
                </td>
                  <td>{{ $product['created_at']->format('d/m/Y') }}</td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="text-right">Order Status: <strong>{{$custom_order->delivery_status }}</strong> </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
</body>
</html>
