@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<style>
.custom-card{
    background-color: #20b920 !important;
    border-radius: 10px;
    color: white !important
    padding: 20px;
    margin-bottom: 20px;
}
.pending{
    background-color: #f0df4a !important;
}
.completed{
    background-color: #4ea04e !important;
}
.cancelled{
    background-color: #d9534f !important;
}
.checked_in{
    background-color: #5bc0de !important;
}
.confirmed{
    background-color: #2d6b09 !important;
}

</style>
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
                <div class="card cards custom-card">
                    <div class="card-body">
                       <a href="">
                        <h5 class="card-title text-white">Total Hotels</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-building text-white"></i>
                        </div>
                            <div class="ps-3">
                                <h6 class="text-white"><strong>{{ $total_hotel }}</strong></h6>
                            </div>
                        </div>
                       </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cards info-card custom-card">
                    <a href="">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Rooms</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon text-white rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bookmark"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $total_rooms }}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

           

            <div class="col-md-3">
                <div class="card cards info-card custom-card">
                    <a href="11">
                        <div class="card-body">
                            <h5 class="card-title text-white">Customers</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-circle text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $total_customers }}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card custom-card">
                   <a href="1">
                    <div class="card-body">
                        <h5 class="card-title text-white">Total Hotel Categories</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-bookmark-check-fill text-white"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="text-white">{{ $total_category }}</h6>
                            </div>
                        </div>
                    </div>
                   </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card cards info-card custom-card">
                    <a href="">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Amenities</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-command text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white">{{ $total_amenities }}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <hr>
            <div class="col-md-2">
                <div class="card cards info-card custom-card h-100">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title text-white">Total Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi  bi-calendar3-event text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white" ><b>{{ $total_bookings }}</b></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card cards info-card pending  h-100">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title text-white">Pending Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi  bi-calendar3-event text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white" ><b>{{ $total_pending_bookings }}</b></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card cards info-card confirmed h-100">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title text-white">Comfirmed Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar3-event text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white" ><b>{{ $total_confirmed_bookings }}</b></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card cards info-card cancelled h-100">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title text-white">Cancelled Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi  bi-calendar3-event text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white" ><b>{{ $total_cancelled_bookings }}</b></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card cards info-card checked_in h-100">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title text-white">Checked_in Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi  bi-calendar3-event text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white" ><b>{{ $total_checked_in_bookings }}</b></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card cards info-card completed h-100">
                    <div class="card-body">
                        <a href="">
                            <h5 class="card-title text-white">Completed Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi  bi-calendar3-event text-white"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 class="text-white" ><b>{{ $total_completed_bookings }}</b></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
          </div>
       </div>
    </div>
 </section>
@endsection

