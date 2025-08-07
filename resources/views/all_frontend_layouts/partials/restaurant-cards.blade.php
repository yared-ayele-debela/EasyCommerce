
@foreach ($auto_restaurants as $restaurant)

    <x-restaurant-card :restaurant="$restaurant" />
@endforeach
