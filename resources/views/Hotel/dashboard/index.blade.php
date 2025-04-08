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

 <section class="section dashboard">
    <h3 class="mb-4 fw-bold">Dashboard</h3>
    <div class="row">
       <div class="col-lg-12">
        <div class="row g-4">
            {{-- Hotels --}}
            <x-hotel-dashboard-card title="Total Hotels" :value="$total_hotel" icon="bi-building" color="primary" />
    
            {{-- Rooms --}}
            <x-hotel-dashboard-card title="Total Rooms" :value="$total_rooms" icon="bi-door-open" color="info" />
    
            <x-hotel-dashboard-card title="Total Customers" :value="$total_customers" icon="bi-people" color="dark" />
    
            <x-hotel-dashboard-card title="Hotel Categories" :value="$total_category" icon="bi-tags" color="warning" />
    
            <x-hotel-dashboard-card title="Amenities" :value="$total_amenities" icon="bi-list-check" color="success" />
    
            <x-hotel-dashboard-card title="Total Bookings" :value="$total_bookings" icon="bi-calendar-check" color="success" />
            <x-hotel-dashboard-card title="Pending Bookings" :value="$total_pending_bookings" icon="bi-hourglass-split" color="secondary" />
            <x-hotel-dashboard-card title="Confirmed Bookings" :value="$total_confirmed_bookings" icon="bi-check2-square" color="info" />
            <x-hotel-dashboard-card title="Checked-in Bookings" :value="$total_checked_in_bookings" icon="bi-door-closed" color="primary" />
            <x-hotel-dashboard-card title="Completed Bookings" :value="$total_completed_bookings" icon="bi-clipboard-check" color="success" />
            <x-hotel-dashboard-card title="Cancelled Bookings" :value="$total_cancelled_bookings" icon="bi-x-octagon" color="danger" />
    
        </div>
       </div>
    </div>
 </section>
@endsection

