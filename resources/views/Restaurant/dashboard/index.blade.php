@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
<div class="pagetitle shadow-sm">
    <nav class="p-4 text-center">
       <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
       </ol>
    </nav>
 </div>
 <section class="section dashboard">
    <div class="row">
       <div class="col-lg-12">
          <div class="row">
            <div class="col-md-3">
                <div class="card cards sales-card">
                    <div class="card-body">
                       <a href="">
                        <h5 class="card-title">Total Cars</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                            </svg>                            </div>
                            <div class="ps-3">
                                <h6 style="font-size: 28px;"><b>k10</b></h6>
                                <span class="text-white small pt-1 fw-bold">In stock</span>
                            </div>
                        </div>
                       </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                    <a href="">
                        <div class="card-body">
                            <h5 class="card-title">Total Admins</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>11</h6>
                                    <span class="text-white small pt-1 fw-bold">Admin users</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title">Total Users</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><b>11</b></h6>
                                    <span class="text-white small pt-1 fw-bold">Registered users</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                    <a href="11">
                        <div class="card-body">
                            <h5 class="card-title">Active Users</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><b>11</b></h6>
                                    <span class="text-white small pt-1 fw-bold">Currently active</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                   <a href="1">
                    <div class="card-body">
                        <h5 class="card-title">Approved Registration Fees</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6><b>11</b></h6>
                                <span class="text-white small pt-1 fw-bold">Approved payments</span>
                            </div>
                        </div>
                    </div>
                   </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                    <a href="">
                        <div class="card-body">
                            <h5 class="card-title">Pending Registration Fees</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><b>11</b></h6>
                                    <span class="text-white small pt-1 fw-bold">Pending payments</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                   <a href="111">
                    <div class="card-body">
                        <h5 class="card-title">Declined Registration Fees</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6><b>u88</b></h6>
                                <span class="text-white small pt-1 fw-bold">Declined payments</span>
                            </div>
                        </div>
                    </div>
                   </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card sales-card">
                     <a href="">
                        <div class="card-body">
                            <h5 class="card-title">Total Ekub</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><b>11</b></h6>
                                    <span class="text-white small pt-1 fw-bold">Active Ekubs</span>
                                </div>
                            </div>
                        </div>
                     </a>
                </div>
            </div>
          </div>
       </div>
    </div>
 </section>
@endsection

