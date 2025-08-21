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

       
    </style>
</head>

<body>
    {{-- Banner Slider --}}
    <div class="container-fluid">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 mb-2">
                    <div class="card border border-1 shadow-sm">
                        <div class="card-header bg-white pb-2 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"> <i class="bi bi-list text-primary me-2 "></i>Categories</h5>
                            <div id="categoryToggle" role="button">
                                <i class="bi bi-toggle-on text-primary" style="font-size: 20px;"></i>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush category-list d-none d-lg-block" id="categoryList">
                            @foreach ($group as $group)
                                @if(count($group['categories']) > 0)
                                    <li class="list-group-item position-relative">
                                        <i class=" bi bi-bag-dash me-2 text-primary"></i> {{$group['name']}}
                                        <span
                                            class="badge bg-primary rounded-pill float-end">{{ $group['categories']->count() }}</span>
                                        <ul class="subcategory-dropdown">
                                            <div class="row">
                                                @foreach ($group['categories'] as $category)
                                                    <div class="col-4">
                                                        <li>
                                                            <a
                                                                href="{{ url('ecommerce/category/' . encrypt($category->id)) }}">{{ $category['name'] }}</a>
                                                            <ul>
                                                                @foreach ($category['subcategories'] as $subcategory)
                                                                    <li>
                                                                        <a
                                                                            href="{{ url('ecommerce/category/' . encrypt($category->id)) }}">{{ $subcategory['name'] }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 mb-2">
                    <div id="promoCarousel" class="carousel slide carousel-fade card shadow-sm" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($banners as $index => $banner)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="d-flex align-items-center banner-box {{ $index % 2 === 0 ? 'text-white' : 'text-dark' }}"
                                        style="border-radius:8px; background: url('{{ asset('storage/banner/' . $banner['image']) }}') center center / cover no-repeat;">
                                        <div class="container py-5 px-4">
                                            <h1 class="display-6 fw-bold">{{ $banner['title'] ?? 'Promotion' }}</h1>
                                            <p class="lead">{{ $banner['alt'] ?? 'Don’t miss out on our latest offers!' }}
                                            </p>
                                            @if (!empty($banner['link']))
                                                <a href="{{ $banner['link'] }}"
                                                    class="btn {{ $index % 2 === 0 ? 'btn-light' : 'btn-dark' }} btn-lg rounded-pill mt-2 shadow-sm">
                                                    Shop Now <i class="bi bi-arrow-right ms-2"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-2"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
                 @if ($featured_flash_deal && $flash_deal_products->count())
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
                            <h3 class="fw-bold mb-0">
                                <i class="bi bi-fire text-danger me-2"></i> Flash Sales
                            </h3>

                            <!-- This wrapper keeps countdown + button in one row -->
                            <div class="d-flex align-items-center gap-3 flex-wrap">

                                <!-- All Button -->

                                <!-- Countdown Box -->
                                <div
                                    class="d-flex gap-3 text-center bg-primary px-3 py-2 rounded-2 order-1 order-md-2 shadow-sm">
                                    <div>
                                        <strong id="days" class="text-white fs-5">03</strong>
                                        <div class="small text-white">Days</div>
                                    </div>
                                    <div>
                                        <strong id="hours" class="text-white fs-5">23</strong>
                                        <div class="small text-white">Hours</div>
                                    </div>
                                    <div>
                                        <strong id="minutes" class="text-white fs-5">19</strong>
                                        <div class="small text-white">Minutes</div>
                                    </div>
                                    <div>
                                        <strong id="seconds" class="text-white fs-5">56</strong>
                                        <div class="small text-white">Seconds</div>
                                    </div>
                                    <div>
                                    <a href="{{ route('ecommerce.products.flash.sales') }}"
                                        class="btn btn-outline-primary text-white order-2 order-md-1 fw-semibold">
                                        View All
                                    </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="ecom-carousel ecom-flashdeal-products" tabindex="0">
                            <button class="ecom-nav-btn ecom-prev ecom-flashdeal-prev" aria-label="Previous Product"><i
                                    class="bi bi-arrow-left-short "></i></button>
                            <div class="ecom-custom-products">
                                @foreach ($flash_deal_products as $item)
                                    @php $product = $item->product; @endphp
                                    <div class="ecom-product">
                                        @include('components.sample.ecommerce.product-card', ['product' => $product])
                                    </div>
                                @endforeach
                            </div>
                            <button class="ecom-nav-btn ecom-next ecom-flashdeal-next" aria-label="Next Product"><i
                                    class="bi bi-arrow-right-short "></i>
                            </button>
                        </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const endTime = new Date("{{ \Carbon\Carbon::parse($featured_flash_deal->end_date)->format('Y-m-d H:i:s') }}").getTime();
                            function updateCountdown() {
                                const now = new Date().getTime();
                                const distance = endTime - now;

                                if (distance < 0) {
                                    document.getElementById("countdown").innerHTML = "⏰ Deal ended";
                                    return;
                                }
                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                document.getElementById("days").textContent = String(days).padStart(2, '0');
                                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');

                            }

                            updateCountdown();
                            setInterval(updateCountdown, 1000);
                        });

                    </script>
            @endif
        <div class="d-flex justify-content-between align-items-center my-3">
            <h4 class="mb-0">Categories</h4>
            <a href="#" class="btn btn-sm btn-success">All</a>
        </div>
        <div class="ecom-carousel ecom-category-carousel" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-category-prev" aria-label="Previous Category"><i
                    class="bi bi-arrow-left-short "></i> </button>
            <div class="ecom-custom-categories">
                @foreach ($getCategory as $category)
                    @include('components.sample.ecommerce.category-card', ['category' => $category])
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-category-next" aria-label="Next Category"><i
                    class="bi bi-arrow-right-short "></i></button>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Featured Products</h4>
            <form action="{{ route('ecommerce.products.featured') }}" method="GET">
                <input type="hidden" name="name" value="featured_products">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
        <div class="ecom-carousel ecom-featured-products" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-featured-prev" aria-label="Previous Product"><i
                    class="bi bi-arrow-left-short "></i></button>
            <div class="ecom-custom-products">
                @foreach($isfeatured as $product)
                    <div class="ecom-product">
                        @include('components.sample.ecommerce.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-featured-next" aria-label="Next Product"><i
                    class="bi bi-arrow-right-short "></i>
            </button>
        </div>

        @if($ad_after_featured_products)
            <div class="row justify-content-center">
                <div class="col-12 col-md-12">
                    <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                        <a href="{{ $ad_after_featured_products->adv_links ?? '' }}" target="_blank">
                            <img src="{{ asset('storage/' . $ad_after_featured_products->image) }}"
                                alt="{{ $ad_after_featured_products->title ?? '' }}" class="img-fluid w-100 d-block"
                                style="max-height: 250px; ">
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center my-3">
            <h4 class="mb-0">Latest Products</h4>
            <form action="{{ route('ecommerce.products.latest') }}" method="GET">
                <input type="hidden" name="name" value="latest_products">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
        <div class="ecom-carousel ecom-latest-products" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-latest-prev" aria-label="Previous Product"><i
                    class="bi bi-arrow-left-short "></i></button>
            <div class="ecom-custom-products">
                @foreach($new_products as $product)
                    <div class="ecom-product">
                        @include('components.sample.ecommerce.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-latest-next" aria-label="Next Product"><i
                    class="bi bi-arrow-right-short "></i>
            </button>
        </div>

        <x-fixed-banner :image="$fixbanners[0]['image'] ?? ''" :link="$fixbanners[0]['link'] ?? '#'" />

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Discounted Products</h4>
            <form action="{{ route('ecommerce.products.discounted') }}" method="GET">
                <input type="hidden" name="name" value="discounted">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
        <div class="ecom-carousel ecom-discounted-products" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-discounted-prev" aria-label="Previous Product"><i
                    class="bi bi-arrow-left-short "></i></button>
            <div class="ecom-custom-products">
                @foreach($discountedproduct as $product)
                    <div class="ecom-product">
                        @include('components.sample.ecommerce.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-discounted-next" aria-label="Next Product"><i
                    class="bi bi-arrow-right-short "></i>
            </button>
        </div>

        @if($ad_after_discounted_products)
            <div class="row justify-content-center">
                <div class="col-12 col-md-12">
                    <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                        <a href="{{ $ad_after_discounted_products->adv_links ?? '' }}" target="_blank">
                            <img src="{{ asset('storage/' . $ad_after_discounted_products->image) }}"
                                alt="{{ $ad_after_discounted_products->title ?? '' }}" class="img-fluid w-100 d-block"
                                style="max-height: 250px; ">
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center my-3">
            <h4 class="mb-0">Our Vendors</h4>
            <a href="{{ route('ecommerce.vendors.index') }}" class="text-dark" id="days">All</a>
        </div>
        <div class="ecom-carousel ecom-vendor-products" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-vendor-prev" aria-label="Previous Product"><i
                    class="bi bi-arrow-left-short "></i></button>
            <div class="ecom-custom-products">
                @foreach ($allvendor as $vendor)
                    <div class="ecom-vendor">
                        <x-vendor-card :vendor="$vendor" :review-count="$vendorRatingsCount[$vendor->id] ?? 0" />
                    </div>
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-vendor-next" aria-label="Next Product"><i
                    class="bi bi-arrow-right-short "></i>
            </button>
        </div>


        @if($ad_after_vendors)
            <div class="row justify-content-center">
                <div class="col-12 col-md-12">
                    <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                        <a href="{{ $ad_after_vendors->adv_links ?? '' }}" target="_blank">
                            <img src="{{ asset('storage/' . $ad_after_vendors->image) }}"
                                alt="{{ $ad_after_vendors->title ?? '' }}" class="img-fluid w-100 d-block"
                                style="max-height: 250px; ">
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center my-3">
            <h4 class="mb-0">Brands</h4>
            <div class="d-flex gap-3 text-center">
            </div>
        </div>
        <div class="ecom-carousel ecom-brand-carousel" tabindex="0">
            <button class="ecom-nav-btn ecom-prev ecom-brand-prev" aria-label="Previous Category"><i
                    class="bi bi-arrow-left-short "></i> </button>
            <div class="ecom-custom-categories">
                @foreach ($allbrands as $brand)
                    @include('components.sample.ecommerce.brand-card', ['brand' => $brand])
                @endforeach
            </div>
            <button class="ecom-nav-btn ecom-next ecom-brand-next" aria-label="Next Category"><i
                    class="bi bi-arrow-right-short "></i></button>
        </div>

        <x-fixed-banner :image="$fixbanners[1]['image'] ?? ''" :link="$fixbanners[1]['link'] ?? '#'" />


        <div class="d-flex justify-content-between align-items-center my-3">
            <h4 class=" mb-0">All Products</h4>

            <div class="d-flex gap-2">
                <a href="{{ url('ecommerce/products/search') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-funnel"></i> Filter Products
                </a>
            </div>
        </div>

        <div id="product-container" class="row g-4">
            @include('Ecommerce.products._product_card')
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6 text-center">
                <button onclick="loadMoreEcommerceProducts()"
                    class="btn btn-primary my-3 rounded rounded-1 text-center"><i
                        class="bi bi-arrow-counterclockwise"></i> Load More</button>
            </div>
        </div>
        <div class="text-center my-1" id="loading" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        function initializeFlashCountdowns() {
            const countdowns = document.querySelectorAll('.flash-countdown');

            countdowns.forEach(el => {
                const endTime = parseInt(el.dataset.end) * 1000; // milliseconds
                const countdownText = el.querySelector('.countdown-text');

                const interval = setInterval(() => {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance <= 0) {
                        countdownText.innerText = 'Deal Ended';
                        clearInterval(interval);
                        return;
                    }

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownText.innerText = `${hours}h ${minutes}m ${seconds}s`;
                }, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', initializeFlashCountdowns);

        let page = 1;
        let loading = false;

        function loadMoreEcommerceProducts() {
            if (loading) return;
            loading = true;
            $('#loading').show();
            page++;

            $.ajax({
                url: "{{ route('ecommerce.products.all') }}?page=" + page
                , type: "GET"
                , success: function (data) {
                    if (data.trim().length === 0) {
                        $(window).off('scroll');
                        $('#loading').html('<p class="text-muted">No more products.</p>');
                        return;
                    }
                    $('#product-container').append(data);
                    $('#loading').hide();
                    loading = false;
                }
                , error: function () {
                    $('#loading').html('<p class="text-danger">Something went wrong.</p>');
                }
            });
        }

        $(window).on('scroll', function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                loadMoreProducts();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {

            function setupCarousel(carouselSelector, prevBtnSelector, nextBtnSelector, itemsSelector, desktopItems, mobileItems) {
                const carousel = document.querySelector(carouselSelector);
                const items = document.querySelector(itemsSelector);
                const prevBtn = document.querySelector(prevBtnSelector);
                const nextBtn = document.querySelector(nextBtnSelector);

                if (!carousel || !items || !prevBtn || !nextBtn) {
                    console.error('Required carousel elements not found');
                    return;
                }

                let itemWidth = 0;
                let currentIndex = 0;
                let totalItems = items.children.length;
                let visibleItems = 0;

                console.log('Total items:', totalItems);

                function updateCarousel() {
                    const carouselWidth = carousel.offsetWidth;
                    const isMobile = window.innerWidth <= 768;
                    visibleItems = isMobile && mobileItems ? mobileItems : (desktopItems || Math.floor(carouselWidth / items.children[0].offsetWidth));
                    itemWidth = items.children[0].offsetWidth; // Use actual item width
                    slideTo(currentIndex);
                }

                function updateButtons() {
                    prevBtn.classList.toggle('ecom-disabled', currentIndex === 0);
                    nextBtn.classList.toggle('ecom-disabled', currentIndex >= totalItems - visibleItems);
                }

                function slideTo(index) {
                    if (index < 0 || index > totalItems - visibleItems) return;
                    currentIndex = index;
                    items.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                    updateButtons();
                }

                prevBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    console.log('Previous button clicked', currentIndex);
                    if (currentIndex > 0) {
                        slideTo(currentIndex - 1);
                    }
                });

                nextBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    console.log('Next button clicked', currentIndex);
                    if (currentIndex < totalItems - visibleItems) {
                        slideTo(currentIndex + 1);
                    }
                });

                window.addEventListener('resize', () => {
                    updateCarousel();
                });

                carousel.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') prevBtn.click();
                    if (e.key === 'ArrowRight') nextBtn.click();
                });

                let touchStartX = 0;
                carousel.addEventListener('touchstart', (e) => {
                    touchStartX = e.touches[0].clientX;
                });

                carousel.addEventListener('touchend', (e) => {
                    const touchEndX = e.changedTouches[0].clientX;
                    const swipeDistance = touchStartX - touchEndX;
                    if (Math.abs(swipeDistance) > 50) {
                        if (swipeDistance > 0) nextBtn.click();
                        else if (swipeDistance < 0) prevBtn.click();
                    }
                });

                updateCarousel();
                updateButtons();
            }

            // Initialize carousels
            setupCarousel('.ecom-category-carousel', '.ecom-category-prev', '.ecom-category-next', '.ecom-category-carousel .ecom-custom-categories', 9, 2);
            setupCarousel('.ecom-brand-carousel', '.ecom-brand-prev', '.ecom-brand-next', '.ecom-brand-carousel .ecom-custom-categories', 9, 2);
            setupCarousel('.ecom-featured-products', '.ecom-featured-prev', '.ecom-featured-next', '.ecom-featured-products .ecom-custom-products', 8, 2);
            setupCarousel('.ecom-flashdeal-products', '.ecom-flashdeal-prev', '.ecom-flashdeal-next', '.ecom-flashdeal-products .ecom-custom-products', 8, 2);
            setupCarousel('.ecom-vendor-products', '.ecom-vendor-prev', '.ecom-vendor-next', '.ecom-vendor-products .ecom-custom-products', 4, 2);
            setupCarousel('.ecom-latest-products', '.ecom-latest-prev', '.ecom-latest-next', '.ecom-latest-products .ecom-custom-products', 8, 2);
            setupCarousel('.ecom-discounted-products', '.ecom-discounted-prev', '.ecom-discounted-next', '.ecom-discounted-products .ecom-custom-products', 8, 2);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryItems = document.querySelectorAll('#categoryList > li');
            categoryItems.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.stopPropagation();

                    categoryItems.forEach(function (el) {
                        if (el !== item) {
                            el.classList.remove('active');
                        }
                    });

                    item.classList.toggle('active');
                });
            });

        });

        const toggleIcon = document.querySelector("#categoryToggle i");
        const categoryList = document.getElementById("categoryList");

        document.getElementById("categoryToggle").addEventListener("click", () => {
            categoryList.classList.toggle("d-none");
            toggleIcon.classList.toggle("bi-toggle-on");
            toggleIcon.classList.toggle("bi-toggle-off");
        });

    </script>
</body>

</html>
