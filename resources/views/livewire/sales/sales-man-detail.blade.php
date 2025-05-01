<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">All sales users</li>
            </ol>
        </nav>
    </div>
    <section class="section">
       <div class="row">
        <div class="col">
            @if($salesUser)
            <div class="card">
                <div class="card-header">
                    <h4>Sales User Details</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $salesUser->name }}</p>
                    <p><strong>Phone:</strong> {{ $salesUser->phone }}</p>
                    <p><strong>Address:</strong> {{ $salesUser->address }}</p>

                    <div class="mb-2"><strong>Referral Token:</strong><p id="link-{{ $salesUser->id }}">{{ url('special-link/'.$salesUser->referral_token) }}</p>
                        <button class="btn btn-sm btn-primary" onclick="copyToClipboard('link-{{ $salesUser->id }}')">
                            <i class="ri-file-copy-fill"></i> Copy
                        </button>
                    </div>
                    <p><strong>Email:</strong> {{ $salesUser->email }}</p>
                    @if($salesUser->image)
                    <p><strong>Image:</strong></p>
                    <img src="{{ $salesUser->image }}" width="200" alt="{{ $salesUser->name }}">
                    @endif
                </div>
            </div>
            @else
            <div class="alert alert-danger">
                Sales User not found.
            </div>
            @endif
        </div>
       </div>
       <div class="row">
             <div class="card p-4">
                @if($selesCommision->isEmpty())
                <div class="alert alert-info">
                    No sales commissions found for this user.
                </div>
                @else
                <table class="table mt-2" id="example">
                    <thead>
                        <tr>
                            <th>Commission ID</th>
                            <th>Product</th>
                            <th>Order Total</th>
                            <th>Commission Amount</th>
                            <th>Sale Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selesCommision as $commission)
                            <tr>
                                <td>{{ $commission->id }}</td>
                                <td><b>{{ $commission->product->product_name }}</b>
                                </td>
                                <td>
                                    {{ $commission->order->grand_total }}
                                </td>
                                <td>{{ $commission->amount }}</td>
                                <td>{{ $commission->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
             </div>
       </div>
    </section>
    <script>
        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(copyText).then(function() {
                alert('Copied to clipboard: ' + copyText);
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        }
    </script>
</div>

