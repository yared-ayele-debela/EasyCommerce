@extends('dashboard.layouts.layouts')

@section('dashboard')
<style>

    #time {
      font-size: 3em;
      font-family: Arial, sans-serif;

    }

    #date {
      font-size: 1.5em;
      margin-top: -20px;
      font-family: Arial, sans-serif;

    }

    #greeting {
      font-size: 1.2em;
      font-weight: bold;
      color: #333;
      margin-top: 20px;
      font-family: Arial, sans-serif;

    }
  </style>

{{-- <div class="section p-2 bg-light shadow-sm d-flex" style="border-radius: 0.2rem;">
    <div class="container">
        <h1 id="time" style="color: rgb(92,168,255);"></h1>
        <br>
        <h2 id="date" style="color:rgb(52,217,184);"></h2>
      </div>
      <p id="greeting" style="color:rgb(52,217,184);">
      </p>
</div>
<br> --}}

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

@if(Auth::guard('admin')->user()->type=="admin")
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Admins<span class="text-white"> </span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Administrator_Male_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(1.11 0 0 1.11 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -12)" d="M 12 3 C 9.790861000676827 3 8 4.790861000676826 8 7 C 8 9.209138999323173 9.790861000676827 11 12 11 C 14.209138999323173 11 16 9.209138999323173 16 7 C 16 4.790861000676826 14.209138999323173 3 12 3 z M 12 14 C 11.686 14 11.334844 14.019734 10.964844 14.052734 L 9 17 L 7.4921875 14.740234 C 5.1331875 15.463234 3 17.072266 3 17.072266 L 3 21 L 21 21 L 21 17.072266 C 21 17.072266 18.866812 15.463234 16.507812 14.740234 L 15 17 L 13.035156 14.052734 C 12.665156 14.019734 12.314 14 12 14 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6  class=" text-white">{{ $alladmins }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Delivery Boy <span class="text-white"></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Delivery_Boy_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.16 0 0 0.16 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-63.9, -64.5)" d="M 64 2 C 57.4 2 51.000781 3.7003906 45.300781 6.9003906 C 45.300781 6.9003906 45.199219 6.9 45.199219 7 C 35.699219 5.7 26.599219 6.6 20.199219 11 C 16.399219 13.6 14.499609 17.3 14.599609 21.5 C 14.799609 31.5 26.400391 41.999609 27.400391 42.599609 C 28.100391 42.999609 29.000781 43.200391 29.800781 42.900391 C 52.200781 36.500391 75.799219 36.500391 98.199219 42.900391 C 98.399219 43.000391 98.7 43 99 43 C 99.6 43 100.30078 42.800391 100.80078 42.400391 C 101.60078 41.800391 102 40.9 102 40 C 102 19 85 2 64 2 z M 64 8 C 80.3 8 93.800781 20.2 95.800781 36 C 74.100781 30.6 51.400781 30.799219 29.800781 36.699219 C 26.800781 33.899219 20.499609 26.5 20.599609 21 C 20.699609 19 21.599609 17.4 23.599609 16 C 27.199609 13.5 32.1 12.5 37.5 12.5 C 52.5 12.5 71.699609 20.599219 80.099609 29.199219 C 81.299609 30.399219 83.200781 30.400781 84.300781 29.300781 C 85.500781 28.100781 85.500391 26.199609 84.400391 25.099609 C 78.200391 18.699609 67.1 12.700781 55.5 9.3007812 C 58.2 8.4007812 61.1 8 64 8 z M 109.66406 43.375 C 108.70215 43.303711 107.72461 43.6875 107.09961 44.5 C 106.09961 45.8 106.29961 47.699219 107.59961 48.699219 C 108.99961 49.799219 109.80078 51.8 109.80078 54 C 109.80078 57.3 108.00078 60 105.80078 60 C 103.60078 60 101.80078 57.3 101.80078 54 C 101.80078 53.4 101.60078 52.900391 101.30078 52.400391 L 101.09961 52.099609 C 100.39961 50.999609 99.100391 50.500781 97.900391 50.800781 C 96.700391 51.100781 95.699609 52.200391 95.599609 53.400391 C 94.099609 71.300391 79.8 92 64 92 C 62.4 92 61.1 93.200781 61 94.800781 C 60.9 96.400781 61.999609 97.8 63.599609 98 L 74.300781 99.400391 C 75.900781 99.600391 77.499609 99.799609 79.099609 100.09961 C 74.399609 108.09961 71.200391 113.09961 63.900391 113.09961 C 56.600391 113.09961 53.299609 108.10039 48.599609 99.900391 L 47.400391 97.800781 L 46.5 96.099609 C 45.8 94.899609 44.399609 94.299219 43.099609 94.699219 C 41.399609 95.199219 39.800781 95.6 38.300781 96 C 23.100781 100 11 103.1 11 124 C 11 125.7 12.3 127 14 127 C 15.7 127 17 125.7 17 124 C 17 107.7 24.600781 105.69922 39.800781 101.69922 C 40.700781 101.49922 41.500391 101.2 42.400391 101 C 42.700391 101.6 43.100391 102.20078 43.400391 102.80078 C 47.800391 110.40078 52.800391 119 63.900391 119 C 75.000391 119 80.000391 110.40078 84.400391 102.80078 C 84.700391 102.30078 85.000781 101.69922 85.300781 101.19922 C 88.200781 101.79922 90.899609 102.49922 93.599609 103.19922 C 105.49961 106.59922 110.80078 110.4 110.80078 124 C 110.80078 125.7 112.10078 127 113.80078 127 C 115.50078 127 116.80078 125.7 116.80078 124 C 116.80078 105.2 106.59922 100.7 95.199219 97.5 C 89.699219 95.9 84.000391 94.700781 77.900391 93.800781 C 88.000391 87.700781 95.999219 75.9 99.699219 63.5 C 101.39922 65 103.50078 66 105.80078 66 C 111.30078 66 115.80078 60.6 115.80078 54 C 115.80078 50 114.10078 46.2 111.30078 44 C 110.81328 43.625 110.24121 43.417773 109.66406 43.375 z M 15 51 C 13.3 51 12 52.3 12 54 C 12 60.6 16.5 66 22 66 C 24.3 66 26.399609 65.1 28.099609 63.5 C 30.599609 72.2 35.400391 80.7 41.400391 87 C 42.000391 87.6 42.799609 87.900391 43.599609 87.900391 C 44.299609 87.900391 45.099219 87.599609 45.699219 87.099609 C 46.899219 85.999609 46.900781 84.100391 45.800781 82.900391 C 38.600781 75.300391 33.400781 64.200391 32.300781 53.900391 C 32.200781 53.200391 31.900391 52.599609 31.400391 52.099609 L 31.199219 51.900391 C 30.299219 51.000391 29.100391 50.799219 27.900391 51.199219 C 26.700391 51.699219 26 52.8 26 54 C 26 57.3 24.2 60 22 60 C 19.8 60 18 57.3 18 54 C 18 52.3 16.7 51 15 51 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6  class=" text-white">{{ $alldeliveryboys }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-yellow border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Customers <span class="text-white"></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Multiple_Neutral_1_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.83 0 0 0.83 12 12)" >
                                        <g style="" >
                                        <g transform="matrix(1 0 0 1 -3 0)" >
                                        <path style="stroke: rgb(255, 253, 253); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-9, -12)" d="M 17.5 22 L 17.5 20.5 C 17.5 16.547 14.6 15.908999999999999 11.866 14.9 C 10.956999999999999 14.563 11.107 12.190000000000001 11.509 11.747 C 12.453 10.708 13.255 9.49 13.255 6.547 C 13.255 3.578 11.318 2 9 2 C 6.682 2 4.745 3.578 4.745 6.545 C 4.745 9.487 5.545 10.705 6.491 11.745000000000001 C 6.891 12.188 7.042999999999999 14.561 6.1339999999999995 14.898000000000001 C 3.449 15.891 0.5 16.517 0.5 20.5 L 0.5 22 Z" stroke-linecap="round" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 6.75 0)" >
                                        <path style="stroke: rgb(255, 255, 255); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-18.75, -12)" d="M 20 22 L 23.5 22 L 23.5 20.5 C 23.5 16.547 20.6 15.908999999999999 17.866 14.9 C 16.957 14.563 17.107 12.190000000000001 17.509 11.747 C 18.453 10.708 19.255 9.49 19.255 6.547 C 19.255 3.578 17.318 2 15 2 C 14.6640969299437 1.998484185822569 14.328951362891337 2.031998742527805 13.999999999999998 2.1000000000000005" stroke-linecap="round" />
                                        </g>
                                        </g>
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $allusers }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-pink border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Vendors <span class="text-white"></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Farmers_Market_Vendor_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.83 0 0 0.83 12 12)" >
                                        <g style="" >
                                        <g transform="matrix(1 0 0 1 0 0)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -12)" d="M 22.67 3.77 L 12.66 0.11 C 12.229648078463985 -0.04172465275594166 11.760351921536015 -0.0417246527559416 11.33 0.11000000000000022 L 1.33 3.75 C 0.527223038610643 4.035393551593484 -0.0066209919984530075 4.798027881035049 0 5.6499999999999995 L 0 23 C 0 23.552284749830793 0.44771525016920655 24 1 24 C 1.5522847498307935 24 2 23.552284749830793 2 23 L 2 6.34 C 2.004359612075528 5.922641559370838 2.267475862935537 5.5518868422499175 2.66 5.41 L 11.66 2.12 C 11.88271569022584 2.0381369131279152 12.12728430977416 2.0381369131279152 12.35 2.12 L 21.35 5.41 C 21.74594744176174 5.553150200510095 22.00982086500632 5.928969924525099 22.01 6.349999999999999 L 22.01 23 C 22.01 23.552284749830793 22.45771525016921 24 23.01 24 C 23.562284749830795 24 24.01 23.552284749830793 24.01 23 L 24.01 5.65 C 24.00662483870037 4.802765140909009 23.469782248325753 4.049582999189399 22.67 3.7700000000000005 Z" stroke-linecap="round" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 0 9)" >
                                        <rect style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(245, 245, 245); fill-rule: nonzero; opacity: 1;" x="-7.5" y="-3" rx="1" ry="1" width="15" height="6" />
                                        </g>
                                        <g transform="matrix(1 0 0 1 0.02 -0.66)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12.02, -11.34)" d="M 9.9 13.86 C 9.067138368172227 14.286949027505687 8.37333185512633 14.942596182334059 7.899999999999999 15.750000000000002 C 7.81068360252296 15.904700538379252 7.81068360252296 16.095299461620748 7.9 16.25 C 7.988776147715773 16.403772267987147 8.152444470098436 16.498928269372414 8.33 16.5 L 15.71 16.5 C 15.887555529901565 16.498928269372414 16.051223852284227 16.403772267987147 16.14 16.25 C 16.229316397477042 16.095299461620748 16.229316397477042 15.90470053837925 16.14 15.75 C 15.66949403442161 14.93784941365856 14.975196029273393 14.27826630876775 14.139999999999999 13.849999999999998 C 14.060208994132282 13.808863169719045 14.00728361031022 13.729475093985952 14 13.639999999999999 C 13.997704141972045 13.55046566371857 14.043479743175002 13.466543728179817 14.12 13.419999999999998 C 15.59949636846926 12.490722498601748 16.285413156330605 10.694501030639916 15.801888367409644 9.015611529386884 C 15.318363578488684 7.336722028133854 13.78213084195738 6.180485728303008 12.035 6.180485728303008 C 10.287869158042618 6.180485728303008 8.751636421511314 7.336722028133853 8.268111632590355 9.015611529386884 C 7.784586843669394 10.694501030639916 8.470503631530736 12.490722498601748 9.95 13.419999999999998 C 10.029946273846974 13.463190438514589 10.076970034350744 13.549400666104834 10.069999999999999 13.639999999999999 C 10.069085662018994 13.743160242640858 9.9995932284464 13.833091627264217 9.9 13.86 Z M 10.16 9.55 C 10.174227700839518 9.475238945231627 10.227789180341016 9.414025825801343 10.3 9.39 C 10.369015146890712 9.354409720102687 10.45098485310929 9.354409720102687 10.520000000000001 9.39 C 11.292926433295335 9.845237921559576 12.172978968872954 10.086820970541668 13.070000000000002 10.09 C 13.25652689051527 10.100215977341612 13.443473109484733 10.100215977341612 13.630000000000003 10.09 C 13.707363784165976 10.075898889536692 13.786569638945206 10.102300841129768 13.840000000000002 10.16 C 13.89345459176297 10.216075261174842 13.91911851670547 10.293067036002347 13.910000000000002 10.370000000000001 C 13.810356748665964 11.402391422301408 12.908807025135305 12.169025244549903 11.873820666563562 12.101467388246265 C 10.838834307991819 12.033909531942626 10.044592612554023 11.156584363808461 10.080000000000002 10.120000000000001 C 10.07347595117315 9.926801865325015 10.10054458365919 9.733937858861982 10.16 9.55 Z" stroke-linecap="round" />
                                        </g>
                                        </g>
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $allvendors }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-blue border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Products <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Product_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(1 0 0 1 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -12)" d="M 3 3 C 2.448 3 2 3.448 2 4 L 2 7 L 22 7 L 22 4 C 22 3.448 21.552 3 21 3 L 3 3 z M 3 9 L 3 19 C 3 20.105 3.895 21 5 21 L 19 21 C 20.105 21 21 20.105 21 19 L 21 9 L 3 9 z M 9 11 L 15 11 L 15 13 L 9 13 L 9 11 z" stroke-linecap="round" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $allproducts }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Orders <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Product_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(1 0 0 1 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -12)" d="M 3 3 C 2.448 3 2 3.448 2 4 L 2 7 L 22 7 L 22 4 C 22 3.448 21.552 3 21 3 L 3 3 z M 3 9 L 3 19 C 3 20.105 3.895 21 5 21 L 19 21 C 20.105 21 21 20.105 21 19 L 21 9 L 3 9 z M 9 11 L 15 11 L 15 13 L 9 13 L 9 11 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $allorders }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-yellow info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Paid Orders <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Paid_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.71 0 0 0.71 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-16, -15.55)" d="M 16 3.09375 L 15.28125 3.78125 L 7.0625 12 L 2 12 L 2 18 L 3.25 18 L 6.03125 27.28125 L 6.25 28 L 25.75 28 L 25.96875 27.28125 L 28.75 18 L 30 18 L 30 12 L 24.9375 12 L 16.71875 3.78125 Z M 16 5.9375 L 22.0625 12 L 9.9375 12 Z M 4 14 L 28 14 L 28 16 L 27.25 16 L 27.03125 16.71875 L 24.25 26 L 7.75 26 L 4.96875 16.71875 L 4.75 16 L 4 16 Z M 20.28125 16.28125 L 15 21.5625 L 11.71875 18.28125 L 10.28125 19.71875 L 14.28125 23.71875 L 15 24.40625 L 15.71875 23.71875 L 21.71875 17.71875 Z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white ">{{ $paidorders }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-pink info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Pending Orders <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <svg id='Data_Pending_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.33 0 0 0.33 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-40, -40)" d="M 18.519531 10 L 10 20.648438 L 10 70 L 70 70 L 70 69 L 70 20.648438 L 61.480469 10 L 18.519531 10 z M 19.480469 12 L 60.519531 12 L 66.917969 20 L 45 20 L 45 21 C 45 23.773666 42.773666 26 40 26 C 37.226334 26 35 23.773666 35 21 L 35 20 L 13.082031 20 L 19.480469 12 z M 12 22 L 33.203125 22 C 33.709475 25.363146 36.49988 28 40 28 C 43.50012 28 46.290525 25.363146 46.796875 22 L 68 22 L 68 68 L 12 68 L 12 22 z M 40 32 C 32.832143 32 27 37.832143 27 45 C 27 52.167857 32.832143 58 40 58 C 47.167857 58 53 52.167857 53 45 C 53 37.832143 47.167857 32 40 32 z M 40 34 C 46.086977 34 51 38.913023 51 45 C 51 51.086977 46.086977 56 40 56 C 33.913023 56 29 51.086977 29 45 C 29 38.913023 33.913023 34 40 34 z M 39.984375 35.986328 C 39.43285880343316 35.99494907306296 38.99244727987339 36.448468138368234 39 37 L 39 44.5 L 35.400391 47.199219 C 34.95813186574575 47.530373906561294 34.868064093438704 48.15734986574575 35.199219 48.599609 C 35.530373906561294 49.04186813425425 36.15734986574575 49.131935906561296 36.599609 48.800781 L 41 45.5 L 41 37 C 41.003701461010195 36.729699667173676 40.89782332475401 36.46941334607979 40.70649033286975 36.27844827870817 C 40.51515734098548 36.08748321133654 40.25466770753046 35.982106271031085 39.984375 35.986328 z M 18 63 C 17.447715250169207 63 17 63.4477152501692 17 64 C 17 64.55228474983079 17.447715250169207 65 18 65 C 18.552284749830793 65 19 64.55228474983079 19 64 C 19 63.4477152501692 18.552284749830793 63 18 63 z M 22 63 C 21.447715250169207 63 21 63.4477152501692 21 64 C 21 64.55228474983079 21.447715250169207 65 22 65 C 22.552284749830793 65 23 64.55228474983079 23 64 C 23 63.4477152501692 22.552284749830793 63 22 63 z M 26 63 C 25.447715250169207 63 25 63.4477152501692 25 64 C 25 64.55228474983079 25.447715250169207 65 26 65 C 26.552284749830793 65 27 64.55228474983079 27 64 C 27 63.4477152501692 26.552284749830793 63 26 63 z M 30 63 C 29.447715250169207 63 29 63.4477152501692 29 64 C 29 64.55228474983079 29.447715250169207 65 30 65 C 30.552284749830793 65 31 64.55228474983079 31 64 C 31 63.4477152501692 30.552284749830793 63 30 63 z M 34 63 C 33.4477152501692 63 33 63.4477152501692 33 64 C 33 64.55228474983079 33.4477152501692 65 34 65 C 34.5522847498308 65 35 64.55228474983079 35 64 C 35 63.4477152501692 34.5522847498308 63 34 63 z M 38 63 C 37.4477152501692 63 37 63.4477152501692 37 64 C 37 64.55228474983079 37.4477152501692 65 38 65 C 38.5522847498308 65 39 64.55228474983079 39 64 C 39 63.4477152501692 38.5522847498308 63 38 63 z M 42 63 C 41.4477152501692 63 41 63.4477152501692 41 64 C 41 64.55228474983079 41.4477152501692 65 42 65 C 42.5522847498308 65 43 64.55228474983079 43 64 C 43 63.4477152501692 42.5522847498308 63 42 63 z M 46 63 C 45.4477152501692 63 45 63.4477152501692 45 64 C 45 64.55228474983079 45.4477152501692 65 46 65 C 46.5522847498308 65 47 64.55228474983079 47 64 C 47 63.4477152501692 46.5522847498308 63 46 63 z M 50 63 C 49.4477152501692 63 49 63.4477152501692 49 64 C 49 64.55228474983079 49.4477152501692 65 50 65 C 50.5522847498308 65 51 64.55228474983079 51 64 C 51 63.4477152501692 50.5522847498308 63 50 63 z M 54 63 C 53.4477152501692 63 53 63.4477152501692 53 64 C 53 64.55228474983079 53.4477152501692 65 54 65 C 54.5522847498308 65 55 64.55228474983079 55 64 C 55 63.4477152501692 54.5522847498308 63 54 63 z M 58 63 C 57.4477152501692 63 57 63.4477152501692 57 64 C 57 64.55228474983079 57.4477152501692 65 58 65 C 58.5522847498308 65 59 64.55228474983079 59 64 C 59 63.4477152501692 58.5522847498308 63 58 63 z M 62 63 C 61.4477152501692 63 61 63.4477152501692 61 64 C 61 64.55228474983079 61.4477152501692 65 62 65 C 62.5522847498308 65 63 64.55228474983079 63 64 C 63 63.4477152501692 62.5522847498308 63 62 63 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $pendingorders }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-blue info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Deliverd Orders <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Delivered_Box_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.29 0 0 0.29 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(251, 251, 251); fill-rule: nonzero; opacity: 1;" transform=" translate(-44, -43.5)" d="M 10 10 L 10 70 L 46.429688 70 C 46.039687 69.36 45.709922 68.69 45.419922 68 L 12 68 L 12 12 L 68 12 L 68 44.029297 C 68.69 44.269297 69.36 44.560625 70 44.890625 L 70 10 L 10 10 z M 32 18 C 30.35503 18 29 19.35503 29 21 C 29 22.64497 30.35503 24 32 24 L 48 24 C 49.64497 24 51 22.64497 51 21 C 51 19.35503 49.64497 18 48 18 L 32 18 z M 32 20 L 48 20 C 48.56503 20 49 20.43497 49 21 C 49 21.56503 48.56503 22 48 22 L 32 22 C 31.43497 22 31 21.56503 31 21 C 31 20.43497 31.43497 20 32 20 z M 62 45 C 53.18 45 46 52.18 46 61 C 46 63.51 46.579141 65.88 47.619141 68 C 47.789141 68.35 47.972266 68.690938 48.166016 69.023438 C 48.359766 69.355937 48.564297 69.68 48.779297 70 C 51.659297 74.22 56.51 77 62 77 C 70.82 77 78 69.82 78 61 C 78 55.09 74.78 49.920156 70 47.160156 C 69.36 46.780156 68.7 46.449922 68 46.169922 C 66.15 45.419922 64.12 45 62 45 z M 62 47 C 69.72 47 76 53.28 76 61 C 76 68.72 69.72 75 62 75 C 54.28 75 48 68.72 48 61 C 48 53.28 54.28 47 62 47 z M 69.091797 54.791016 L 59.595703 64.080078 L 55.949219 60.361328 L 54.521484 61.761719 L 59.566406 66.90625 L 70.488281 56.220703 L 69.091797 54.791016 z M 18 63 C 17.447715250169207 63 17 63.4477152501692 17 64 C 17 64.55228474983079 17.447715250169207 65 18 65 C 18.552284749830793 65 19 64.55228474983079 19 64 C 19 63.4477152501692 18.552284749830793 63 18 63 z M 22 63 C 21.447715250169207 63 21 63.4477152501692 21 64 C 21 64.55228474983079 21.447715250169207 65 22 65 C 22.552284749830793 65 23 64.55228474983079 23 64 C 23 63.4477152501692 22.552284749830793 63 22 63 z M 26 63 C 25.447715250169207 63 25 63.4477152501692 25 64 C 25 64.55228474983079 25.447715250169207 65 26 65 C 26.552284749830793 65 27 64.55228474983079 27 64 C 27 63.4477152501692 26.552284749830793 63 26 63 z M 30 63 C 29.447715250169207 63 29 63.4477152501692 29 64 C 29 64.55228474983079 29.447715250169207 65 30 65 C 30.552284749830793 65 31 64.55228474983079 31 64 C 31 63.4477152501692 30.552284749830793 63 30 63 z M 34 63 C 33.4477152501692 63 33 63.4477152501692 33 64 C 33 64.55228474983079 33.4477152501692 65 34 65 C 34.5522847498308 65 35 64.55228474983079 35 64 C 35 63.4477152501692 34.5522847498308 63 34 63 z M 38 63 C 37.4477152501692 63 37 63.4477152501692 37 64 C 37 64.55228474983079 37.4477152501692 65 38 65 C 38.5522847498308 65 39 64.55228474983079 39 64 C 39 63.4477152501692 38.5522847498308 63 38 63 z M 42 63 C 41.4477152501692 63 41 63.4477152501692 41 64 C 41 64.55228474983079 41.4477152501692 65 42 65 C 42.5522847498308 65 43 64.55228474983079 43 64 C 43 63.4477152501692 42.5522847498308 63 42 63 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $deliverdorders }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light border-0 shadow-sm d-flex align-items-stretch">
                    <div class="card-body">
                        {!!$c->container() !!}
                        <script src="{{ $c->cdn() }}"></script>
                        {{ $c->script() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-2">
            <div class="col-md-6">
                <div class="card bg-light border-0 shadow-sm d-flex align-items-stretch">
                    <div class="card-body">
                        {!! $chart->container() !!}
                        <script src="{{ $chart->cdn() }}"></script>
                        {{ $chart->script() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light border-0 shadow-sm d-flex align-items-stretch">
                    <div class="card-body">
                        {!! $payment->container() !!}
                        <script src="{{ $payment->cdn() }}"></script>
                        {{ $payment->script() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-body">
                     <h5 class="card-title text-dark">Recent Orders</h5>
                     <table class="table datatable table-responsive" class="table datatable">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <td>country</td>
                              <td>mobile</td>
                              <td>email</td>
                              <th>order status</th>
                              <th>Payment Method</th>
                           </tr>
                        </thead>
                        <tbody>
                          @foreach ($latestOrders as $k => $order)
                           <tr>
                              <td> <a href="{{ url('admin/orders/'.$order->id) }}">{{ $order->id }}</a></td>
                              <td>{{ $order->country }}</td>
                              <td>{{ $order->mobile }}</td>
                              <td>{{ $order->email }}</td>
                              <td>
                                <a class="badge bg-primary text-white">
                                    {{ $order->order_status }}
                                </a>
                              </td>
                              <td>{{ $order->payment_method }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     <div class=" pagination-sm">
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                       <h5 class="card-title text-dark">Recent Custom Orders</h5>
                       <table class="table datatable table-responsive" class="table datatable">
                          <thead>
                             <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Delivery Address</th>
                             </tr>
                          </thead>
                          <tbody>
                            @foreach ($latestcustomorder as $k => $product)
                             <tr>
                                <td><a href="{{ url('admin/custom-orders/detail/'.$product->id) }}">{{ $product->id }}</a></td>
                                <td>
                                    {{ $product->product_name}}
                                </td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->delivery_address }}</td>
                             </tr>
                             @endforeach

                          </tbody>
                       </table>
                       <div class=" pagination-sm">
                          {{-- {{ $latestOrders->links() }} --}}
                       </div>
                    </div>
                 </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                       <h5 class="card-title text-dark">Leatest Products</h5>
                       <table class="table datatable table-responsive" class="table datatable">
                          <thead>
                             <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Product Price</th>
                             </tr>
                          </thead>
                          <tbody>
                            @foreach ($latestproducts as $k => $product)
                             <tr>
                                <td> <a href="{{ url('admin/edit/product/'.$product->id) }}">{{ $product->id }}</a></td>
                                <td>
                                    {{ $product->product_name}}
                                </td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->product_price }}</td>
                             </tr>
                             @endforeach

                          </tbody>
                       </table>
                       <div class=" pagination-sm">
                          {{-- {{ $latestOrders->links() }} --}}
                       </div>

                    </div>
                 </div>
            </div>
         </div>
</section>
@endif


@if(Auth::guard('admin')->user()->type=="vendor")
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Payment <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <svg id='Online_Payment_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.83 0 0 0.83 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-15, -15)" d="M 5 4 C 3.895 4 3 4.895 3 6 L 3 10 L 3 23 C 3 24.64497 4.3550302 26 6 26 L 24 26 C 25.64497 26 27 24.64497 27 23 L 27 9 L 27 6 C 27 4.895 26.105 4 25 4 L 5 4 z M 6 6 C 6.552 6 7 6.448 7 7 C 7 7.552 6.552 8 6 8 C 5.448 8 5 7.552 5 7 C 5 6.448 5.448 6 6 6 z M 10 6 C 10.552 6 11 6.448 11 7 C 11 7.552 10.552 8 10 8 C 9.448 8 9 7.552 9 7 C 9 6.448 9.448 6 10 6 z M 5 10 L 25 10 L 25 23 C 25 23.56503 24.56503 24 24 24 L 6 24 C 5.4349698 24 5 23.56503 5 23 L 5 10 z M 14 11 L 14 12.119141 C 12.615 12.427141 11.746094 13.362781 11.746094 14.675781 C 11.746094 15.980781 12.512266 16.793141 14.072266 17.119141 L 15.1875 17.357422 C 16.2375 17.583422 16.664062 17.897359 16.664062 18.443359 C 16.664063 19.090359 16.005219 19.541016 15.074219 19.541016 C 14.065219 19.541016 13.36425 19.096344 13.28125 18.402344 L 11.550781 18.402344 C 11.604781 19.723344 12.529 20.626344 14 20.902344 L 14 22 L 16 22 L 16 20.898438 C 17.532 20.607437 18.449219 19.64875 18.449219 18.21875 C 18.449219 16.89075 17.709281 16.147156 15.988281 15.785156 L 14.955078 15.566406 C 13.952078 15.353406 13.544922 15.049484 13.544922 14.521484 C 13.544922 13.868484 14.137203 13.453125 15.033203 13.453125 C 15.899203 13.453125 16.528328 13.904078 16.611328 14.580078 L 18.296875 14.580078 C 18.252875 13.337078 17.35 12.417234 16 12.115234 L 16 11 L 14 11 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 style="font-size: 20px;" class="text-white" >$ {{ $totalPayment }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card  bg-c-yellow border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Profit  <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <svg id='Profit_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.77 0 0 0.77 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-15, -13.86)" d="M 23.933594 1.71875 L 24.873047 3.0722656 L 21.8125 4.9433594 L 17.195312 4.0195312 C 17.005385782535555 3.981911559324486 16.80862300798736 4.000230868897715 16.628906 4.0722656 L 12 5.9238281 L 7.3710938 4.0722656 C 7.106074685745512 3.966005184279669 6.808274009142335 3.978087816220343 6.5527344 4.1054688 L 2.5527344 6.1054688 C 2.0589836529519987 6.352639450568018 1.8589621023043053 6.953182805899092 2.1058965594838073 7.447051720258097 C 2.3528310166633095 7.9409206346171 2.9532786313167847 8.14122940729759 3.4472656000000006 7.8945312 L 7.0449219 6.0957031 L 11.628906 7.9277344 C 11.867144334099782 8.022930406492927 12.132855665900218 8.022930406492927 12.371094 7.9277344 L 17.095703 6.0390625 L 21.804688 6.9804688 C 22.051084369546032 7.029697884586834 22.306983481541096 6.984375071478318 22.521484 6.8535156 L 26.015625 4.7167969 L 27.160156 6.3652344 L 27.869141 2.4296875 L 23.933594 1.71875 z M 4 10 C 3.8701312318078562 10.000434040666198 3.740613487114512 10.01351647199152 3.6132811999999994 10.039062 C 3.602689 10.04119 3.5925658 10.044577 3.5820312 10.046875 C 2.660365324042417 10.243837026709745 2.0012786306824575 11.05752432817932 2 12 L 2 24 C 2.0004341923149247 24.129868851357525 2.0135167911771004 24.259386663821697 2.0390625 24.386719 C 2.0411905 24.397311 2.0445769 24.407434 2.046875 24.417969 C 2.2438371083038975 25.33963479647203 3.0575243888305392 25.99872138954664 4 26 L 26 26 C 26.12986883503852 25.999565972317505 26.259386647343835 25.986483540928642 26.386719 25.960938 C 26.397311 25.95881 26.407434 25.955423 26.417969 25.953125 C 27.33963479647203 25.756162891696103 27.99872138954664 24.94247561116946 28 24 L 28 12 C 27.999565972317505 11.870131164961483 27.986483540928642 11.740613352656165 27.960938 11.613281 C 27.95881 11.602689 27.955423 11.592566 27.953125 11.582031 C 27.756162891696103 10.660365203527968 26.94247561116946 10.00127861045336 26 10 L 4 10 z M 6 12 L 24 12 C 24 13.104569499661586 24.895430500338414 14 26 14 L 26 22 C 24.895430500338414 22 24 22.895430500338414 24 24 L 6 24 C 6 22.895430500338414 5.1045694996615865 22 4 22 L 4 14 C 5.1045694996615865 14 6 13.104569499661586 6 12 z M 15 14 C 12.791 14 11 16.015 11 18.5 C 11 19.922 11.597672 21.175 12.513672 22 L 17.486328 22 C 18.402328 21.175 19 19.922 19 18.5 C 19 16.015 17.209 14 15 14 z M 7 17 C 6.447715250169207 17 6 17.447715250169207 6 18 C 6 18.552284749830793 6.447715250169207 19 7 19 C 7.552284749830793 19 8 18.552284749830793 8 18 C 8 17.447715250169207 7.552284749830793 17 7 17 z M 23 17 C 22.447715250169207 17 22 17.447715250169207 22 18 C 22 18.552284749830793 22.447715250169207 19 23 19 C 23.552284749830793 19 24 18.552284749830793 24 18 C 24 17.447715250169207 23.552284749830793 17 23 17 z" stroke-linecap="round" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 style="font-size: 20px;" class="text-white">$ {{ $totalProfit }} </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Tax <span class="text-white"> | All Year</span></h5>
                            <div class="d-flex align-items-center">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <svg id='Tax_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.71 0 0 0.71 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-16, -16)" d="M 12 3 C 10.300781 3 9 4.300781 9 6 C 9 7.699219 10.300781 9 12 9 L 12.699219 9 L 14.597656 11 L 10 16 L 10 19 L 19.300781 8.898438 C 19.5 9 19.699219 9 20 9 C 21.699219 9 23 7.699219 23 6 C 23 4.300781 21.699219 3 20 3 C 18.300781 3 17 4.300781 17 6 C 17 6.601563 17.199219 7.199219 17.5 7.699219 L 16 9.398438 L 14.402344 7.699219 C 14.800781 7.300781 15 6.699219 15 6 C 15 4.300781 13.699219 3 12 3 Z M 12 5 C 12.601563 5 13 5.398438 13 6 C 13 6.601563 12.601563 7 12 7 C 11.398438 7 11 6.601563 11 6 C 11 5.398438 11.398438 5 12 5 Z M 20 5 C 20.601563 5 21 5.398438 21 6 C 21 6.601563 20.601563 7 20 7 C 19.398438 7 19 6.601563 19 6 C 19 5.398438 19.398438 5 20 5 Z M 2 13 L 2 29 L 30 29 L 30 13 L 18.242188 13 L 15.480469 16 L 17 16 L 17 15 L 26.089844 15 C 26.03125 15.160156 26 15.328125 26 15.5 C 26 16.328125 26.671875 17 27.5 17 C 27.671875 17 27.839844 16.96875 28 16.910156 L 28 25.089844 C 27.839844 25.03125 27.671875 25 27.5 25 C 26.671875 25 26 25.671875 26 26.5 C 26 26.671875 26.03125 26.839844 26.089844 27 L 17 27 L 17 26 L 15 26 L 15 27 L 5.914063 27 C 5.96875 26.839844 6 26.671875 6 26.5 C 6 25.671875 5.328125 25 4.5 25 C 4.328125 25 4.160156 25.03125 4 25.089844 L 4 16.910156 C 4.160156 16.96875 4.328125 17 4.5 17 C 5.328125 17 6 16.328125 6 15.5 C 6 15.328125 5.96875 15.160156 5.914063 15 L 8.203125 15 L 8.527344 14.644531 L 10.042969 13 Z M 15 17.136719 C 14.683594 17.214844 14.390625 17.339844 14.109375 17.488281 L 12.328125 19.421875 C 12.125 19.90625 12 20.433594 12 21 C 12 22.894531 13.257813 24.429688 15 24.863281 L 15 24 L 17 24 L 17 24.863281 C 18.742188 24.429688 20 22.894531 20 21 C 20 19.105469 18.742188 17.570313 17 17.136719 L 17 18 L 15 18 Z M 8 19.5 C 7.171875 19.5 6.5 20.171875 6.5 21 C 6.5 21.828125 7.171875 22.5 8 22.5 C 8.828125 22.5 9.5 21.828125 9.5 21 C 9.5 20.171875 8.828125 19.5 8 19.5 Z M 24 19.5 C 23.171875 19.5 22.5 20.171875 22.5 21 C 22.5 21.828125 23.171875 22.5 24 22.5 C 24.828125 22.5 25.5 21.828125 25.5 21 C 25.5 20.171875 24.828125 19.5 24 19.5 Z M 15 20 L 17 20 L 17 22 L 15 22 Z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 style="font-size: 20px;" class="text-white">$ {{ $totalTax }} </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Your Total Profit</h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Increase_Profits_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.16 0 0 0.16 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-64, -65)" d="M 111 3 C 104.9 3 100 7.9 100 14 C 100 16.5 100.79922 18.699609 102.19922 20.599609 L 83 45.800781 C 81.8 45.300781 80.4 45 79 45 C 76.3 45 73.9 46 72 47.5 L 57.400391 37.5 C 57.800391 36.4 58 35.2 58 34 C 58 27.9 53.1 23 47 23 C 40.9 23 36 27.9 36 34 C 36 35.9 36.500391 37.800391 37.400391 39.400391 L 18.400391 58.400391 C 16.800391 57.500391 14.9 57 13 57 C 6.9 57 2 61.9 2 68 C 2 74.1 6.9 79 13 79 C 19.1 79 24 74.1 24 68 C 24 66.1 23.499609 64.199609 22.599609 62.599609 L 41.599609 43.599609 C 43.199609 44.499609 45 45 47 45 C 49.7 45 52.1 44 54 42.5 L 68.599609 52.5 C 68.199609 53.6 68 54.8 68 56 C 68 62.1 72.9 67 79 67 C 85.1 67 90 62.1 90 56 C 90 53.5 89.200781 51.300391 87.800781 49.400391 L 107 24.199219 C 108.2 24.699219 109.6 25 111 25 C 117.1 25 122 20.1 122 14 C 122 7.9 117.1 3 111 3 z M 111 9 C 113.8 9 116 11.2 116 14 C 116 16.8 113.8 19 111 19 C 108.2 19 106 16.8 106 14 C 106 11.2 108.2 9 111 9 z M 47 29 C 49.8 29 52 31.2 52 34 C 52 36.8 49.8 39 47 39 C 44.2 39 42 36.8 42 34 C 42 31.2 44.2 29 47 29 z M 111 29.300781 C 109.3 29.300781 108 30.600781 108 32.300781 C 108 34.000781 109.3 35.300781 111 35.300781 C 112.7 35.300781 114 34.000781 114 32.300781 C 114 30.700781 112.7 29.300781 111 29.300781 z M 111 47.699219 C 109.3 47.699219 108 48.999219 108 50.699219 C 108 52.299219 109.3 53.699219 111 53.699219 C 112.7 53.699219 114 52.299219 114 50.699219 C 114 48.999219 112.7 47.699219 111 47.699219 z M 47 49 C 45.34314575050762 49 44 50.34314575050762 44 52 C 44 53.65685424949238 45.34314575050762 55 47 55 C 48.65685424949238 55 50 53.65685424949238 50 52 C 50 50.34314575050762 48.65685424949238 49 47 49 z M 79 51 C 81.8 51 84 53.2 84 56 C 84 58.8 81.8 61 79 61 C 76.2 61 74 58.8 74 56 C 74 53.2 76.2 51 79 51 z M 13 63 C 15.8 63 18 65.2 18 68 C 18 70.8 15.8 73 13 73 C 10.2 73 8 70.8 8 68 C 8 65.2 10.2 63 13 63 z M 111 66 C 109.34314575050762 66 108 67.34314575050762 108 69 C 108 70.65685424949238 109.34314575050762 72 111 72 C 112.65685424949238 72 114 70.65685424949238 114 69 C 114 67.34314575050762 112.65685424949238 66 111 66 z M 47 67 C 45.34314575050762 67 44 68.34314575050762 44 70 C 44 71.65685424949238 45.34314575050762 73 47 73 C 48.65685424949238 73 50 71.65685424949238 50 70 C 50 68.34314575050762 48.65685424949238 67 47 67 z M 79 70 C 77.34314575050762 70 76 71.34314575050762 76 73 C 76 74.65685424949238 77.34314575050762 76 79 76 C 80.65685424949238 76 82 74.65685424949238 82 73 C 82 71.34314575050762 80.65685424949238 70 79 70 z M 111 84.300781 C 109.3 84.300781 108 85.600781 108 87.300781 C 108 89.000781 109.3 90.300781 111 90.300781 C 112.7 90.300781 114 89.000781 114 87.300781 C 114 85.700781 112.7 84.300781 111 84.300781 z M 13 85 C 11.34314575050762 85 10 86.34314575050762 10 88 C 10 89.65685424949238 11.34314575050762 91 13 91 C 14.65685424949238 91 16 89.65685424949238 16 88 C 16 86.34314575050762 14.65685424949238 85 13 85 z M 47 85 C 45.34314575050762 85 44 86.34314575050762 44 88 C 44 89.65685424949238 45.34314575050762 91 47 91 C 48.65685424949238 91 50 89.65685424949238 50 88 C 50 86.34314575050762 48.65685424949238 85 47 85 z M 79 87 C 77.34314575050762 87 76 88.34314575050762 76 90 C 76 91.65685424949238 77.34314575050762 93 79 93 C 80.65685424949238 93 82 91.65685424949238 82 90 C 82 88.34314575050762 80.65685424949238 87 79 87 z M 111 102.69922 C 109.3 102.69922 108 103.99922 108 105.69922 C 108 107.29922 109.3 108.69922 111 108.69922 C 112.7 108.69922 114 107.29922 114 105.69922 C 114 103.99922 112.7 102.69922 111 102.69922 z M 13 103 C 11.34314575050762 103 10 104.34314575050762 10 106 C 10 107.65685424949238 11.34314575050762 109 13 109 C 14.65685424949238 109 16 107.65685424949238 16 106 C 16 104.34314575050762 14.65685424949238 103 13 103 z M 47 103 C 45.34314575050762 103 44 104.34314575050762 44 106 C 44 107.65685424949238 45.34314575050762 109 47 109 C 48.65685424949238 109 50 107.65685424949238 50 106 C 50 104.34314575050762 48.65685424949238 103 47 103 z M 79 104 C 77.34314575050762 104 76 105.34314575050762 76 107 C 76 108.65685424949238 77.34314575050762 110 79 110 C 80.65685424949238 110 82 108.65685424949238 82 107 C 82 105.34314575050762 80.65685424949238 104 79 104 z M 4 121 C 2.3 121 1 122.3 1 124 C 1 125.7 2.3 127 4 127 L 124 127 C 125.7 127 127 125.7 127 124 C 127 122.3 125.7 121 124 121 L 4 121 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">$ {{ $commission }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card bg-c-green border-0 revenue-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Shipping Charge</h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Shipping_Service_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.16 0 0 0.16 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-64.9, -64)" d="M 94.699219 1 C 88.699219 1 83.499609 5.1003906 82.099609 10.900391 C 80.999609 15.200391 79.999219 19.699609 79.199219 24.099609 C 78.799219 25.999609 79.400781 28.000391 80.800781 29.400391 C 81.900781 30.500391 83.499609 31.199219 85.099609 31.199219 C 85.499609 31.199219 85.799219 31.199609 86.199219 31.099609 C 86.899219 30.999609 87.599609 30.799219 88.099609 30.699219 C 102.29961 27.699219 113.40039 26.599219 124.90039 27.199219 C 126.50039 27.299219 127.99961 26.000391 128.09961 24.400391 C 128.19961 22.700391 126.90078 21.299219 125.30078 21.199219 C 113.20078 20.599219 101.70039 21.700781 86.900391 24.800781 C 86.500391 24.900781 85.799219 24.999609 85.199219 25.099609 C 85.999219 20.799609 87 16.499219 88 12.199219 C 88.7 9.1992187 91.499219 7 94.699219 7 L 125 7 C 126.7 7 128 5.7 128 4 C 128 2.3 126.7 1 125 1 L 94.699219 1 z M 79.277344 37.988281 C 77.867773 38.105859 76.774609 39.199609 76.599609 40.599609 C 74.299609 59.799609 74 79.600391 74 99.900391 L 74 100 L 74 124 C 74 125.7 75.3 127 77 127 L 91 127 C 92.7 127 94 125.7 94 124 L 94 113 L 125 113 C 126.7 113 128 111.7 128 110 C 128 108.3 126.7 107 125 107 L 87 107 C 85.1 107 83.4 106.30039 82 104.90039 C 80.7 103.60039 79.9 101.80039 80 99.900391 C 80 79.800391 80.3 60.200781 82.5 41.300781 C 82.7 39.700781 81.500391 38.2 79.900391 38 C 79.687891 37.975 79.478711 37.971484 79.277344 37.988281 z M 31 52 C 23.5 52 17.199219 57.800781 16.699219 65.300781 L 16.300781 71 L 22.300781 71 L 22.699219 65.699219 C 22.999219 61.399219 26.7 58 31 58 C 35.3 58 39.000781 61.399219 39.300781 65.699219 L 39.599609 71 L 22.300781 71 L 22 76.199219 C 21.9 77.799219 20.6 79 19 79 C 17.3 79 15.9 77.500781 16 75.800781 L 16.300781 71 L 10.800781 71 C 7.7007813 71 5.0007813 73.499609 4.8007812 76.599609 L 1.6992188 120.59961 C 1.5992187 122.29961 2.2007812 123.89961 3.3007812 125.09961 C 4.5007812 126.29961 6.0992187 127 7.6992188 127 L 54.300781 127 C 56.000781 127 57.599219 126.29961 58.699219 125.09961 C 59.799219 123.89961 60.400781 122.19961 60.300781 120.59961 L 57.199219 76.599609 C 56.999219 73.499609 54.299219 71 51.199219 71 L 45.699219 71 L 46 75.800781 C 46.1 77.500781 44.7 79 43 79 C 41.4 79 40.1 77.799219 40 76.199219 L 39.699219 71 L 45.599609 71 L 45.199219 65.300781 C 44.799219 57.800781 38.5 52 31 52 z M 67 52 C 65.3 52 64 53.3 64 55 L 64 69 C 64 70.7 65.3 72 67 72 C 68.7 72 70 70.7 70 69 L 70 55 C 70 53.3 68.7 52 67 52 z M 90 66 C 88.3 66 87 67.3 87 69 C 87 70.7 88.3 72 90 72 L 125 72 C 126.7 72 128 70.7 128 69 C 128 67.3 126.7 66 125 66 L 90 66 z M 89.240234 86.011719 C 88.068359 85.950781 86.925391 86.549609 86.400391 87.599609 C 85.700391 89.099609 86.299219 90.899609 87.699219 91.599609 L 97.699219 96.699219 C 98.099219 96.899219 98.6 97 99 97 C 100.1 97 101.19922 96.400781 101.69922 95.300781 C 102.39922 93.800781 101.80039 92.000781 100.40039 91.300781 L 90.400391 86.300781 C 90.025391 86.125781 89.630859 86.032031 89.240234 86.011719 z M 112.5 91 C 110.8 91 109.5 92.3 109.5 94 C 109.5 95.7 110.8 97 112.5 97 L 125 97 C 126.7 97 128 95.7 128 94 C 128 92.3 126.7 91 125 91 L 112.5 91 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $total_shipping_charge }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-yellow info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Paid Orders <span class="text-white"> | all</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Paid_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.71 0 0 0.71 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-16, -15.55)" d="M 16 3.09375 L 15.28125 3.78125 L 7.0625 12 L 2 12 L 2 18 L 3.25 18 L 6.03125 27.28125 L 6.25 28 L 25.75 28 L 25.96875 27.28125 L 28.75 18 L 30 18 L 30 12 L 24.9375 12 L 16.71875 3.78125 Z M 16 5.9375 L 22.0625 12 L 9.9375 12 Z M 4 14 L 28 14 L 28 16 L 27.25 16 L 27.03125 16.71875 L 24.25 26 L 7.75 26 L 4.96875 16.71875 L 4.75 16 L 4 16 Z M 20.28125 16.28125 L 15 21.5625 L 11.71875 18.28125 L 10.28125 19.71875 L 14.28125 23.71875 L 15 24.40625 L 15.71875 23.71875 L 21.71875 17.71875 Z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white ">{{ $paidorderproducts }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-pink info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Pending Orders <span class="text-white"> | all</span></h5>
                            <div class="d-flex align-items-center">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <svg id='Data_Pending_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.33 0 0 0.33 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-40, -40)" d="M 18.519531 10 L 10 20.648438 L 10 70 L 70 70 L 70 69 L 70 20.648438 L 61.480469 10 L 18.519531 10 z M 19.480469 12 L 60.519531 12 L 66.917969 20 L 45 20 L 45 21 C 45 23.773666 42.773666 26 40 26 C 37.226334 26 35 23.773666 35 21 L 35 20 L 13.082031 20 L 19.480469 12 z M 12 22 L 33.203125 22 C 33.709475 25.363146 36.49988 28 40 28 C 43.50012 28 46.290525 25.363146 46.796875 22 L 68 22 L 68 68 L 12 68 L 12 22 z M 40 32 C 32.832143 32 27 37.832143 27 45 C 27 52.167857 32.832143 58 40 58 C 47.167857 58 53 52.167857 53 45 C 53 37.832143 47.167857 32 40 32 z M 40 34 C 46.086977 34 51 38.913023 51 45 C 51 51.086977 46.086977 56 40 56 C 33.913023 56 29 51.086977 29 45 C 29 38.913023 33.913023 34 40 34 z M 39.984375 35.986328 C 39.43285880343316 35.99494907306296 38.99244727987339 36.448468138368234 39 37 L 39 44.5 L 35.400391 47.199219 C 34.95813186574575 47.530373906561294 34.868064093438704 48.15734986574575 35.199219 48.599609 C 35.530373906561294 49.04186813425425 36.15734986574575 49.131935906561296 36.599609 48.800781 L 41 45.5 L 41 37 C 41.003701461010195 36.729699667173676 40.89782332475401 36.46941334607979 40.70649033286975 36.27844827870817 C 40.51515734098548 36.08748321133654 40.25466770753046 35.982106271031085 39.984375 35.986328 z M 18 63 C 17.447715250169207 63 17 63.4477152501692 17 64 C 17 64.55228474983079 17.447715250169207 65 18 65 C 18.552284749830793 65 19 64.55228474983079 19 64 C 19 63.4477152501692 18.552284749830793 63 18 63 z M 22 63 C 21.447715250169207 63 21 63.4477152501692 21 64 C 21 64.55228474983079 21.447715250169207 65 22 65 C 22.552284749830793 65 23 64.55228474983079 23 64 C 23 63.4477152501692 22.552284749830793 63 22 63 z M 26 63 C 25.447715250169207 63 25 63.4477152501692 25 64 C 25 64.55228474983079 25.447715250169207 65 26 65 C 26.552284749830793 65 27 64.55228474983079 27 64 C 27 63.4477152501692 26.552284749830793 63 26 63 z M 30 63 C 29.447715250169207 63 29 63.4477152501692 29 64 C 29 64.55228474983079 29.447715250169207 65 30 65 C 30.552284749830793 65 31 64.55228474983079 31 64 C 31 63.4477152501692 30.552284749830793 63 30 63 z M 34 63 C 33.4477152501692 63 33 63.4477152501692 33 64 C 33 64.55228474983079 33.4477152501692 65 34 65 C 34.5522847498308 65 35 64.55228474983079 35 64 C 35 63.4477152501692 34.5522847498308 63 34 63 z M 38 63 C 37.4477152501692 63 37 63.4477152501692 37 64 C 37 64.55228474983079 37.4477152501692 65 38 65 C 38.5522847498308 65 39 64.55228474983079 39 64 C 39 63.4477152501692 38.5522847498308 63 38 63 z M 42 63 C 41.4477152501692 63 41 63.4477152501692 41 64 C 41 64.55228474983079 41.4477152501692 65 42 65 C 42.5522847498308 65 43 64.55228474983079 43 64 C 43 63.4477152501692 42.5522847498308 63 42 63 z M 46 63 C 45.4477152501692 63 45 63.4477152501692 45 64 C 45 64.55228474983079 45.4477152501692 65 46 65 C 46.5522847498308 65 47 64.55228474983079 47 64 C 47 63.4477152501692 46.5522847498308 63 46 63 z M 50 63 C 49.4477152501692 63 49 63.4477152501692 49 64 C 49 64.55228474983079 49.4477152501692 65 50 65 C 50.5522847498308 65 51 64.55228474983079 51 64 C 51 63.4477152501692 50.5522847498308 63 50 63 z M 54 63 C 53.4477152501692 63 53 63.4477152501692 53 64 C 53 64.55228474983079 53.4477152501692 65 54 65 C 54.5522847498308 65 55 64.55228474983079 55 64 C 55 63.4477152501692 54.5522847498308 63 54 63 z M 58 63 C 57.4477152501692 63 57 63.4477152501692 57 64 C 57 64.55228474983079 57.4477152501692 65 58 65 C 58.5522847498308 65 59 64.55228474983079 59 64 C 59 63.4477152501692 58.5522847498308 63 58 63 z M 62 63 C 61.4477152501692 63 61 63.4477152501692 61 64 C 61 64.55228474983079 61.4477152501692 65 62 65 C 62.5522847498308 65 63 64.55228474983079 63 64 C 63 63.4477152501692 62.5522847498308 63 62 63 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $pendingorderproducts }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-green info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Deliverd Orders <span class="text-white"> | all</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Delivered_Box_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(0.29 0 0 0.29 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(251, 251, 251); fill-rule: nonzero; opacity: 1;" transform=" translate(-44, -43.5)" d="M 10 10 L 10 70 L 46.429688 70 C 46.039687 69.36 45.709922 68.69 45.419922 68 L 12 68 L 12 12 L 68 12 L 68 44.029297 C 68.69 44.269297 69.36 44.560625 70 44.890625 L 70 10 L 10 10 z M 32 18 C 30.35503 18 29 19.35503 29 21 C 29 22.64497 30.35503 24 32 24 L 48 24 C 49.64497 24 51 22.64497 51 21 C 51 19.35503 49.64497 18 48 18 L 32 18 z M 32 20 L 48 20 C 48.56503 20 49 20.43497 49 21 C 49 21.56503 48.56503 22 48 22 L 32 22 C 31.43497 22 31 21.56503 31 21 C 31 20.43497 31.43497 20 32 20 z M 62 45 C 53.18 45 46 52.18 46 61 C 46 63.51 46.579141 65.88 47.619141 68 C 47.789141 68.35 47.972266 68.690938 48.166016 69.023438 C 48.359766 69.355937 48.564297 69.68 48.779297 70 C 51.659297 74.22 56.51 77 62 77 C 70.82 77 78 69.82 78 61 C 78 55.09 74.78 49.920156 70 47.160156 C 69.36 46.780156 68.7 46.449922 68 46.169922 C 66.15 45.419922 64.12 45 62 45 z M 62 47 C 69.72 47 76 53.28 76 61 C 76 68.72 69.72 75 62 75 C 54.28 75 48 68.72 48 61 C 48 53.28 54.28 47 62 47 z M 69.091797 54.791016 L 59.595703 64.080078 L 55.949219 60.361328 L 54.521484 61.761719 L 59.566406 66.90625 L 70.488281 56.220703 L 69.091797 54.791016 z M 18 63 C 17.447715250169207 63 17 63.4477152501692 17 64 C 17 64.55228474983079 17.447715250169207 65 18 65 C 18.552284749830793 65 19 64.55228474983079 19 64 C 19 63.4477152501692 18.552284749830793 63 18 63 z M 22 63 C 21.447715250169207 63 21 63.4477152501692 21 64 C 21 64.55228474983079 21.447715250169207 65 22 65 C 22.552284749830793 65 23 64.55228474983079 23 64 C 23 63.4477152501692 22.552284749830793 63 22 63 z M 26 63 C 25.447715250169207 63 25 63.4477152501692 25 64 C 25 64.55228474983079 25.447715250169207 65 26 65 C 26.552284749830793 65 27 64.55228474983079 27 64 C 27 63.4477152501692 26.552284749830793 63 26 63 z M 30 63 C 29.447715250169207 63 29 63.4477152501692 29 64 C 29 64.55228474983079 29.447715250169207 65 30 65 C 30.552284749830793 65 31 64.55228474983079 31 64 C 31 63.4477152501692 30.552284749830793 63 30 63 z M 34 63 C 33.4477152501692 63 33 63.4477152501692 33 64 C 33 64.55228474983079 33.4477152501692 65 34 65 C 34.5522847498308 65 35 64.55228474983079 35 64 C 35 63.4477152501692 34.5522847498308 63 34 63 z M 38 63 C 37.4477152501692 63 37 63.4477152501692 37 64 C 37 64.55228474983079 37.4477152501692 65 38 65 C 38.5522847498308 65 39 64.55228474983079 39 64 C 39 63.4477152501692 38.5522847498308 63 38 63 z M 42 63 C 41.4477152501692 63 41 63.4477152501692 41 64 C 41 64.55228474983079 41.4477152501692 65 42 65 C 42.5522847498308 65 43 64.55228474983079 43 64 C 43 63.4477152501692 42.5522847498308 63 42 63 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $deliverdorderproducts }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card bg-c-green info-card border-0  sales-card">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Products <span class="text-white"> | all</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <svg id='Product_Documents_24' width='44' height='44' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                        <g transform="matrix(1.67 0 0 1.67 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255, 255, 255); fill-rule: nonzero; opacity: 1;" transform=" translate(-8, -8)" d="M 4 2 L 4 4 L 3 4 L 3 9 C 2.4534686 9 2 9.4534686 2 10 L 2 12.5 C 2 13.322531 2.6774686 14 3.5 14 L 12.5 14 C 13.322531 14 14 13.322531 14 12.5 L 14 10 C 14 9.4534686 13.546531 9 13 9 L 13 4 L 12 4 L 12 2 L 4 2 z M 5 3 L 11 3 L 11 4 L 5 4 L 5 3 z M 4 5 L 12 5 L 12 9 L 9 9 L 9 10 C 9 10.557469 8.5574686 11 8 11 C 7.4425314 11 7 10.557469 7 10 L 7 9 L 4 9 L 4 5 z M 3 10 L 6 10 C 6 11.098531 6.9014686 12 8 12 C 9.0985314 12 10 11.098531 10 10 L 13 10 L 13 12.5 C 13 12.781469 12.781469 13 12.5 13 L 3.5 13 C 3.2185314 13 3 12.781469 3 12.5 L 3 10 z" stroke-linecap="round" />
                                        </g>
                                        </svg>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $allproducts }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                 <h5 class="card-title text-dark">Recent Ordered Products</h5>
                 <table class="table datatable table-responsive" class="table datatable">
                    <thead>
                       <tr>
                          <th>ID</th>
                          <th>Customer</th>
                          <th>Product Code</th>
                          <th>Product Name</th>
                          <th>Product Color</th>
                          <th>Product Qty</th>
                          <th>Date</th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($latestOrdersproducts as $k => $order)
                       <tr>
                        <td> <a href="{{ url('admin/orders/'.$order->id) }}">{{ $order->id }}</a></td>
                        <td>
                              {{ $order->user->name}}
                          </td>
                          <td>
                           {{ $order->product_code }}
                          </td>

                          <td>{{ $order->product_name }}</td>
                          <td>{{ $order->product_color }}</td>
                         <td>{{ $order->product_qty }}</td>
                        <td>
                            {{ $order->created_at }}
                        </td>
                       </tr>
                       @endforeach

                    </tbody>
                 </table>
                 <div class=" pagination-sm">
                 </div>
              </div>
           </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                   <h5 class="card-title text-dark">Leatest Products</h5>
                   <table class="table datatable table-responsive" class="table datatable">
                      <thead>
                         <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Product Price</th>
                            <th>Produt Status</th>
                         </tr>
                      </thead>
                      <tbody>
                        @foreach ($latestproducts as $k => $product)
                         <tr>
                            <td> <a href="{{ url('admin/edit/product/'.$product->id) }}">{{ $product->id }}</a></td>
                            <td>
                                {{ $product->product_name}}
                            </td>
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->product_price }}</td>
                            <td>
                                @if($product->status=="1")
                                <a class="btn btn-primary btn-sm text-white">
                                 Acitve
                                </a>
                                @else
                                <a href="" class="btn btn-danger text-white">
                                    In Acitve
                                </a>
                                @endif
                            </td>
                         </tr>
                         @endforeach

                      </tbody>
                   </table>
                   <div class=" pagination-sm">
                      {{-- {{ $latestOrders->links() }} --}}
                   </div>

                </div>
             </div>
        </div>
     </div>
</section>
@endif
{{-- <script>
    $(document).ready(function() {
        $('#filterForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form submission

            // Get form data
            var formData = $(this).serialize();

            // Make AJAX request
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#orders-table').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script> --}}
<script>
    function updateTime() {
      const now = new Date();
      const hours = now.getHours();
      const minutes = now.getMinutes();
      const seconds = now.getSeconds();

      const timeElement = document.getElementById('time');
      const dateElement = document.getElementById('date');
      const greetingElement = document.getElementById('greeting');

      const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      const formattedDate = `${now.toDateString()}`;

      timeElement.textContent = formattedTime;
      dateElement.textContent = formattedDate;

      if (hours >= 0 && hours < 12) {
        greetingElement.textContent = 'Good morning!';
      } else if (hours >= 12 && hours < 18) {
        greetingElement.textContent = 'Good afternoon!';
      } else {
        greetingElement.textContent = 'Good evening!';
      }
    }

    updateTime();
    setInterval(updateTime, 1000); // Update time every second
  </script>
@endsection

