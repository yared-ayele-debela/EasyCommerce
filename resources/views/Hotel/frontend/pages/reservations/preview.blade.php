@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <h4 class="mb-4">Reservation Summary</h4>
        </div>
        <div class="col-lg-7 mb-2">
            <div class="offer-card">
                <div class="card-body p-4">
                    <h4 class="card-title text-primary mb-3">{{ $room->hotel->name }}</h4>
                    <div class="row">
                        <div class="col-md-4">
                            @if($room->image)
                            <img src="{{ $room->image }}" class="w-100 rounded-img" height="170" alt="{{ $room->hotel->name }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush border-0">
                                <li class="list-group-item border-0"><strong>Hotel:</strong> {{ $room->hotel->name }}</li>
                                <li class="list-group-item border-0"><strong>Hotel Location:</strong> {{ $room->hotel->country }}, {{ $room->hotel->state }}, {{ $room->hotel->city }}, {{ $room->hotel->location }}</li>
                                <li class="list-group-item border-0"><strong><i class=" bi bi-star-fill text-primary"></i></strong> {{ $room->hotel->rating}}</li>
                            </ul>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush border-0 my-2">
                        <li class="list-group-item list-group-item-light border-0"><strong>Room Type:</strong> {{ $room->room_type }}</li>
                        <li class="list-group-item list-group-item-light border-0"><strong>Check-in:</strong> {{ $validated['check_in_date'] }}</li>
                        <li class="list-group-item list-group-item-light border-0"><strong>Check-out:</strong> {{ $validated['check_out_date'] }}</li>
                        <li class="list-group-item list-group-item-light border-0"><strong>Total Nights:</strong> {{ $validated['total_night'] }}</li>
                        <li class="list-group-item list-group-item-light border-0">
                            <strong>Guests:</strong> {{ $validated['total_adult'] }} Adults,
                            {{ $validated['total_child'] ?? 0 }} Children,
                            {{ $validated['total_infant'] ?? 0 }} Infants
                        </li>
                    </ul>
                    @php $basePrice = $room->price * $validated['total_night']; @endphp

                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-2">
            <form action="{{ route('reservation.store') }}" method="POST" enctype="multipart/form-data" id="confirmForm">
                @csrf
                <div class="offer-card">
                    <div class="card-body p-4">
                        <label for="coupon_code" class="form-label">Coupon Code <small class="text-muted">(Optional)</small></label>
                        <div class="promo-code pt-0 mt-0">
                            <input type="text" id="coupon_code" class="promo-input" placeholder="Enter Promo Code">
                            <button type="button"  id="apply_coupon" class="bg-primary text-white">APPLY</button>
                        </div>
                        <span id="discount-info" class="mt-2 text-primary "></span>
                        <hr>
                        <div class="mb-2">
                            <label for="bank" class="form-label">Select Bank</label>
                            <select class="form-select" name="bank_name" required>
                                <option value="" selected disabled>-- Choose Bank --</option>
                                <option value="CBE">Commercial Bank of Ethiopia</option>
                                <option value="Awash">Awash Bank</option>
                                <option value="Dashen">Dashen Bank</option>
                            </select>
                            @error('bank_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="transaction_number" class="form-label">Transaction Number</label>
                            <input type="text" name="transaction_number" class="form-control">
                            @error('transaction_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="receipt" class="form-label">Upload Receipt</label>
                            <input type="file" name="receipt" class="form-control" accept="image/*,application/pdf" required>
                            @error('receipt')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="summary-card mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><strong>SubTotal</strong></span>
                                <span><strong id="subtotal_value">{{ number_format($basePrice, 2) }} ETB</strong></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><strong>Discount</strong></span>
                                <div>
                                    <strong>
                                        <span id="discount_amount">0</span>
                                        ETB
                                    </strong>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><strong>Total</strong></span>
                                <div>
                                    <strong>
                                        <span id="total_price">{{ number_format($basePrice, 2) }} </span>
                                        ETB
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>

                            @foreach ($validated as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="hotel_id" value="{{ $room->hotel->id }}">
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="total_night" value="{{ $validated['total_night'] }}">
                            <input type="hidden" name="check_in_date" value="{{ $validated['check_in_date'] }}">
                            <input type="hidden" name="check_out_date" value="{{ $validated['check_out_date'] }}">
                            <input type="hidden" name="total_adult" value="{{ $validated['total_adult'] }}">
                            <input type="hidden" name="total_child" value="{{ $validated['total_child'] }}">
                            <input type="hidden" name="total_infant" value="{{ $validated['total_infant'] }}">
                            <input type="hidden" name="total_price" id="_total_price" value="{{ $basePrice }}">
                            <input type="hidden" name="coupon_id" id="coupon_id" value="">
                            <input type="hidden" name="discount_amount" id="_discount_amount" value="0">
                            <input type="hidden" name="final_price" id="_final_price" value="{{ $basePrice }}">
                            <button type="submit" class="btn btn-primary rounded rounded-1">Confirm & Reserve</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
   <script>
    document.addEventListener("DOMContentLoaded", function () {
        const applyButton = document.getElementById("apply_coupon");

        if (applyButton) {
            applyButton.addEventListener("click", applyCoupon);
            // alert("correct");
        }
        // alert("incorrect");

        function applyCoupon(event) {
            event.preventDefault();

            const coupon = document.getElementById('coupon_code').value.trim();
            const basePrice = {{ $basePrice ?? 0 }};

            if (!coupon) {
                alert("Please enter a coupon code.");
                return;
            }

            fetch("{{ route('hotel.coupons.apply') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coupon_code: coupon })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Invalid or expired coupon.");
                }
                return response.json();
            })
            .then(data => {
                let discount = 0;
                if (data.type === 'percent') {
                    discount = basePrice * (data.value / 100);
                } else if (data.type === 'fixed') {
                    discount = parseFloat(data.value);
                }

                const finalPrice = Math.max(basePrice - discount, 0);

                document.getElementById('discount-info').style.display = 'block';
                document.getElementById('discount-info').innerText = data.message;
                document.getElementById('discount_amount').innerText = discount.toFixed(2);
                document.getElementById('total_price').innerText = finalPrice.toFixed(2);

                document.getElementById('_discount_amount').value = discount.toFixed(2);
                document.getElementById('_total_price').value = basePrice.toFixed(2);
                document.getElementById('_final_price').value = finalPrice.toFixed(2);
                document.getElementById('coupon_id').value = data.coupon;
            })
            .catch(error => {
                alert(error.message);
                document.getElementById('discount-info').style.display = 'none';
                document.getElementById('discount_amount').innerText = '0';
                document.getElementById('total_price').innerText = basePrice.toFixed(2);
                document.getElementById('_final_price').value = basePrice.toFixed(2);
            });
        }
    });
</script>
@endsection

