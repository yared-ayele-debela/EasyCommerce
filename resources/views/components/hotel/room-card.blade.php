<div class="item my-2">
    <div class="offer-card mb-4 h-100">
        <a href="{{ url('hotel/room/' . $room->id . '/detail') }}">
            <img class="card-img-top"
                 src="{{ asset('storage/' . ($room->image ?? 'restaurant_frontend/default-image.png')) }}"
                 alt="{{ $room->room_type }}"
                 style="height:200px; object-fit:cover;"
                 loading="lazy">
        </a>
        <div class="card-body">
            <h5 class="card-title">{{ $room->room_type }} (No: {{ $room->room_number }})</h5>
            <p class="card-text">
                Floor: {{ $room->floor }}<br>
                Guests: {{ $room->total_adult + $room->total_child + $room->total_infant }}<br>
                Capacity: {{ $room->capacity }}<br>
                Price: <strong>{{ $room->price }} ETB</strong><br>
                <span class="{{ $room->is_available ? 'text-primary' : 'text-danger' }}">{{ $room->is_available ? 'Available' : 'Not Available' }}</span>
            </p>
            <p class="card-text">{{ \Illuminate\Support\Str::limit($room->description, 60) }}</p>
            <div><strong>Amenities:</strong><br>
                @foreach ($room->amenities as $amenity)
                    <span class="badge bg-primary">{{ $amenity->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
