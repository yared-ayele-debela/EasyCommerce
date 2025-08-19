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
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 20px;
        }

        .ecom-carousel {
            position: relative;
            width: 100%;
            max-width: 1800px;
            overflow: hidden;
            border-radius: 10px;
            /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); */
            background-color: #fff;
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
            /* 3 items for banners */
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

        .ecom-category img,
        .ecom-product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
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
            background-color: rgba(105, 228, 67, 0.7);
            color: #fff;
            border: none;
            padding: 12px;
            cursor: pointer;
            font-size: 1.3em;
            transition: background-color 0.3s ease;
            z-index: 10;
            border-radius: 5px;
        }

        .ecom-nav-btn:hover {
            background-color: rgba(64, 219, 43, 0.9);
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
            .ecom-banner {
                flex: 0 0 100%;
                min-width: 150px;
            }

            .ecom-category {
                flex: 0 0 calc(100% / 2);
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
            padding: 15px;
            text-align: center;
        }

        .product-name {
            font-size: 1.2em;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
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
            padding: 10px;
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
    <div class="ecom-carousel ecom-banner-carousel" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-banner-prev" aria-label="Previous Banner">&lt;</button>
        <div class="ecom-custom-banners">
            @foreach($banners as $banner)
                @include('components.sample.banner-card', ['banner' => $banner])
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-banner-next" aria-label="Next Banner">&gt;</button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Shop by Category</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div class="ecom-carousel ecom-category-carousel" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-category-prev" aria-label="Previous Category">&lt;</button>
        <div class="ecom-custom-categories">
            @foreach($categories as $category)
                @include('components.sample.category-card', ['category' => $category])
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-category-next" aria-label="Next Category">&gt;</button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Featured Products</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div class="ecom-carousel ecom-featured-products" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-featured-prev" aria-label="Previous Product">&lt;</button>
        <div class="ecom-custom-products">
            @foreach($most_popular_products as $product)
                <div class="ecom-product">
                    @include('components.sample.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-featured-next" aria-label="Next Product">&gt;</button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Latest Products</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div class="ecom-carousel ecom-latest-products" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-latest-prev" aria-label="Previous Product">&lt;</button>
        <div class="ecom-custom-products">
            @foreach($latest_products as $product)
                <div class="ecom-product">
                    @include('components.sample.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-latest-next" aria-label="Next Product">&gt;</button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Discounted Products</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div class="ecom-carousel ecom-discounted-products" tabindex="0">
        <button class="ecom-nav-btn ecom-prev ecom-discounted-prev" aria-label="Previous Product">&lt;</button>
        <div class="ecom-custom-products">
            @foreach($products as $product)
                <div class="ecom-product">
                    @include('components.sample.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
        <button class="ecom-nav-btn ecom-next ecom-discounted-next" aria-label="Next Product">&gt;</button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">All Products</h4>
        <a href="#" class="btn btn-sm btn-success">All</a>
    </div>
    <div id="product-list" class="row ecom-carousel">
        @include('aaa.partials.product-cards', ['auto_scroll_products' => $auto_scroll_products])
    </div>

    @if($auto_scroll_products->hasMorePages())
        <div class="text-center my-3">
            <button id="load-more-btn" data-next-page="{{ $auto_scroll_products->nextPageUrl() }}" class="btn btn-primary">
                Load More
            </button>
        </div>
    @endif


     <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">All Restaurants</h4>
       <a href="{{ url('restaurants') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-funnel"></i> Filter Restaurants
        </a>
    </div>

    <div id="auto-restaurant-container" class="row ecom-carousel py-3">
        @include('all_frontend_layouts.partials.restaurant-cards')
    </div>

    <div class="row d-flex justify-content-center align-items-center">
    <div class="col-md-6 text-center">
        <button onclick="loadMoreRestaurants()" class="btn btn-primary my-3 text-center">
            <i class="bi bi-arrow-counterclockwise"></i> Load More
        </button>
        <div id="restaurant_loading" class="my-2 text-muted" style="display: none;">Loading...</div>
    </div>
</div>

    <div class="text-center my-1" id="restaurant_loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('restaurant_frontend/assets/js/index.js') }}"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
let pages = 1;
let loadings = false;
function loadMoreRestaurants() {
    if (loadings) return;
    loadings = true;
    $('#restaurant_loading').show();
    pages++;

    $.ajax({
        url: "{{ route('fetch.restaurants') }}?page=" + pages,
        type: "GET",
        success: function(data) {
            if (data.trim().length === 0) {
                $(window).off('scroll');
                $('#restaurant_loading').html('<p class="text-muted">No more restaurants.</p>');
                return;
            }

            $('#auto-restaurant-container').append(data);
            $('#restaurant_loading').hide();
            loadings = false;

                updateRestaurantDistances();
        },
        error: function() {
            $('#restaurant_loading').html('<p class="text-danger">Something went wrong.</p>');
        }
    });
}

$(window).on('scroll', function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
        loadMoreRestaurants();
    }
});

</script>
</body>

</html>
