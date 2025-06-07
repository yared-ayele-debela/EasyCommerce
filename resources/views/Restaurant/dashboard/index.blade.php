@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
<style>
    .card h5 {
    transition: all 0.3s ease-in-out;
}

</style>
<nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
        <i class="bi bi-arrow-left mr-2"></i> &nbsp;
        <span>Back</span>
    </button>

    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('restaurant.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                {{-- Total Slider --}}
                <x-dashboard-card title="Total Sliders" count="{{ $total_slider }}" icon="bi-images" bg="primary"
                    description="All slider banners" />

                {{-- Total Category --}}
                <x-dashboard-card title="Categories" count="{{ $total_category }}" icon="bi-grid-3x3-gap-fill"
                    bg="success" description="Main categories" />

                {{-- Total Subcategory --}}
                <x-dashboard-card title="Subcategories" count="{{ $total_subcategory }}" icon="bi-grid" bg="info"
                    description="All subcategories" />

                {{-- Total Menu --}}
                <x-dashboard-card title="Menus" count="{{ $total_menu }}" icon="bi-book-fill" bg="dark"
                    description="Restaurant menus" />

                {{-- Total Coupon --}}
                <x-dashboard-card title="Coupons" count="{{ $total_coupon }}" icon="bi-ticket-perforated" bg="secondary"
                    description="All active coupons" />

                {{-- Total Product --}}
                <x-dashboard-card title="Products" count="{{ $total_product }}" icon="bi-box-seam" bg="warning"
                    description="Total products" />

                {{-- Total Restaurant --}}
                <x-dashboard-card title="Restaurants" count="{{ $total_restaurant }}" icon="bi-shop" bg="danger"
                    description="All listed restaurants" />

                {{-- Total Orders --}}
                <x-dashboard-card title="Orders" count="{{ $total_order }}" icon="bi-cart-check-fill" bg="success"
                    description="All orders" />

                {{-- Pending Orders --}}
                <x-dashboard-card title="Pending Orders" count="{{ $total_pending_order }}" icon="bi-clock" bg="warning"
                    description="Awaiting processing" />

                {{-- Processing Orders --}}
                <x-dashboard-card title="Processing Orders" count="{{ $total_processing_order }}" icon="bi-arrow-repeat"
                    bg="primary" description="Orders in progress" />

                {{-- Completed Orders --}}
                <x-dashboard-card title="Completed Orders" count="{{ $total_completed_order }}"
                    icon="bi-check-circle-fill" bg="info" description="Successfully delivered" />

                {{-- Canceled Orders --}}
                <x-dashboard-card title="Canceled Orders" count="{{ $total_canceled_order }}" icon="bi-x-circle-fill"
                    bg="danger" description="Order was canceled" />
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Sales Summary</h5>
                <div class="form-inline">
                    <label class="mr-2 font-weight-bold">Time Range:</label>
                    <select id="salesSummaryFilter" class="form-control">
                        <option value="1" selected>Last 1 Day</option>
                        <option value="7" >Last 7 Days</option>
                        <option value="15">Last 15 Days</option>
                        <option value="30">Last 30 Days</option>
                        <option value="60">Last 60 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="365">Last 365 Days</option>
                    </select>
                </div>
            </div>
            <div class="card-body">

                <div id="salesSummaryData" class="row">
                    <!-- Total Orders -->
                    <div class="row g-3">
                    <!-- Total Orders -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle px-3 py-2 me-3">
                                    <i class="bi bi-bag-check fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Total Orders</h6>
                                    <h5 class="mb-0" id="ss-orders">0</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sales -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle px-3 py-2  me-3">
                                    <i class="bi bi-cash-coin fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Total Sales</h6>
                                    <h5 class="mb-0" id="ss-sales">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle  px-3 py-2 me-3">
                                    <i class="bi bi-receipt fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Subtotal</h6>
                                    <h5 class="mb-0" id="ss-subtotal">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discount -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger text-white rounded-circle  px-3 py-2 me-3">
                                    <i class="bi bi-tag fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Discount</h6>
                                    <h5 class="mb-0" id="ss-discount">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Fee -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-info text-white rounded-circle px-3 py-2 me-3">
                                    <i class="bi bi-truck fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Delivery Fee</h6>
                                    <h5 class="mb-0" id="ss-delivery">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tax -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary text-white rounded-circle  px-3 py-2  me-3">
                                    <i class="bi bi-percent fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Tax</h6>
                                    <h5 class="mb-0" id="ss-tax">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-dark text-white rounded-circle px-3 py-2 me-3">
                                    <i class="bi bi-gift fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Tip</h6>
                                    <h5 class="mb-0" id="ss-tip">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Net Profit -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-sm border-0 rounded-3 p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle px-3 py-2 me-3">
                                    <i class="bi bi-graph-up-arrow fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-muted">Net Profit</h6>
                                    <h5 class="mb-0" id="ss-profit">0 ETB</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Orders Trend</h5>
            <select id="daysFilter" class="form-control w-auto">
                <option value="7">Last 7 Days</option>
                <option value="15">Last 15 Days</option>
                <option value="30">Last 30 Days</option>
                <option value="60">Last 60 Days</option>
                <option value="90">Last 90 Days</option>
                <option value="365">Last 365 Days</option>
            </select>
        </div>
        <div class="card-body">
            <canvas id="orderTrendChart" height="100"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Orders by Category</h6>
                    <div class="form-inline">
                        <select id="restaurantCategoryFilter" class="form-control">
                            <option value="7" selected>Last 7 Days</option>
                            <option value="15">Last 15 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="60">Last 60 Days</option>
                            <option value="90">Last 90 Days</option>
                            <option value="365">Last 365 Days</option>
                        </select>
                    </div>

                </div>
                <div class="card-body ">
                    <canvas id="restaurantCategoryChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <canvas id="orderStatusChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Top Users by Order Count</h5>
                    <div class="form-inline mb-3">
                        <select id="topUserFilter" class="form-control">
                            <option value="7" selected>Last 7 Days</option>
                            <option value="15">Last 15 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="60">Last 60 Days</option>
                            <option value="90">Last 90 Days</option>
                            <option value="365">Last 365 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="topUserChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="cityChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    fetch(`{{ route('orderbycity') }}`)
    .then(res => res.json())
        .then(data => {
            const labels = Object.keys(data);
            const values = Object.values(data);

            new Chart(document.getElementById('cityChart'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Orders by City',
                        data: values,
                        backgroundColor: [
                            '#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8',
                            '#6f42c1', '#20c997', '#fd7e14', '#6c757d', '#6610f2'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Orders by City'
                        },
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        });
</script>

<script>
function fetchSalesSummary(days = 7) {
    fetch(`{{ route('dashboard.sales.summary') }}?days=${days}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('ss-orders').innerText = data.total_orders ?? 0;
            document.getElementById('ss-sales').innerText = `${Number(data.total_sales ?? 0).toFixed(2)} ETB`;
            document.getElementById('ss-subtotal').innerText = `${Number(data.total_subtotal ?? 0).toFixed(2)} ETB`;
            document.getElementById('ss-discount').innerText = `${Number(data.total_discount ?? 0).toFixed(2)} ETB`;
            document.getElementById('ss-delivery').innerText = `${Number(data.total_delivery_fee ?? 0).toFixed(2)} ETB`;
            document.getElementById('ss-tax').innerText = `${Number(data.total_tax ?? 0).toFixed(2)} ETB`;
            document.getElementById('ss-tip').innerText = `${Number(data.total_tip ?? 0).toFixed(2)} ETB`;
            document.getElementById('ss-profit').innerText = `${Number(data.total_profit ?? 0).toFixed(2)} ETB`;
        });
}

fetchSalesSummary();

document.getElementById('salesSummaryFilter').addEventListener('change', function () {
    fetchSalesSummary(this.value);
});

</script>

<script>
fetch(`{{ route('orderStatusBreakdown') }}`)
    .then(res => res.json())
    .then(data => {
        const labels = Object.keys(data);
        const values = Object.values(data);

        new Chart(document.getElementById('orderStatusChart'), {
            type: 'polarArea',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Orders',
                    data: values,
                    backgroundColor: [
                        '#007bff', // Primary
                        '#28a745', // Success
                        '#dc3545', // Danger
                        '#ffc107', // Warning
                        '#17a2b8', // Info
                        '#6f42c1' // Purple
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Order Status Breakdown'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
</script>

<script>
let topUserChart;

function fetchTopUsers(days = 7) {
    fetch(`{{ route('chart.top.users') }}?days=${days}`)
        .then(res => res.json())
        .then(data => {
            const labels = data.map(u => u.user_name);
            const counts = data.map(u => u.order_count);

            const ctx = document.getElementById('topUserChart').getContext('2d');
            if (topUserChart) topUserChart.destroy();

            topUserChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Order Count',
                        data: counts,
                        backgroundColor: '#17BE18'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Top 10 Users by Orders'
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Orders'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Users'
                            }
                        }
                    }
                }
            });
        });
}

fetchTopUsers();

document.getElementById('topUserFilter').addEventListener('change', function() {
    fetchTopUsers(this.value);
});
</script>

<script>
let restaurantCategoryChart;

function fetchRestaurantCategoryData(days = 7) {
    fetch(`{{ route('orders.by.category') }}?days=${days}`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) {

                return;
            }

            const labels = data.map(d => d.category_name);
            const counts = data.map(d => d.order_count);

            const ctx = document.getElementById('restaurantCategoryChart').getContext('2d');

            if (restaurantCategoryChart) restaurantCategoryChart.destroy();

            restaurantCategoryChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Orders',
                        data: counts,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                            '#E7E9ED', '#66BB6A'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Orders by Category'
                        },
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw} orders`;
                                }
                            }
                        }
                    }
                }
            });
        });
}

// Initialize
fetchRestaurantCategoryData();

// On filter change
document.getElementById('restaurantCategoryFilter').addEventListener('change', function() {
    fetchRestaurantCategoryData(this.value);
});
</script>
<script>
let orderTrendChart;

function fetchChartData(days = 7) {
    fetch(`{{ route('orders.trend') }}?days=${days}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                return;
            }
            const labels = data.map(d => d.date);
            const sales = data.map(d => parseFloat(d.total_sales));
            const counts = data.map(d => parseInt(d.order_count));

            const ctx = document.getElementById('orderTrendChart').getContext('2d');

            if (orderTrendChart) orderTrendChart.destroy();

            orderTrendChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales (₦)',
                        data: sales,
                        backgroundColor: '#17BE18',
                        borderColor: '#17BE18',
                        yAxisID: 'y',
                    }, {
                        label: 'Order Count',
                        data: counts,
                        type: 'line', // You can change this to 'bar' if you want grouped bars
                        borderColor: '#ff9800',
                        backgroundColor: '#ff9800',
                        fill: false,
                        yAxisID: 'y1',
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    stacked: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.label === 'Total Sales (₦)') {
                                        return `₦${context.formattedValue}`;
                                    }
                                    return `${context.formattedValue} Orders`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Orders and Revenue Trend'
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: '₦ Sales'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Order Count'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        });
}

fetchChartData();

document.getElementById('daysFilter').addEventListener('change', function() {
    fetchChartData(this.value);
});
</script>



@endsection
