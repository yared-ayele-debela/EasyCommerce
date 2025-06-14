@extends('admindashboard.layouts')
@section('dashboard')
<div class="container-fluid py-4">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard Overview</li>
        </ol>
    </nav>
    {{-- User Role Counts --}}
@if(Auth::guard('admin')->user()->type == 'Super Admin' || Auth::guard('admin')->user()->type == 'admin')
    <div class="row">
        <div class="col-md-8">
            <div class="row g-3 mb-4">
                @php
                $roles = [
                ['title' => 'Customers', 'icon' => 'people', 'value' => $counts['customers'], 'bg' => 'info'],
                ['title' => 'Vendors', 'icon' => 'shop', 'value' => $counts['vendors'], 'bg' => 'primary'],
                ['title' => 'Admins', 'icon' => 'shield-lock', 'value' => $counts['admins'], 'bg' => 'dark'],
                ['title' => 'Delivery Men', 'icon' => 'truck', 'value' => $counts['deliverymen'], 'bg' => 'warning'],
                ['title' => 'Sales Men', 'icon' => 'person-badge', 'value' => $counts['salesmen'], 'bg' => 'success'],
                ];
                @endphp

                @foreach($roles as $role)
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-{{ $role['bg'] }} text-white shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">{{ $role['title'] }}</h6>
                                <h3>{{ $role['value'] }}</h3>
                            </div>
                            <i class="bi bi-{{ $role['icon'] }} display-5 opacity-25"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Order Status Summary --}}
            <div class="row g-3 mb-4">
                @php
                $statuses = [
                ['status' => 'All Orders', 'icon' => 'file-earmark-text', 'count' => $orderStatus['all'], 'bg' => 'secondary'],
                ['status' => 'New', 'icon' => 'hourglass-split', 'count' => $orderStatus['new'], 'bg' => 'info'],
                ['status' => 'Pending', 'icon' => 'hourglass-split', 'count' => $orderStatus['pending'], 'bg' => 'warning'],
                ['status' => 'Confirmed', 'icon' => 'hourglass-split', 'count' => $orderStatus['confirmed'], 'bg' => 'success'],
                ['status' => 'Picked', 'icon' => 'hourglass-split', 'count' => $orderStatus['picked'], 'bg' => 'secondary'],
                ['status' => 'Delivering', 'icon' => 'hourglass-split', 'count' => $orderStatus['delivering'], 'bg' => 'info'],
                ['status' => 'Delivered', 'icon' => 'check-circle', 'count' => $orderStatus['delivered'], 'bg' => 'success'],
                ['status' => 'Cancelled', 'icon' => 'x-circle', 'count' => $orderStatus['cancelled'], 'bg' => 'danger'],
                ];
                @endphp

                @foreach($statuses as $status)
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-{{ $status['bg'] }} text-white shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">{{ $status['status'] }}</h6>
                                <h3>{{ $status['count'] }}</h3>
                            </div>
                            <i class="bi bi-{{ $status['icon'] }} display-5 opacity-25"></i>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-primary text-white shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Order Return Request </h6>
                                <h3>{{ $return_request }}</h3>
                            </div>
                            <i class="bi bi-file-earmark-text display-5 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @if(count($outOfStockProducts) > 0)
            <div class="card mb-3">
                <div class="card-header bg-danger text-white d-flex justify-content-between">
                    <span><i class="ri-error-warning-line"></i> Out of Stock Products</span>
                    <a href="{{ route('out-of-products') }}" class="text-white small">View All</a>
                </div>
                <div class="card-body text-danger">
                    <h5 class="card-title">{{ count($outOfStockProducts) }} product(s)</h5>
                    <p class="card-text">Some products are currently out of stock. Restock them to avoid losing sales.</p>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="filter float-end py-2">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item filter-link" href="#" data-filter="today">Today</a></li>
                            <li><a class="dropdown-item filter-link" href="#" data-filter="month">This Month</a></li>
                            <li><a class="dropdown-item filter-link" href="#" data-filter="year">This Year</a></li>
                        </ul>
                    </div>
                    <br>

                    <div id="activityContainer" style="max-height: 300px; overflow-y: auto;">

                    </div>
                    <button id="loadMore" class="btn btn-outline-primary mt-2">Load More</button>

                </div>
            </div>

        </div>
    </div>
    <div class="row g-3">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sales By Vendor</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesByVendorChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <canvas id="topProductsChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top Buyers</h5>
                </div>
                <div class="card-body">
                    <canvas id="topCustomersChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top Vendors</h5>
                </div>
                <div class="card-body">
                    <canvas id="topVendorsChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Order Status Summary</h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <!-- 1. Monthly Sales Trends -->
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Monthly Sales (Last 12 Months)</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthlySalesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Sales by City</h6>
                </div>
                <div class="card-body">
                    <canvas id="citySalesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <!-- 2. Payment Method Breakdown -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Payment Method Breakdown</h6>
                </div>
                <div class="card-body">
                    <canvas id="paymentMethodChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6>Customers: New vs Repeat</h6>
                </div>
                <div class="card-body">
                    <canvas id="repeatCustomerChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
@else
   <div class="row">
    <div class="col-md-8">
        <div class="row g-3 mb-4">
                @php
                $statuses = [
                ['status' => 'All Orders', 'icon' => 'file-earmark-text', 'count' => $orderStatus['all'], 'bg' => 'secondary'],
                ['status' => 'New', 'icon' => 'hourglass-split', 'count' => $orderStatus['new'], 'bg' => 'info'],
                ['status' => 'Pending', 'icon' => 'hourglass-split', 'count' => $orderStatus['pending'], 'bg' => 'warning'],
                ['status' => 'Confirmed', 'icon' => 'hourglass-split', 'count' => $orderStatus['confirmed'], 'bg' => 'success'],
                ['status' => 'Picked', 'icon' => 'hourglass-split', 'count' => $orderStatus['picked'], 'bg' => 'secondary'],
                ['status' => 'Delivering', 'icon' => 'hourglass-split', 'count' => $orderStatus['delivering'], 'bg' => 'info'],
                ['status' => 'Delivered', 'icon' => 'check-circle', 'count' => $orderStatus['delivered'], 'bg' => 'success'],
                ['status' => 'Cancelled', 'icon' => 'x-circle', 'count' => $orderStatus['cancelled'], 'bg' => 'danger'],
                ];
                @endphp

                @foreach($statuses as $status)
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-{{ $status['bg'] }} text-white shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">{{ $status['status'] }}</h6>
                                <h3>{{ $status['count'] }}</h3>
                            </div>
                            <i class="bi bi-{{ $status['icon'] }} display-5 opacity-25"></i>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-3 col-sm-6">
                    <div class="card bg-primary text-white shadow h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Order Return Request </h6>
                                <h3>{{ $return_request }}</h3>
                            </div>
                            <i class="bi bi-file-earmark-text display-5 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
    </div>
   <div class="col-lg-4">

            <div class="card">
                <div class="card-body">
                    <div class="filter float-end py-2">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item filter-link" href="#" data-filter="today">Today</a></li>
                            <li><a class="dropdown-item filter-link" href="#" data-filter="month">This Month</a></li>
                            <li><a class="dropdown-item filter-link" href="#" data-filter="year">This Year</a></li>
                        </ul>
                    </div>
                    <br>

                    <div id="activityContainer" style="max-height: 300px; overflow-y: auto;">

                    </div>
                    <button id="loadMore" class="btn btn-outline-primary mt-2">Load More</button>

                </div>
            </div>

        </div>
   </div>
    <div class="row">

        {{-- Monthly Sales Line Chart --}}
        <div class="col-md-9 mb-4">
           <div class="card">
            <div class="card-header">
                <h5 class="card-title">Monthly Sales Trends</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart" height="100"></canvas>
            </div>
           </div>
        </div>
        <div class="col-md-3">
             @if(count($outOfStockProducts) > 0)
            <div class="card mb-3">
                <div class="card-header bg-danger text-white d-flex justify-content-between">
                    <span><i class="ri-error-warning-line"></i> Out of Stock Products</span>
                    <a href="{{ route('out-of-products') }}" class="text-dark small btn btn-outline-light">View All</a>
                </div>
                <div class="card-body text-danger">
                    <h5 class="card-title">{{ count($outOfStockProducts) }} product(s)</h5>
                    <p class="card-text">Some products are currently out of stock. Restock them to avoid losing sales.</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Top Products Bar Chart --}}
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top Selling Products</h5>
                    </div>
                    <div class="card-body">
                         <canvas id="topProductsChart" height="100"></canvas>
            </div>
        </div>

        {{-- City Sales Pie Chart --}}
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sales by City</h5>
                </div>
                <div class="card-body">
                      <canvas id="citySalesChart" height="100"></canvas>
                </div>
        </div>

        {{-- Payment Breakdown Doughnut --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Payment Method Breakdown</h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentMethodChart" height="100"></canvas>
                </div>
            </div>
        </div>

    </div>
@endif
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    const paymentLabels = Object.keys(paymentBreakdown);
    const paymentValues = Object.values(paymentBreakdown);

    new Chart(document.getElementById('paymentBreakdownChart'), {
        type: 'doughnut',
        data: {
            labels: paymentLabels,
            datasets: [{
                data: paymentValues,
                backgroundColor: ['#4BC0C0', '#FF9F40', '#FF6384', '#9966FF']
            }]
        }
    });

</script>
<script>
  // Data from controller
  const monthlySales = @json($monthlySales); // [{ month: "Jan 2024", total: 10000 }, ...]
  const paymentMethods = @json($paymentBreakdown); // { "card": 50000, "paypal": 20000 }
  const citySales = @json($citySales); // [{ city: "Addis Ababa", total: 25000 }, ...]
  const repeatCustomerData = @json($repeatData); // { new: 120, repeat: 80 }

  new Chart(document.getElementById('monthlySalesChart'), {
    type: 'line',
    data: {
      labels: monthlySales.map(m => m.month),
      datasets: [{
        label: 'Sales (ETB)',
        data: monthlySales.map(m => m.total),
        borderColor: '#007bff',
        backgroundColor: 'rgba(0, 123, 255, 0.1)',
        fill: true
      }]
    },
    options: { responsive: true }
  });

  new Chart(document.getElementById('paymentMethodChart'), {
    type: 'pie',
    data: {
      labels: Object.keys(paymentMethods),
      datasets: [{
        data: Object.values(paymentMethods),
        backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6c757d']
      }]
    },
    options: { responsive: true }
  });

  new Chart(document.getElementById('citySalesChart'), {
    type: 'bar',
    data: {
      labels: citySales.map(c => c.city),
      datasets: [{
        label: 'Revenue',
        data: citySales.map(c => c.total),
        backgroundColor: 'rgba(40, 167, 69, 0.6)'
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      scales: { x: { beginAtZero: true } }
    }
  });

  new Chart(document.getElementById('repeatCustomerChart'), {
    type: 'doughnut',
    data: {
      labels: ['New Customers', 'Repeat Customers'],
      datasets: [{
        data: [repeatCustomerData.new, repeatCustomerData.repeat],
        backgroundColor: ['#007bff', '#6610f2']
      }]
    },
    options: { responsive: true }
  });
</script>

<script>
    const topProductsData = @json($topProducts); // [{name: 'Burger', total: 100}, ...]
    const productNames = topProductsData.map(p => p.name);
    const productTotals = topProductsData.map(p => p.total);

    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar'
        , data: {
            labels: productNames
            , datasets: [{
                label: 'Top Selling Products'
                , data: productTotals
                , backgroundColor: 'rgba(54, 162, 235, 0.6)'
                , borderColor: 'rgba(54, 162, 235, 1)'
                , borderWidth: 1
            }]
        }
        , options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @if(Auth::guard('admin')->user()->type == 'Super Admin' || Auth::guard('admin')->user()->type == 'admin')

    const ctx = document.getElementById('salesByVendorChart').getContext('2d');

    const salesByVendorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $vendorLabels !!},
            datasets: [{
                label: 'Total Sales (ETB)',
                data: {!! $vendorSales !!},
                backgroundColor: 'rgb(116,206,137)',
                borderColor: 'rgb(116,106,137)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'ETB ' + value
                    }
                }
            }
        }
    });
    const orderStatuses = @json($orderStatuses); // {pending: 10, delivered: 5, cancelled: 3}

    new Chart(document.getElementById('orderStatusChart'), {
        type: 'pie'
        , data: {
            labels: Object.keys(orderStatuses)
            , datasets: [{
                label: 'Order Status'
                , data: Object.values(orderStatuses)
                , backgroundColor: ['#ffc107', '#28a745', '#dc3545', '#17a2b8']
            , }]
        }
    , });
    const topVendors = @json($topVendors); // [{name: 'Vendor A', total: 3000}, ...]

    new Chart(document.getElementById('topVendorsChart'), {
        type: 'doughnut'
        , data: {
            labels: topVendors.map(v => v.name)
            , datasets: [{
                label: 'Top Vendors'
                , data: topVendors.map(v => v.total)
                , backgroundColor: ['#007bff', '#6610f2', '#e83e8c', '#fd7e14']
            }]
        }
    , });
    const topCustomers = @json($topCustomers); // [{name: 'John Doe', total: 1200}, ...]

    new Chart(document.getElementById('topCustomersChart'), {
        type: 'bar'
        , data: {
            labels: topCustomers.map(c => c.name)
            , datasets: [{
                label: 'Top Buyers'
                , data: topCustomers.map(c => c.total)
                , backgroundColor: 'rgba(40, 167, 69, 0.6)'
                , borderColor: 'rgba(40, 167, 69, 1)'
                , borderWidth: 1
            }]
        }
        , options: {
            indexAxis: 'y'
            , scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
    @endif

</script>
<script>
    let currentPage = 1;
    let currentFilter = 'today';

    function fetchActivities(reset = false) {
        if (reset) {
            currentPage = 1;
            document.getElementById("activityContainer").innerHTML = '';
        }

        fetch(`/admin/admin/activities?filter=${currentFilter}&page=${currentPage}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    document.getElementById("loadMore").style.display = 'none';
                    return;
                }

                data.forEach(activity => {
                    const createdAt = new Date(activity.created_at);
                    const diffHours = (new Date() - createdAt) / 36e5;
                    // alert(diffHours);

                    let badgeClass = 'text-success';
                    if (diffHours >= 2 && diffHours < 3) badgeClass = 'text-primary';
                    else if (diffHours >= 3 && diffHours < 5) badgeClass = 'text-danger';
                    else if (diffHours >= 6) badgeClass = 'text-secondary';

                    const html = `
                        <div class="activity-item d-flex">
                            <i class='bi bi-circle-fill activity-badge ${badgeClass} align-self-start'></i> &nbsp;
                            <div class="activity-content">
                                ${activity.activity} <a href="#" class=" text-dark">${activity.description}</a>
                            </div>
                        </div>
                    `;
                    document.getElementById("activityContainer").insertAdjacentHTML('beforeend', html);
                });

                currentPage++;
            });
    }

    document.querySelectorAll('.filter-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            currentFilter = link.dataset.filter;
            fetchActivities(true);
            document.getElementById("loadMore").style.display = 'inline-block';
        });
    });

    document.getElementById('loadMore').addEventListener('click', () => {
        fetchActivities();
    });

    // Initial load
    fetchActivities();

</script>

@endsection

