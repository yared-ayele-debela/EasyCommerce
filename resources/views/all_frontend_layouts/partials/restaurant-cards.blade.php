@php
    // Example: Calculate distance/time from user (replace with actual logic)

     $userLat = session('user_lat', 9.03); // fallback value
     $userLng = session('user_lng', 38.74);

    function haversine($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
@endphp

@foreach ($auto_restaurants as $restaurant)
    @php
        $distance = round(haversine($userLat, $userLng, $restaurant->latitude, $restaurant->longitude), 1);
        $carSpeedKmPerHour = 40; // average car speed
        $time = ceil(($distance / $carSpeedKmPerHour) * 60); // in minutes
    @endphp

    <x-restaurant-card :restaurant="$restaurant" :distance="$distance" :time="$time" />
@endforeach
