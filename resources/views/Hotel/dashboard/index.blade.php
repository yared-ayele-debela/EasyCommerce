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
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('hotel.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
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
       <div class="col-md-8">
        <div class="card">
            <canvas id="monthlyChart"></canvas>
        </div>
       </div>
       <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="text-center">Reservations By Status</h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
       </div>
       <div class="col-md-8">
        <div class="card">
            <div class="card-header">
             <h5>  Monthly Income</h5>
            </div>
            <div class="card-body">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
       </div>
       <div class="col-md-4">
        <div class="card">
            <div class="card-header">
               <h6>Guests</h6>
            </div>
            <div class="card-body">
                <canvas id="guestChart"></canvas>
            </div>
        </div>
       </div>

       <div class="col-md-12">
        <div class="card">
            <div class="card-header">
             <h5> Top 5 Most Reserved Hotels</h5>
            </div>
            <div class="card-body">
                <canvas id="topHotelsChart"></canvas>
            </div>
        </div>
       </div>
       <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-3">Top 5 Most Reserved Rooms</h5>
                <form id="filterForm" class="form-inline row">
                    <div class="form-group col-md-3 mb-2">
                        <label for="start_date" class="sr-only">Start Date:</label>
                        <input type="date" name="start_date" class="form-control w-100" id="start_date" placeholder="Start Date">
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="end_date" class="sr-only">End Date:</label>
                        <input type="date" name="end_date" class="form-control w-100" id="end_date" placeholder="End Date">
                    </div>

                    <div class="form-group col-md-3 mb-2">
                        <label for="hotel_id" class="sr-only">Hotel:</label>
                        <select name="hotel_id" class="form-control w-100" id="hotel_id">
                            <option value="">All Hotels</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <canvas id="roomChart" width="600" height="300"></canvas>
            </div>
        </div>
       </div>
    </div>
 </section>

 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
    let chart;

    function renderChart(labels, data) {
        const ctx = document.getElementById('roomChart').getContext('2d');
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Reservations',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    function fetchData() {
        $.ajax({
            url: '{{ route("dashboard.filter") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                hotel_id: $('#hotel_id').val(),
            },
            success: function (response) {
                const labels = response.map(item => item.room_number);
                const data = response.map(item => item.total);
                renderChart(labels, data);
            }
        });
    }

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        fetchData();
    });

    // Initial load
    $(document).ready(fetchData);
</script>
<script>
const topHotelsCtx = document.getElementById('topHotelsChart').getContext('2d');
new Chart(topHotelsCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($topHotelsFormatted->pluck('name')) !!},
        datasets: [{
            label: 'Top Reserved Hotels',
            data: {!! json_encode($topHotelsFormatted->pluck('total')) !!},
            backgroundColor: 'rgba(153, 102, 255, 0.6)'
        }]
    }
});
</script>

<script>
const guestCtx = document.getElementById('guestChart').getContext('2d');
new Chart(guestCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($guestCounts)) !!},
        datasets: [{
            data: {!! json_encode(array_values($guestCounts)) !!},
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
        }]
    }
});
</script>

<script>
const incomeCtx = document.getElementById('incomeChart').getContext('2d');
new Chart(incomeCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach(range(1, 12) as $m)
                "{{ DateTime::createFromFormat('!m', $m)->format('F') }}",
            @endforeach
        ],
        datasets: [{
            label: 'Monthly Income',
            data: [
                @foreach(range(1, 12) as $m)
                    {{ $monthlyIncome[$m] ?? 0 }},
                @endforeach
            ],
            borderColor: '#4bc0c0',
            fill: false,
            tension: 0.1
        }]
    }
});
</script>

<script>
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($statusCounts->keys()) !!},
        datasets: [{
            data: {!! json_encode($statusCounts->values()) !!},
            backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384', '#4BC0C0']
        }]
    }
});
</script>

 <script>
 const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
 new Chart(monthlyCtx, {
     type: 'bar',
     data: {
         labels: [
             @foreach(range(1, 12) as $m)
                 "{{ DateTime::createFromFormat('!m', $m)->format('F') }}",
             @endforeach
         ],
         datasets: [{
             label: 'Monthly Reservations',
             data: [
                 @foreach(range(1, 12) as $m)
                     {{ $monthlyReservations[$m] ?? 0 }},
                 @endforeach
             ],
             backgroundColor: 'rgba(75, 192, 192, 0.6)'
         }]
     }
 });
 </script>

@endsection

