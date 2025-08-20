<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('restaurant_frontend/assets/css/index.css') }}">
    <title>E-commerce with Banner Slider</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #ffffff !important;
            min-height: 100vh;
        }

        .ecom-carousel {
            position: relative;
            width: 100%;
            max-width: 1800px;
            overflow: hidden;
            border-radius: 10px;
            /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #f2fcf1; */
            margin-bottom: 20px;
        }

        .ecom-banner-carousel {
            margin-top: 20px;
        }

        .ecom-custom-banners,
        .ecom-custom-categories,
        .ecom-custom-products {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .ecom-banner,
        .ecom-category,
        .ecom-product {
            flex: 0 0 calc(100% / 3);
            min-width: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ecom-category {
            flex: 0 0 calc(100% / 9);
            /* 4 items for categories */
        }

        .ecom-product {
            flex: 0 0 calc(100% / 8);
            /* 5 items for products on desktop */
        }


        .ecom-banner img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            border: 1px solid #eee;
        }


        .ecom-product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            border: 1px solid #eee;
        }

        .ecom-category img {
            height: 130px;
            width: 130px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 12px;
            border: 1px solid #eee;
        }



        .ecom-banner span,
        .ecom-category span,
        .ecom-product span {
            font-size: 1.1em;
            /* color: #333; */
            text-align: center;
            /* font-weight: 600; */
            text-transform: capitalize;
        }

        .ecom-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(244, 245, 243, 0.7);
            color: #0d690a;

            border: 1px solid #dffade;
            padding: 12px;
            cursor: pointer;
            font-size: 1.3em;
            transition: background-color 0.3s ease;
            z-index: 10;
            border-radius: 5px;
        }

        .ecom-nav-btn:hover {
            background-color: rgba(131, 250, 115, 0.9);
        }

        .ecom-prev {
            left: 5px;
        }

        .ecom-next {
            right: 5px;
        }

        .ecom-nav-btn.ecom-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        h2 {
            font-size: 1.8em;
            color: #333;
            margin: 20px 0;
            text-align: center;
        }

        @media (max-width: 992px) {

            .ecom-banner,
            .ecom-category,
            .ecom-product {
                flex: 0 0 calc(100% / 3);
            }

            .ecom-category img {
                height: 130px;
                width: 110px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 12px;
                border: 1px solid #eee;
            }

            .ecom-banner img {
                height: 220px;
            }

            .ecom-category img,
            .ecom-product img {
                height: 150px;
            }
        }

        @media (max-width: 768px) {
            .ecom-banner {
                flex: 0 0 calc(100% / 2);
            }

            .ecom-category img {
                height: 130px;
                width: 110px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 12px;
                border: 1px solid #eee;
            }

            .ecom-category {
                flex: 0 0 calc(100% / 2);
            }

            .ecom-product {
                flex: 0 0 calc(100% / 2);
                /* 2 items for products on small screens */
            }

            .ecom-banner img {
                height: 180px;
            }

            .ecom-category img,
            .ecom-product img {
                height: 130px;
            }

            .ecom-banner span,
            .ecom-category span,
            .ecom-product span {
                font-size: 1.1em;
            }
        }

        @media (max-width: 576px) {
            .ecom-category img {
                height: 130px;
                width: 100px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 12px;
                border: 1px solid #eee;
            }

            .ecom-banner {
                flex: 0 0 100%;
                min-width: 150px;
            }

            .ecom-category {
                flex: 0 0 calc(100% / 3);
                min-width: 150px;

            }

            .ecom-product {
                flex: 0 0 calc(100% / 2);
                /* 2 items for products on small screens */
                min-width: 150px;

            }

            .ecom-banner img {
                height: 150px;
            }

            .ecom-category img,
            .ecom-product img {
                height: 100px;
            }

            .ecom-nav-btn {
                padding: 8px;
                font-size: 1em;
            }
        }

        .product-card {
            position: relative;
            width: 100%;
            max-width: 300px;
            background-color: #fff;
            border-radius: 10px;
            border: 1px solid #b2f7b2;
            box-shadow: 0 2px 10px rgb(204, 252, 204) !important;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .product-info {
            padding: 10px;
            text-align: center;
        }

        .product-name {
            font-size: 1em;
            font-weight: 600;
            color: #696868;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        .product-pricing {
            margin-bottom: 15px;
        }

        .old-price {
            font-size: 0.9em;
            color: #646363;
            text-decoration: line-through;
            margin-right: 10px;
        }

        .new-price {
            font-size: 1.3em;
            color: #4dc415;
            font-weight: 800;
        }

        .action-buttons {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(141, 250, 113, 0.7);
            display: flex;
            justify-content: space-around;
            padding: 5px;
            transform: translateY(100%);
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover .action-buttons {
            transform: translateY(0);
        }

        .action-btn {
            background-color: transparent;
            border: none;
            color: #fff;
            font-size: 1.2em;
            padding: 8px;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .action-btn:hover {
            color: #51ff00;
            transform: scale(1.2);
        }

        .action-btn:focus {
            outline: none;
        }

        @media (max-width: 576px) {
            .product-card {
                max-width: 250px;
            }

            .product-image {
                height: 150px;
            }

            .product-name {
                font-size: 1em;
            }

            .old-price {
                font-size: 0.8em;
            }

            .new-price {
                font-size: 1em;
            }

            .action-btn {
                font-size: 1em;
                padding: 6px;
            }
        }
    </style>
</head>

<body>
    {{-- Banner Slider --}}
    .<div class="container-fluid">
        <div class="container py-2">
            <div class="row d-flex justify-content-center align-items-center pt-3">
                <div class="custom-nav-container">
                    <nav class="nav justify-content-between custom-nav p-2">
                        <a href="{{ url('/') }}"
                            class="custom-switch nav-link text-white fw-bold {{ request()->is('/') ? 'nav-active' : '' }}">Order
                            Food</a>
                        <a href="{{ url('/sample.hotel') }}"
                            class="custom-switch nav-link text-dark fw-bold {{ request()->is('/sample.hotel') ? 'nav-active' : '' }}">Reserve
                            Hotel</a>
                        <a href="{{ url('/ecommerce') }}"
                            class="custom-switch nav-link text-dark fw-bold {{ request()->is('ecommerce') ? ' text-white nav-active' : '' }}">Buy
                            Goods</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="ecom-carousel ecom-banner-carousel" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-banner-prev" aria-label="Previous Banner"><i
                    class="bi bi-arrow-left-short "></i></button>
            <div class="ecom-custom-banners">
                @foreach($banners as $banner)
                    @include('components.sample.banner-card', ['banner' => $banner])
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-banner-next" aria-label="Next Banner"><i
                    class="bi bi-arrow-right-short "></i>
            </button>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Hotel by Category</h4>
            <a href="#" class="btn btn-sm btn-success">All</a>
        </div>
        <div class="ecom-carousel ecom-category-carousel" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-category-prev" aria-label="Previous Category"><i
                    class="bi bi-arrow-left-short "></i>
                </button>
            <div class="ecom-custom-categories">
                @foreach($categories as $category)
                    <div class="category-item">
                        <a href="{{ url('hotel/categories/' . $category->id) }}">
                            <img src="{{ asset('storage/' . $category->image) ?? asset('restaurant_frontend/default-image.png') }}"
                                class="p-2 shadow restaurant-category-image" style="border:4px solid rgb(162, 159, 159);"
                                alt="{{ $category->name ?? '' }}" loading="lazy">
                            <p class="text-dark text-center">{{ $category->name ?? '' }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-category-next" aria-label="Next Category"><i
                    class="bi bi-arrow-right-short "></i>
            </button>
        </div>
        @if($after_latest_rooms)
            <div class="row justify-content-center my-3">
                <div class="col-12 col-md-12">
                    <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                        <a href="{{ $after_latest_rooms->adv_links ?? '' }}" target="_blank">
                            <img src="{{ asset('storage/' . $after_latest_rooms->image) }}"
                                alt="{{ $after_latest_rooms->title ?? '' }}" class="img-fluid w-100 d-block"
                                style="max-height: 250px; ">
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Rooms</h4>
            <a href="#" class="btn btn-sm btn-success">All</a>
        </div>
        <div class="ecom-carousel ecom-rooms-products" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-rooms-prev" aria-label="Previous Product"><i
                    class="bi bi-arrow-left-short "></i></button>
            <div class="ecom-custom-products">
                @foreach($rooms as $room)
                        <div class="offer-card h-100">
                        @if($room->image)
                            <a href="{{ url('hotel/room/' . $room->id . '/detail') }}">
                                <img class="card-img-top" src="{{ asset('storage/' . $room->image) }}" loading="lazy"
                                    alt="{{ $room->room_type }}" style="height:200px; object-fit:cover;">
                        @else
                                <img class="card-img-top" src="{{ asset('restaurant_frontend/default-image.png')}}"
                                    alt="{{ $room->room_type }}">
                            @endif
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $room->room_type }} (No: {{ $room->room_number }})</h5>
                            <p class="card-text">
                                Floor: {{ $room->floor }}<br>
                                Guests: {{ $room->total_adult + $room->total_child + $room->total_infant }}<br>
                                Capacity: {{ $room->capacity }}<br>
                                Price: <strong>{{ $room->price }} ETB</strong><br>
                                <span
                                    class="{{ $room->is_available ? 'text-primary' : 'text-danger'}}">{{ $room->is_available ? 'Available' : 'Not Available'}}</span>
                            </p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($room->description, 60) }}
                            </p>
                            <div><strong>Amenities:</strong><br>
                                @foreach ($room->amenities as $amenity)
                                    <span class="badge bg-primary">{{ $amenity->name}}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-rooms-next" aria-label="Next Product"><i
                class="bi bi-arrow-right-short "></i></button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Discounted Hotels</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div class="ecom-carousel ecom-latest-products" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-latest-prev" aria-label="Previous Product"><i
                class="bi bi-arrow-left-short "></i></button>
        <div class="ecom-custom-products">
            @foreach ($hotels as $hotel)
                <div class="offer-card h-100">
                    <a href="{{ url('hotel/' . $hotel->id . '/detail') }}">
                        @if($hotel->banner_image)
                            <img class="card-img-top img-fluid" src="{{ asset('storage/' . $hotel->banner_image) }}"
                                alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;" loading="lazy">
                        @else
                            <img class="card-img-top img-fluid" src="{{ asset('restaurant_frontend/default-image.png') }}"
                                alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                    </a>
                    <div class="card-body">
                        <span class="badge bg-primary mt-0">{{ $hotel->category->name }}</span>
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <p class="card-text">
                            <a href="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}"
                                target="_blank" class="small text-muted mb-2">
                                Location: {{ $hotel->state }}, {{ $hotel->city }}, {{ $hotel->location }}
                            </a>
                            <br>
                            Price per Night: <strong>{{ $hotel->price_per_night }} ETB</strong><br>
                            Rating: <strong>{{ $hotel->rating }} <i class="bi bi-star-fill text-primary"></i></strong><br>
                        </p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($hotel->description, 60) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-latest-next" aria-label="Next Product"><i
                class="bi bi-arrow-right-short "></i></button>
    </div>

    @if($after_discount_hotels)
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-12">
                <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                    <a href="{{ $after_discount_hotels->adv_links ?? '' }}" target="_blank">
                        <img src="{{ asset('storage/' . $after_discount_hotels->image) }}"
                            alt="{{ $after_discount_hotels->title ?? '' }}" class="img-fluid w-100 d-block"
                            style="max-height: 250px; ">
                    </a>
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Latest Hotels</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div class="ecom-carousel ecom-discounted-products" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-discounted-prev" aria-label="Previous Product"><i
                class="bi bi-arrow-left-short "></i></button>
        <div class="ecom-custom-products">
            @foreach ($hotels as $hotel)
                <div class="offer-card h-100">
                    <a href="{{ url('hotel/' . $hotel->id . '/detail') }}">
                        @if($hotel->banner_image)
                            <img class="card-img-top img-fluid" src="{{ asset('storage/' . $hotel->banner_image) }}"
                                alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;" loading="lazy">
                        @else
                            <img class="card-img-top img-fluid" src="{{ asset('restaurant_frontend/default-image.png') }}"
                                alt="{{ $hotel->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                    </a>
                    <div class="card-body">
                        <span class="badge bg-primary mt-0">{{ $hotel->category->name }}</span>
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <p class="card-text">
                            <a href="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}"
                                target="_blank" class="small text-muted mb-2">
                                Location: {{ $hotel->state }}, {{ $hotel->city }}, {{ $hotel->location }}
                            </a>
                            <br>
                            Price per Night: <strong>{{ $hotel->price_per_night }} ETB</strong><br>
                            Rating: <strong>{{ $hotel->rating }} <i class="bi bi-star-fill text-primary"></i></strong><br>
                        </p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($hotel->description, 60) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-discounted-next" aria-label="Next Product"><i
                class="bi bi-arrow-right-short "></i></button>
    </div>

    @if($after_latest_hotels)
        <div class="row justify-content-center my-2">
            <div class="col-12 col-md-12">
                <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                    <a href="{{ $after_latest_hotels->adv_links ?? '' }}" target="_blank">
                        <img src="{{ asset('storage/' . $after_latest_hotels->image) }}"
                            alt="{{ $after_latest_hotels->title ?? '' }}" class="img-fluid w-100 d-block"
                            style="max-height: 250px; ">
                    </a>
                </div>
            </div>
        </div>
    @endif




    @include('all_frontend_layouts.partial_index')

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('restaurant_frontend/assets/js/index.js') }}"></script>

</body>

</html>
