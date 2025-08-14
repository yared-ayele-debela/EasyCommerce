<?php

namespace App\Providers;

use App\Listeners\SyncCartSessionToDatabase;
use App\Models\Advertisement;
use App\Models\Blogs;
use App\Models\Group;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\HotelSlider;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\SliderBanner;
use App\Models\Room;
use App\Models\Vendor;
use App\Observers\AdvertisementObserver;
use App\Observers\BlogObserver;
use App\Observers\GroupObserver;
use App\Observers\HotelCategoryObserver;
use App\Observers\HotelObserver;
use App\Observers\HotelSliderObserver;
use App\Observers\Restaurant\CategoryObserver;
use App\Observers\Restaurant\ProductObserver;
use App\Observers\Restaurant\RestaurantObserver;
use App\Observers\Restaurant\SliderBannerObserver;
use App\Observers\RoomObserver;
use App\Observers\VendorObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class=>[
            SyncCartSessionToDatabase::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
        HotelCategory::observe(HotelCategoryObserver::class);
        HotelSlider::observe(HotelSliderObserver::class);
        Advertisement::observe(AdvertisementObserver::class);
        Room::observe(RoomObserver::class);
        Hotel::observe(HotelObserver::class);
        // Restaurant Observers
        SliderBanner::observe(SliderBannerObserver::class);
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        Restaurant::observe(RestaurantObserver::class);
        // Blog Observers
        Blogs::observe(BlogObserver::class);
        // Vendor Observers
        Vendor::observe(VendorObserver::class);
            Group::observe(GroupObserver::class);

                \App\Models\Category::observe(classes: \App\Observers\Ecommerce\CategoryObserver::class);
    \App\Models\Product::observe(\App\Observers\Ecommerce\ProductObserver::class);


    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
