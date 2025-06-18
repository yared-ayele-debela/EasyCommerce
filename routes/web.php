<?php

use App\Events\DeliveryManLocationUpdated;
use App\Events\MessageSent;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminActivityLogController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\AdminLoginInToVendorController;
use App\Http\Controllers\Admin\AdminResetController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\AdminWithdrawRequestController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\AdminController;
use App\Models\Restaurant\RestaurantRating;

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\FontendController;

use App\Http\Controllers\Admin\CmsController;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Product;

use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\AssingOrderToDeliveryBoy;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\Blog\BlogsCategoryController;
use App\Http\Controllers\Admin\Blog\BlogsCommmentController;
use App\Http\Controllers\Admin\Blog\BlogsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\Currency\CurrencyController;
use App\Http\Controllers\Admin\Currency\ExchangeRateController;
use App\Http\Controllers\Admin\CustomOrderController as AdminCustomOrderController;
use App\Http\Controllers\Admin\DeliveryMan\DeliveryManTypeController;
use App\Http\Controllers\Admin\DeliveryMan\DeliveryZoneController;
use App\Http\Controllers\Admin\DeliveryMan\VehicleTypeController;
use App\Http\Controllers\Admin\DeliveryManController;
use App\Http\Controllers\Admin\DeliveryManWithdrawController;
use App\Http\Controllers\Admin\DiscountManagementController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FastOrdersController as AdminFastOrdersController;
use App\Http\Controllers\Admin\FlashDealController;
use App\Http\Controllers\Admin\InvoiceSettingController;
use App\Http\Controllers\Admin\NewletterSubscriberController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OutOfStockProductController;
use App\Http\Controllers\Admin\PermissionCategoriesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProductTransferController;
use App\Http\Controllers\Admin\Reports\Charts\ChartController;
use App\Http\Controllers\Admin\Reports\Charts\OrderChartController;
use App\Http\Controllers\Admin\Reports\CustomReportController;
use App\Http\Controllers\Admin\Reports\OrderProductReportController;
use App\Http\Controllers\Admin\Reports\OrderReportController;
use App\Http\Controllers\Admin\Reports\ProductReportController;
use App\Http\Controllers\Admin\Reports\StockReportController;
use App\Http\Controllers\Admin\Reports\TransferStockProductReportController;
use App\Http\Controllers\Admin\Reports\UserReportController;
use App\Http\Controllers\Admin\Reports\VendorReportController;
use App\Http\Controllers\Admin\RolePermissions;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SalesUsersController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\ShippingZoneController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\StreetController;
use App\Http\Controllers\Admin\SubCityController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TipSettingsController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\Admin\TransferRequestController;
use App\Http\Controllers\Admin\Vendor\VendorBalanceController;
use App\Http\Controllers\Admin\Vendor\VendorWithdrawRequestController as VendorVendorWithdrawRequestController;
use App\Http\Controllers\Admin\WereHouseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController as ControllersCategoriesController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\Delivery\CustomOrderController as DeliveryCustomOrderController;
use App\Http\Controllers\Delivery\DeliveryBoyRolesController;
use App\Http\Controllers\Delivery\DeliveryManController as DeliveryDeliveryManController;
use App\Http\Controllers\Delivery\FastOrderController;
use App\Http\Controllers\Delivery\StockTransferProductController;
use App\Http\Controllers\FastOrdersController;
use App\Http\Controllers\Socail\AuthController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\VendorNotificationController;
use App\Http\Controllers\Admin\VendorWithdrawRequestController;
use App\Http\Controllers\Admin\WithdrawSettingController;
use App\Http\Controllers\Delivery\Ecommerce\GetLocationController;
use App\Http\Controllers\Delivery\OrderController as DeliveryOrderController;
use App\Http\Controllers\Delivery\WithdrawController;
use App\Http\Controllers\Ecommerce\Frontend\BlogController;
use App\Http\Controllers\Ecommerce\Frontend\CartController as FrontendCartController;
use App\Http\Controllers\Ecommerce\Frontend\CategoriesController as FrontendCategoriesController;
use App\Http\Controllers\Ecommerce\Frontend\CheckoutController as FrontendCheckoutController;
use App\Http\Controllers\Ecommerce\Frontend\CmsController as FrontendCmsController;
use App\Http\Controllers\Ecommerce\Frontend\CustomController;
use App\Http\Controllers\Ecommerce\Frontend\DeliveryAddressController;
use App\Http\Controllers\Ecommerce\Frontend\DirectCheckoutController;
use App\Http\Controllers\Ecommerce\Frontend\FilterProductController;
use App\Http\Controllers\Ecommerce\Frontend\FrontendController as EcommerceFrontendFrontendController;
use App\Http\Controllers\Ecommerce\Frontend\NewslettersController;
use App\Http\Controllers\Ecommerce\Frontend\OrderController as EcommerceFrontendOrderController;
use App\Http\Controllers\Ecommerce\Frontend\ProductRequestController;
use App\Http\Controllers\Ecommerce\Frontend\ProductsController;
use App\Http\Controllers\Ecommerce\Frontend\RatingController as EcommerceFrontendRatingController;
use App\Http\Controllers\Ecommerce\Frontend\RegisterDeliveryManController;
use App\Http\Controllers\Ecommerce\Frontend\VendorController as FrontendVendorController;
use App\Http\Controllers\Ecommerce\Frontend\VendorsController;
use App\Http\Controllers\Ecommerce\Frontend\WishlistController;
use App\Http\Controllers\Ecommerce\Vendor\VendorRegistrationController;
use App\Http\Controllers\Front\AddressController as FrontAddressController;
use App\Http\Controllers\Front\BlogsController as FrontBlogsController;
use App\Http\Controllers\Front\ChapaController;
use App\Http\Controllers\Front\FrontCmsController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PaypalController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Front\SpecialLinkController;
use App\Http\Controllers\Front\TrackYourOrderController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\VendorController as FrontVendorController;
use App\Http\Controllers\Hotel\Dashboard\AmenityController;
use App\Http\Controllers\Hotel\Dashboard\CouponController as DashboardCouponController;
use App\Http\Controllers\Hotel\Dashboard\DashboardController as DashboardDashboardController;
use App\Http\Controllers\Hotel\Dashboard\HotelAdminController;
use App\Http\Controllers\Hotel\Dashboard\HotelCategoryController;
use App\Http\Controllers\Hotel\Dashboard\HotelController;
use App\Http\Controllers\Hotel\Dashboard\HotelPhotoController;
use App\Http\Controllers\Hotel\Dashboard\HotelReviewController;
use App\Http\Controllers\Hotel\Dashboard\ReservationsController;
use App\Http\Controllers\Hotel\Dashboard\RoomController;
use App\Http\Controllers\Hotel\Dashboard\SliderBannerController as DashboardSliderBannerController;
use App\Http\Controllers\Hotel\Dashboard\VendorBalanceController as HotelDashboardVendorBalanceController;
use App\Http\Controllers\Hotel\Frontend\BookingController;
use App\Http\Controllers\Hotel\Frontend\CategoryController as HotelFrontendCategoryController;
use App\Http\Controllers\Hotel\Frontend\FrontendController as FrontendFrontendController;
use App\Http\Controllers\Hotel\Frontend\HotelController as FrontendHotelController;
use App\Http\Controllers\Hotel\Frontend\ReservationController;
use App\Http\Controllers\Hotel\Frontend\RoomController as FrontendRoomController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\NearbyDeliveryMenMapController;
use App\Http\Controllers\OrderRouteMapController;
use App\Http\Controllers\Restaurant\Dashboard\AssignOrderController;
use App\Http\Controllers\SalesUserAuth\DashboardController as SalesUserAuthDashboardController;
use App\Http\Controllers\SalesUserAuth\ForgotPasswordController;
use App\Http\Controllers\SalesUserAuth\LoginController as SalesUserAuthLoginController;
use App\Http\Controllers\SalesUserAuth\RegisterController;
use App\Http\Controllers\SalesUserAuth\ResetPasswordController;
use App\Http\Controllers\VendorController as ControllersVendorController;
use App\Livewire\AdminWithdrawRequest\AdminWithdrawRequest;
use App\Models\CustomOrder;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

use App\Models\SubCategory;
use App\Models\TransferRequest;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Restaurant\Dashboard\CategoryController;
use App\Http\Controllers\Restaurant\Dashboard\CityController as DashboardCityController;
use App\Http\Controllers\Restaurant\Dashboard\CouponController;
use App\Http\Controllers\Restaurant\Dashboard\DashboardController as RestaurantDashboardController;
use App\Http\Controllers\Restaurant\Dashboard\NearbyDeliveryMenMapController as DashboardNearbyDeliveryMenMapController;
use App\Http\Controllers\Restaurant\Dashboard\OrderController as DashboardOrderController;
use App\Http\Controllers\Restaurant\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\Restaurant\Dashboard\ProductSizeController;
use App\Http\Controllers\Restaurant\Dashboard\RestaurantAdminController;
use App\Http\Controllers\Restaurant\Dashboard\RestaurantController;
use App\Http\Controllers\Restaurant\Dashboard\RestaurantMenuController;
use App\Http\Controllers\Restaurant\Dashboard\SliderBannerController;
use App\Http\Controllers\Restaurant\Dashboard\VendorBalanceController as DashboardVendorBalanceController;
use App\Http\Controllers\Restaurant\Frontend\CartController;
use App\Http\Controllers\Restaurant\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Restaurant\Frontend\CheckoutController;
use App\Http\Controllers\Restaurant\Frontend\FrontendController;
use App\Http\Controllers\Restaurant\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Restaurant\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Restaurant\Frontend\RatingController as FrontendRatingController;
use App\Http\Controllers\Restaurant\Frontend\RestaurantController as FrontendRestaurantController;
use App\Http\Controllers\Restaurant\Frontend\SubCategoryController as FrontendSubCategoryController;
use App\Http\Controllers\Restaurant\Frontend\SuCategoryController;
use App\Http\Controllers\Restaurant\Frontend\WishController;
use App\Http\Controllers\User\ForgetPasswordController;
use App\Http\Controllers\User\GoogleAuthController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\UserDeliveryAddressController;
use App\Models\DeliveryMan;
use App\Models\Hotel\Hotel;
use App\Models\HotelCategory;
use App\Models\NewsletterSubscriber;
use App\Models\Restaurant\Product as RestaurantProduct;
use App\Models\Restaurant\Restaurant;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});


Route::get('/foo', function () {
    Artisan::call('storage:link');
});


Route::prefix('admin')->group(function () {
    Route::get('forgot-password', [AdminResetController::class, 'ForgetPassword'])->name('admin.forgot.password');
    Route::post('forgot-password', [AdminResetController::class, 'ForgetPasswordStore'])->name('admin.forgot.password.store');
    Route::get('reset-password/{token}', [AdminResetController::class, 'ResetPassword'])->name('admin.reset.password');
    Route::post('reset-password', [AdminResetController::class, 'ResetPasswordStore'])->name('admin.reset.password.store');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'loginpage'])->name('admin_login');
    Route::post('login', [AdminController::class, 'loginvalidate'])->name('login_admin');
    Route::group(['middleware' => ['admin']], function () {
        Route::get('update_admin_password', [AdminController::class, 'updateadminpassword'])->name('update_admin_password');
        Route::post('updateadminpassword', [AdminController::class, 'update_admin_password'])->name('updateadminpassword');

        Route::get('updateadmindetails', [AdminController::class, 'updateadmindetails'])->name('updateadmindetails');
        Route::put('update_admin_details', [AdminController::class, 'update_admin_details'])->name('update_admin_details');

});

Route::group(['middleware' => ['admin']], function () {
Route::get('adminlogout', [AdminController::class, 'logout'])->name('adminlogout');
});
Route::group(['middleware' => ['admin', 'check.admin:Ecommerce Manager,vendor']], function () {

        Route::post('sales-report', [DashboardController::class, 'filterOrders'])->name('sales-report');

        Route::get('all-payments', [DashboardController::class, 'payments_report'])->name('all-payments');
        //for currencies
        Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies');
        Route::get('currency/add', [CurrencyController::class, 'create'])->name('add-currency');
        Route::post('currency/store', [CurrencyController::class, 'store'])->name('store-currency');
        Route::get('currency/edit/{id}', [CurrencyController::class, 'edit'])->name('edit-currency');
        Route::put('currency/update', [CurrencyController::class, 'update'])->name('update-currency');
        Route::get('currency/delete/{id}', [CurrencyController::class, 'delete'])->name('delete-currency');

        //autoupdate exchange rate
        Route::get('auto-update-exchange-rate', [ExchangeRateController::class, 'getExchangeRate'])->name('auto-update-exchange-rate');

        Route::get('create-custom-order', [AdminCustomOrderController::class, 'create'])->name('create-custom-order');
        Route::post('store-custom-order', [AdminCustomOrderController::class, 'store_custom_order'])->name('store-custom-order');


        Route::post('update-transaction-amount', [TransactionsController::class, 'update'])->name('update-transaction-amount');
        Route::get('transaction/delete/{id}', [TransactionsController::class, 'delete'])->name('delete-transaction');
        //for report
        Route::get('report/customer-report', [UserReportController::class, 'index'])->name('customer-reports');
        Route::get('report/customer/filter', [UserReportController::class, 'filterByDate'])->name('filter.customer');

        Route::get('report/vendors-report', [VendorReportController::class, 'index'])->name('vendor-reports');
        Route::get('report/vendor/filter', [VendorReportController::class, 'filterByDate'])->name('filter-vendors');

        Route::get('report/transfer-stock-report', [TransferStockProductReportController::class, 'index'])->name('transfer-stock-reports');
        Route::post('report/transfer-stock-filter', [TransferStockProductReportController::class, 'filterByDate'])->name('filter-transfer-stocks');

        Route::get('report/product-report', [ProductReportController::class, 'index'])->name('product-reports');
        Route::post('report/product-filter', [ProductReportController::class, 'filterByDate'])->name('filter-products');


        Route::get('report/order-report', [OrderReportController::class, 'index'])->name('orders-reports');
        Route::post('report/order-filter', [OrderReportController::class, 'filterByDate'])->name('filter-orders');

        Route::get('report/order-product-report', [OrderProductReportController::class, 'index'])->name('order-product-reports');
        Route::post('report/order-product-filter', [OrderProductReportController::class, 'filterByDate'])->name('filter-order-products');

        Route::get('report/custom-order-report', [CustomReportController::class, 'index'])->name('custom-order-reports');
        Route::post('report/custom-order-filter', [CustomReportController::class, 'filterByDate'])->name('filter-custom-orders');

        Route::get('report/stock-report', [StockReportController::class, 'index'])->name('stock-reports');
        Route::post('report/stock-filter', [StockReportController::class, 'filterByDate'])->name('filter-stocks');


        //chart for report
        Route::get('report/order/chart', [ChartController::class, 'order'])->name('order-reports');
        Route::get('report/stock/chart', [ChartController::class, 'stock'])->name('stocks-reports');
        Route::get('report/transfer-stock-product/chart', [ChartController::class, 'transfer'])->name('transfer-stock-product-reports');
        Route::get('report/product/chart', [ChartController::class, 'product'])->name('products-reports');
        Route::get('report/order-product/chart', [ChartController::class, 'order_products'])->name('order-products-reports');
        // Route::get('report/stock/chart',[OrderChartController::class,'stock'])->name('stocks-reports');

        Route::get('colors', [ColorController::class, 'index'])->name('colors');
        Route::get('color/add', [ColorController::class, 'create'])->name('add-color');
        Route::post('color/store', [ColorController::class, 'store'])->name('store-color');
        Route::get('color/edit/{id}', [ColorController::class, 'edit'])->name('edit-color');
        Route::put('color/update', [ColorController::class, 'update'])->name('update-color');
        Route::get('color/delete/{id}', [ColorController::class, 'delete'])->name('delete-color');
        Route::get('color/active/{id}', [ColorController::class, 'active'])->name('active-color');
        Route::get('color/inactive/{id}', [ColorController::class, 'inactive'])->name('inactive-color');

        //for email template
        Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email_templates');
        Route::get('email-template/add', [EmailTemplateController::class, 'create'])->name('add-email-template');
        Route::post('email-template/store', [EmailTemplateController::class, 'store'])->name('store-email-template');
        Route::get('email-template/edit/{id}', [EmailTemplateController::class, 'edit'])->name('edit-email-template');
        Route::put('email-template/update', [EmailTemplateController::class, 'update'])->name('update-email-template');
        Route::get('email-template/delete/{id}', [EmailTemplateController::class, 'delete'])->name('delete-email-template');
        Route::get('email-template/active/{id}', [EmailTemplateController::class, 'active'])->name('active-email-template');
        Route::get('email-template/inactive/{id}', [EmailTemplateController::class, 'inactive'])->name('inactive-email-template');


        //for invoice settings
        Route::get('invoice-settings', [InvoiceSettingController::class, 'index'])->name('invoice-settings');
        Route::get('invoice-setting/add', [InvoiceSettingController::class, 'create'])->name('add-invoice-setting');
        Route::post('invoice-setting/store', [InvoiceSettingController::class, 'store'])->name('store-invoice-setting');
        Route::get('invoice-setting/edit/{id}', [InvoiceSettingController::class, 'edit'])->name('edit-invoice-setting');
        Route::put('invoice-setting/update', [InvoiceSettingController::class, 'update'])->name('update-invoice-setting');
        Route::get('invoice-setting/delete/{id}', [InvoiceSettingController::class, 'delete'])->name('delete-invoice-setting');
        Route::get('invoice-setting/active/{id}', [InvoiceSettingController::class, 'active'])->name('active-invoice-setting');
        Route::get('invoice-setting/inactive/{id}', [InvoiceSettingController::class, 'inactive'])->name('inactive-invoice-setting');


        //routing for warehouse
        Route::get('all-warehouse', [WereHouseController::class, 'index'])->name('warehouses.index');
        Route::get('/warehouses/create', [WereHouseController::class, 'create'])->name('warehouses.create');
        Route::post('/warehouses', [WereHouseController::class, 'store'])->name('warehouses.store');
        Route::get('/warehouses/{id}/edit', [WereHouseController::class, 'edit'])->name('warehouses.edit');
        Route::put('/warehouses/{id}', [WereHouseController::class, 'update'])->name('warehouses.update');
        Route::get('/warehouses/{id}', [WereHouseController::class, 'destroy'])->name('warehouses.destroy');
        Route::get('/warehouses/active/{id}', [WereHouseController::class, 'active'])->name('active_warehouse');
        Route::get('/warehouses/inactive/{id}', [WereHouseController::class, 'inactive'])->name('inactive_warehouse');

        Route::post('/warehouses/assing-to-stock-caper', [WereHouseController::class, 'assign'])->name('warehouses.ssing-to-stock-caper');

        Route::get('cities', [CityController::class, 'index'])->name('cities');
        Route::get('city/add', [CityController::class, 'create'])->name('add-city');
        Route::post('city/store', [CityController::class, 'store'])->name('store-city');
        Route::get('city/edit/{id}', [CityController::class, 'edit'])->name('edit-city');
        Route::put('city/update', [CityController::class, 'update'])->name('update-city');
        Route::get('city/delete/{id}', [CityController::class, 'delete'])->name('delete-city');
        Route::get('city/active/{id}', [CityController::class, 'active'])->name('active-city');
        Route::get('city/inactive/{id}', [CityController::class, 'inactive'])->name('inactive-city');

        Route::resource('sub-cities', SubCityController::class);
        Route::resource('streets', StreetController::class);


        Route::get('states', [StateController::class, 'index'])->name('states');
        Route::get('state/add', [StateController::class, 'create'])->name('add-state');
        Route::post('state/store', [StateController::class, 'store'])->name('store-state');
        Route::get('state/edit/{id}', [StateController::class, 'edit'])->name('edit-state');
        Route::put('state/update', [StateController::class, 'update'])->name('update-state');
        Route::get('state/delete/{id}', [StateController::class, 'delete'])->name('delete-state');
        Route::get('state/active/{id}', [StateController::class, 'active'])->name('active-state');
        Route::get('state/inactive/{id}', [StateController::class, 'inactive'])->name('inactive-state');

        Route::get('countries', [CountryController::class, 'index'])->name('countries');
        Route::get('country/add', [CountryController::class, 'create'])->name('add-country');
        Route::post('country/store', [CountryController::class, 'store'])->name('store-country');
        Route::get('country/edit/{id}', [CountryController::class, 'edit'])->name('edit-country');
        Route::put('country/update', [CountryController::class, 'update'])->name('update-country');
        Route::get('country/delete/{id}', [CountryController::class, 'delete'])->name('delete-country');
        Route::get('country/active/{id}', [CountryController::class, 'active'])->name('active-country');
        Route::get('country/inactive/{id}', [CountryController::class, 'inactive'])->name('inactive-country');


        //for vehicle type
        Route::get('vehicle_type', [VehicleTypeController::class, 'index'])->name('vehicle_type');
        Route::get('vehicle_type/add', [VehicleTypeController::class, 'create'])->name('add-vehicle_type');
        Route::post('vehicle_type/store', [VehicleTypeController::class, 'store'])->name('store-vehicle_type');
        Route::get('vehicle_type/edit/{id}', [VehicleTypeController::class, 'edit'])->name('edit-vehicle_type');
        Route::put('vehicle_type/update', [VehicleTypeController::class, 'update'])->name('update-vehicle_type');
        Route::get('vehicle_type/delete/{id}', [VehicleTypeController::class, 'delete'])->name('delete-vehicle_type');
        Route::get('vehicle_type/active/{id}', [VehicleTypeController::class, 'active'])->name('active-vehicle_type');
        Route::get('vehicle_type/inactive/{id}', [VehicleTypeController::class, 'inactive'])->name('inactive-vehicle_type');

        //for delivery man type
        Route::get('delivery_man/type', [DeliveryManTypeController::class, 'index'])->name('delivery_man_type');
        Route::get('delivery_man/type/add', [DeliveryManTypeController::class, 'create'])->name('add-delivery_man_type');
        Route::post('delivery_man_type/store', [DeliveryManTypeController::class, 'store'])->name('store-delivery_man_type');
        Route::get('delivery_man/type/edit/{id}', [DeliveryManTypeController::class, 'edit'])->name('edit-delivery_man_type');
        Route::put('delivery_man_type/update', [DeliveryManTypeController::class, 'update'])->name('update-delivery_man_type');
        Route::get('delivery_man/type/delete/{id}', [DeliveryManTypeController::class, 'delete'])->name('delete-delivery_man_type');
        Route::get('delivery_man/type/active/{id}', [DeliveryManTypeController::class, 'active'])->name('active-delivery_man_type');
        Route::get('delivery_man/type/inactive/{id}', [DeliveryManTypeController::class, 'inactive'])->name('inactive-delivery_man_type');



        //for delivery man type
        Route::get('delivery_zone', [DeliveryZoneController::class, 'index'])->name('delivery_zone');
        Route::get('delivery_zone/add', [DeliveryZoneController::class, 'create'])->name('add-delivery_zone');
        Route::post('delivery_zone/store', [DeliveryZoneController::class, 'store'])->name('store-delivery_zone');
        Route::get('delivery_zone/edit/{id}', [DeliveryZoneController::class, 'edit'])->name('edit-delivery_zone');
        Route::put('delivery_zone/update', [DeliveryZoneController::class, 'update'])->name('update-delivery_zone');
        Route::get('delivery_zone/delete/{id}', [DeliveryZoneController::class, 'delete'])->name('delete-delivery_zone');
        Route::get('delivery_zone/active/{id}', [DeliveryZoneController::class, 'active'])->name('active-delivery_zone');
        Route::get('delivery_zone/inactive/{id}', [DeliveryZoneController::class, 'inactive'])->name('inactive-delivery_zone');

        //routing for stock
        Route::get('stocks/add', [StockController::class, 'create'])->name('add_stock');
        Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::post('/stocks/store', [StockController::class, 'store'])->name('stock.store');

        //permission-categories
        //routing for permission categories
        Route::get('permissions-categories', [PermissionCategoriesController::class, 'index'])->name('permissions-categories');
        Route::get('permissions/category/add', [PermissionCategoriesController::class, 'create'])->name('add-permission-category');
        Route::post('permissions/category/store', [PermissionCategoriesController::class, 'store'])->name('store-permission-category');
        Route::get('permissions/category/edit/{id}', [PermissionCategoriesController::class, 'edit'])->name('edit-permission-category');
        Route::put('permissions/category/update', [PermissionCategoriesController::class, 'update'])->name('update-permission-category');
        Route::get('permissions/category/delete/{id}', [PermissionCategoriesController::class, 'delete'])->name('delete-permission-category');
        Route::get('permissions/category/active/{id}', [PermissionCategoriesController::class, 'active'])->name('active-permission-category');
        Route::get('permissions/category/inactive/{id}', [PermissionCategoriesController::class, 'inactive'])->name('inactive-permission-category');


        //routing for blog category
        Route::get('blog-categories', [BlogsCategoryController::class, 'index'])->name('blog-categories');
        Route::get('blog/category/add', [BlogsCategoryController::class, 'create'])->name('add-blog-category');
        Route::post('blog/category/store', [BlogsCategoryController::class, 'store'])->name('store-blog-category');
        Route::get('blog/category/edit/{id}', [BlogsCategoryController::class, 'edit'])->name('edit-blog-category');
        Route::put('blog/category/update', [BlogsCategoryController::class, 'update'])->name('update-blog-category');
        Route::get('blog/category/delete/{id}', [BlogsCategoryController::class, 'delete'])->name('delete-blog-category');
        Route::get('blog/category/active/{id}', [BlogsCategoryController::class, 'active'])->name('active-blog-category');
        Route::get('blog/category/inactive/{id}', [BlogsCategoryController::class, 'inactive'])->name('inactive-blog-category');


        //routing for blogs
        //routing for blog category
        Route::get('blogs', [BlogsController::class, 'index'])->name('blogs');
        Route::get('blogs/add', [BlogsController::class, 'create'])->name('add-blog');
        Route::post('blogs/store', [BlogsController::class, 'store'])->name('store-blog');
        Route::get('blogs/edit/{id}', [BlogsController::class, 'edit'])->name('edit-blog');
        Route::put('blogs/update', [BlogsController::class, 'update'])->name('update-blog');
        Route::get('blogs/delete/{id}', [BlogsController::class, 'delete'])->name('delete-blog');
        Route::get('blogs/active/{id}', [BlogsController::class, 'active'])->name('active-blog');
        Route::get('blogs/inactive/{id}', [BlogsController::class, 'inactive'])->name('inactive-blog');


        //for blog-comment
        Route::get('blog-comments', [BlogsCommmentController::class, 'index'])->name('blog-comments');
        Route::get('blog-comment/delete/{id}', [BlogsCommmentController::class, 'delete'])->name('delete-blog-comment');
        Route::get('blog-comment/active/{id}', [BlogsCommmentController::class, 'active'])->name('active-blog-comment');
        Route::get('blog-comment/inactive/{id}', [BlogsCommmentController::class, 'inactive'])->name('inactive-blog-comment');


        //routing for transfer-stock-products
        Route::get('transfer-stocks', [ProductTransferController::class, 'index'])->name('transfer-stocks');
        Route::get('add-transfer-stock-product', [ProductTransferController::class, 'create'])->name('add-transfer-stock-product');
        Route::post('store-transfer-stock-product', [ProductTransferController::class, 'transfer_stock'])->name('store-transfer-stock-product');
        // Route::get('list-transfer-stock-product',[ProductTransferController::class,'index'])->name('list-transfer-stock-product');
        Route::get('delete-stock-transfer-product/{id}', [ProductTransferController::class, 'delete'])->name('delete-stock-transfer-product');

        //for reqquest stock transfer product
        Route::get('all-transfer-requests', [TransferRequestController::class, 'index'])->name('all-transfer-requests');
        Route::get('approve-transfer-request/{id}', [TransferRequestController::class, 'approve'])->name('approve-transfer-request');
        Route::get('delete-transfer-request/{id}', [TransferRequestController::class, 'delete'])->name('delete-transfer-request');
        //assing stock to delivery boy
        Route::get('assign-to-deliveryman', [ProductTransferController::class, 'assign'])->name('assign-to-deliveryman');
        Route::post('store-assign-to-deliveryman', [ProductTransferController::class, 'assignProducts'])->name('store-assign-to-deliveryman');

        Route::get('assigned-stock-product-to-deliveryman', [ProductTransferController::class, 'transfered_stock_product'])->name('assigned-stock-product-to-deliveryman');

        Route::get('product/stock-transfer/invoice/{id}', [ProductTransferController::class, 'viewinvoice'])->name('view-stock-tranfer-invoice');

        Route::get('stock-transfer/invoice/{id}', [ProductTransferController::class, 'invoice'])->name('stock-tranfer-invoice');

        //invoice for stock-transfer
        // Route::get('invoice-stock-transfer/invoice/{id}',[ProductTransferController::class,'invoicefortransfer'])->name('invoice-stock-tranfer-product');

        //invoice for grn
        Route::get('good-receiving-note/invoice/{id}', [ProductTransferController::class, 'good_receiving_note_invoice'])->name('good-receiving-note_invoice');


        Route::get('/delivery_boy', action: [DeliveryManController::class, 'index'])->name('delivery_boy.index');
        Route::put('/delivery_boy/{id}/update-password', [DeliveryManController::class, 'updatePassword'])->name('admin.delivery_boy.updatePassword');

        Route::get('/delivery_boy/create', [DeliverymanController::class, 'create'])->name('delivery_boy.create');
        Route::post('/delivery_boy', [DeliverymanController::class, 'store'])->name('delivery_boy.store');
        Route::get('/delivery_boy/{id}/edit', [DeliverymanController::class, 'edit'])->name('delivery_boy.edit');
        Route::put('/delivery_boy/{id}', [DeliverymanController::class, 'update'])->name('delivery_boy.update');
        Route::delete('/delivery_boy/{id}', [DeliverymanController::class, 'destroy'])->name('delivery_boy.destroy');

        Route::get('delivery_boy/is_active/{id}',[DeliveryManController::class,'is_active'])->name('delivery_boy_is_active');
        Route::get('view-withdraw-detail/{id}',[DeliveryManController::class,'detail'])->name('view-withdraw-detail');

        //for role and permission
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);

        Route::get('role/{id}/permission', [RolePermissions::class, 'edit'])->name('role_permissions_edit');
        Route::put('roles/{role}/permissions', [RolePermissions::class, 'update'])->name('role_permissions.update');

        Route::get('user/{id}/role', [RolePermissions::class, 'edit'])->name('user_role_edit');
        Route::put('users/{user}/roles', [AdminRolesController::class, 'update'])->name('user_roles.update');

        Route::get('all-admins', [AdminAdminController::class, 'index'])->name('all-admins.index');
        Route::get('users/{user}/assign-role', [AdminAdminController::class, 'assignRole'])->name('users.assign_role');
        Route::post('users/{user}/update-role', [AdminAdminController::class, 'updateRole'])->name('users.update_role');

        //    assing role to delivery-boy
        Route::get('all-delivery-boys', [DeliveryBoyRolesController::class, 'index'])->name('all-delivery-boy.index');
        Route::get('delivery-boy/{user}/assign-role', [DeliveryBoyRolesController::class, 'assignRole'])->name('delivery_boy.assign_role');
        Route::post('delivery-boy/{user}/update-role', [DeliveryBoyRolesController::class, 'updateRole'])->name('delivery_boy.update_role');

        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('maindashboard');

        // Route::get('/activities', [DashboardController::class, 'getFilteredActivities'])->name('admin.activities');
        Route::get('/admin/activities', action: [DashboardController::class, 'fetch']);

        //for update vendor
        Route::get('update-vendor-details', [AdminController::class, 'updatevendordetails'])->name('updatevendordetails');
        Route::get('update-vendor-bank-details', [AdminController::class, 'updatevendorbankdetails'])->name('updatevendorbankdetails');
        Route::get('update-vendor-business-details', [AdminController::class, 'updatevendorbusinessdetails'])->name('updatevendorbusinessdetails');


        //display admintype
        Route::get('all-vendors', [AdminController::class, 'display_vendor'])->name('all-vendors');

        //routing for vendor status
        Route::get('admin/active/{id}', [AdminController::class, 'active_user'])->name('active_admin');
        Route::get('admin/inactive/{id}', [AdminController::class, 'inactive_user'])->name('inactive_admin');

        // display all users on admin table
        Route::get('all/admins', action: [AdminController::class, 'displayall'])->name('alladmins');
        Route::get('activity/{id}', [AdminActivityLogController::class, 'activity_log'])->name('admin_activity_log');
        Route::get('view_vendor_details/{id}', [AdminController::class, 'viewVendorDetails'])->name('viewVendorDetails');
        Route::get('manage-discounts', [DiscountManagementController::class, 'index'])->name('manage.discounts');

        Route::put('/admin/{id}/update-password', action: [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

        //Routing for products tables
        Route::get('products', [ProductController::class, 'product'])->name('products');
        Route::get('products/add-product', [ProductController::class, 'create'])->name('addproduct');

        Route::get('active/product/{product_id}', [ProductController::class, 'active'])->name('active_products');
        Route::get('inactive/product/{product_id}', [ProductController::class, 'inactive'])->name('inactive_products');
        Route::get('product/delete/{product_id}', [ProductController::class, 'deleteproduct'])->name('delete_product');

        Route::get('featured/product/{product_id}', [ProductController::class, 'featured'])->name('featured_products');
        Route::get('notfeatured/product/{product_id}', [ProductController::class, 'notfeatured'])->name('notfeatured_product');

        Route::post('store_product', [ProductController::class, 'addproduct'])->name('store_product');
        Route::post('fetchsubcategory', [ProductController::class, 'fetchSubcategory'])->name('fetchsubcategory');

        Route::get('edit/product/{product_id}', [ProductController::class, 'edit'])->name('edit_product');
        Route::put('products/update/', [ProductController::class, 'update'])->name('update_product');

        Route::get('products/add_attribute/{id}', [ProductController::class, 'add_attribute'])->name('add_attribute');
        Route::post('products/addattributes', [ProductController::class, 'addattributes'])->name('addattributes');

        Route::get('products/active_attribute/{id}', [ProductController::class, 'active_attribute'])->name('active_attribute');
        Route::get('products/inactive_attribute/{id}', [ProductController::class, 'inactive_attribute'])->name('inactive_attribute');
        Route::get('products/delete_attribute/{id}', [ProductController::class, 'deleteattribute'])->name('deleteattribute');

        Route::post('products/attributes/{id}', [ProductController::class, 'editAttributes'])->name('editAttributes');


        //Routing for product image
        Route::get('products/images/{id}', [ProductController::class, 'addImages'])->name('addImages');
        Route::post('products/images', [ProductController::class, 'add_image'])->name('add_image');

        //routing for active and inactive product images
        Route::get('products/active_productimage/{id}', [ProductController::class, 'active_ProdcutImage'])->name('active_ProdcutImage');
        Route::get('products/inactive_prodcutImage/{id}', [ProductController::class, 'inactive_ProductImage'])->name('inactive_ProdcutImage');
        //routing for delete images
        Route::get('products/delete_image/{id}', [ProductController::class, 'deleteaImageProduct'])->name('deleteaImageProduct');

        Route::get('update_is_seasonal/{id}', [ProductController::class, 'is_seasonal'])->name('update.is.seasonal');
        Route::post('add_season', [ProductController::class, 'add_season'])->name('add_season');
        //Routing for banners

        Route::match(['get', 'post'], 'banners', [BannerController::class, 'banners'])->name('banners');
        //routing for active and inactive product images
        Route::get('banners/active/{id}', [BannerController::class, 'active_banner'])->name('active_banner');
        Route::get('banners/inactive/{id}', [BannerController::class, 'inactive_banner'])->name('inactive_banner');

        Route::get('banners/delete/{banner_id}', [BannerController::class, 'delete'])->name('delete_banners');
        Route::get('banners/create', [BannerController::class, 'create'])->name('create_banners');
        //    Route::post('banners/store',[BannerController::class,'store'])->name('store_banners');

        Route::get('banners/edit/{id}', [BannerController::class, 'edit'])->name('edit_banner');
        Route::put('banner/update', [BannerController::class, 'update'])->name('update_banner');

        Route::get('coupons', [CouponsController::class, 'coupons'])->name('coupons');
        Route::match(['get', 'post'], 'coupons/add-edit/{id?}', [CouponsController::class, 'addEditCoupon'])->name('add_edit_coupon');
        Route::get('coupons/{coupon_id}/edit', [CouponsController::class, 'edit'])->name('edit_coupon');
        Route::post('coupons/store', [CouponsController::class, 'store'])->name('store_coupon');
        Route::put('coupons/update', [CouponsController::class, 'update'])->name('update_coupon');
        Route::get('coupons/{coupons_id}/delete', [CouponsController::class, 'destory'])->name('delete_coupon');

        Route::get('coupons/active/{coupons_id}', [CouponsController::class, 'active'])->name('active_coupon');
        Route::get('coupons/inactive/{coupons_id}', [CouponsController::class, 'inactive'])->name('inactive_coupon');

        Route::get('users', [AdminUserController::class, 'users'])->name('users');
        Route::put('/users/{id}/update-password', [AdminUserController::class, 'updatePassword'])->name('admin.users.updatePassword');

        Route::get('users/active/{user_id}', [AdminUserController::class, 'active'])->name('active_users');
        Route::get('users/inactive/{user_id}', [AdminUserController::class, 'inactive'])->name('inactive_users');
        Route::get('users/{user_id}/delete', [AdminUserController::class, 'destory'])->name('delete_user');

        Route::get('orders', [OrdersController::class, 'orders'])->name('allorders');
        Route::post('order-filter-reports', [OrdersController::class, 'filterOrders'])->name('order-filter-reposts');
        Route::get('orders/{order_id}', [OrdersController::class, 'orderDetails']);
        Route::post('update-order-status', [OrdersController::class, 'updateOrderStatus']);
        Route::post('update-order-payment-status', [OrdersController::class, 'updateOrderPaymentStatus']);
        Route::post('update-order-item-status', [OrdersController::class, 'updateOrderItemStatus']);

        Route::put('assign-to-delivery-boy', [AssingOrderToDeliveryBoy::class, 'assignToDeliveryBoy'])->name('assing_to_delivery_boy');

        Route::get('order/invoice/{id}', [OrdersController::class, 'viewOrderInvoice'])->name('view_order_invoice');
        Route::get('order/invoice/pdf/{id}', [OrdersController::class, 'viewPDFInvoice'])->name('view_pdf_invoice');
        //user order cancel
        Route::match(['GET', 'POST'], '/orders/{id}/cancel', [OrdersController::class, 'ordercancel']);
        Route::match(['GET', 'POST'], '/orders/{id}/return', [OrdersController::class, 'orderreturn']);
        //Routing for Shipping Charges
        Route::get('shipping-charges', [ShippingChargeController::class, 'shippingCharges']);

        Route::get('shipping-charges/active/{shipping_id}', [ShippingChargeController::class, 'active']);
        Route::get('shipping-charges/inactive/{shipping_id}', [ShippingChargeController::class, 'inactive']);
        Route::get('shipping-charges/delete/{shipping_id}', [ShippingChargeController::class, 'destory']);
        Route::get('shipping-charges/{id}', [ShippingChargeController::class, 'create']);

        Route::put('shipping-charges/updates/', [ShippingChargeController::class, 'edit']);

        Route::post('shipping-charges/store', [ShippingChargeController::class, 'store']);
        Route::get('shipping_create', [ShippingChargeController::class, 'display']);

        //for return requests
        Route::get('return_request', [OrdersController::class, 'return_request'])->name('return_request');
        Route::post('return_request/update', [OrdersController::class, 'return_requestUpdate'])->name('return_requestUpdate');

        //vendor Commissions
        Route::post('update-vendor-commission', [AdminController::class, 'updateVendorCommission']);

        Route::get('admins-subadmins', [AdminController::class, 'adminsubadmins'])->name('admin_subadmin');
        Route::get('admin_subadmin_active/{id}', [AdminController::class, 'active_admin_and_subadmin'])->name('active_admin_subadmin');
        Route::get('admin_subadmin_inactive/{id}', [AdminController::class, 'inactive_admin_and_subadmin'])->name('inactive_admin_subadmin');
        Route::get('admin-subadmin/{id}', [AdminController::class, 'delete_admin_and_subadmin'])->name('delete_admin_or_subadmin');

        Route::get('add_admin', [AdminController::class, 'add_admin_or_subadmin'])->name('add_admin_or_subadmin');
        Route::post('store_admin_or_subadmin', [AdminController::class, 'store_admin_or_subadmin'])->name('store_admin_or_subadmin');
        Route::get('edit_admin/{id}', [AdminController::class, 'edit_admin_or_subadmin'])->name('edit_admin_or_subadmin');
        Route::put('update_admin_or_subadmin', [AdminController::class, 'update_admin_or_subadmin'])->name('update_admin_or_subadmin');

        Route::get('add_user', [AdminUserController::class, 'adduser'])->name('add_user');
        Route::post('store_user', [AdminUserController::class, 'store_user'])->name('store_user');
        Route::get('edit_user/{id}', [AdminUserController::class, 'edit_user'])->name('edit_user');
        Route::put('udpate_user', [AdminUserController::class, 'update_user'])->name('update_user');

        //to delete vendor

        Route::get('vendors', [VendorController::class, 'allvendors'])->name('vendors');
        Route::get('vendors/active/{id}', [VendorController::class, 'active'])->name('acive-vendors');
        Route::get('vendors/inactive/{id}', [VendorController::class, 'inactive_vendor'])->name('inactive-vendors');

        Route::get('vendors/details/{id}', [VendorController::class, 'vendor_details'])->name('vendor_details');
        Route::get('vendor/delete/{id}', [VendorController::class, 'delete'])->name('delete-vendor');
        //routeing for role and permissions
        Route::match(['get', 'post'], 'update-role/{id}', [AdminController::class, 'updateRole'])->name('update_role');


        //for productdeal
        Route::resource('flash_deals', FlashDealController::class);
        Route::controller(FlashDealController::class)->group(function () {
            Route::get('/flash_deals/edit/{id}', 'edit')->name('flash_deals.edited');
            Route::get('/flash_deals/destroy/{id}', 'destroy')->name('flash_deals.destroys');
            Route::get('/flash_deals/status/active/{id}', 'active')->name('flash_deals.active');
            Route::get('/flash_deals/status/inactive/{id}', 'inactive')->name('flash_deals.inactive');

            Route::post('/flash_deals/update_featured', 'update_featured')->name('flash_deals.update_featured');
            Route::post('/flash_deals/product_discount', 'product_discount')->name('flash_deals.product_discount');
            Route::post('/flash_deals/product_discount_edit', 'product_discount_edit')->name('flash_deals.product_discount_edit');
        });

        //for fast orders
        Route::controller(AdminCustomOrderController::class)->group(function () {
            Route::get('custom-orders', 'index')->name('custom_orders');

            Route::get('custom-orders/inactive/{id}', 'inactive')->name('inactive_fast_orders');
            //  Route::get('custom-orders/active/{id}','active')->name('active_fast_orderss');
            Route::get('custom-orders/detail/{id}', 'detail')->name('custom_order_detail');

            //assing to delivery boy
            Route::post('custom-orders/assign_to_delivery_boy', 'assign_to_delivery_boy')->name('assign_to_delivery_boy');
            Route::post('custom-orders/update-fast-order-status', 'updateStatus')->name('update-custom-order-status');
            Route::get('custom-orders/delete/{id}', 'delete')->name('delete-custom-order');

            Route::get('custom-order/invoice/{id}', 'viewinvoice')->name('custom-order-invoice');
            Route::get('custom-order/invoice/download/{id}', 'invoice')->name('custom-order-invoice-download');
        });

        //route for Ratings
        Route::get('ratings', [\App\Http\Controllers\Admin\RatingController::class, 'ratings'])->name('ratings');
        Route::get('ratings/inactive/{id}', [\App\Http\Controllers\Admin\RatingController::class, 'inactive'])->name('inactive_ratings');
        Route::get('ratings/active/{id}', [\App\Http\Controllers\Admin\RatingController::class, 'active'])->name('active_ratings');
        Route::get('ratings/delete/{id}', [\App\Http\Controllers\Admin\RatingController::class, 'delete'])->name('delete_ratings');

        Route::get('newslettersubscribers', [NewletterSubscriberController::class, 'lists'])->name('newslettersubscribers');
        Route::get('newslettersubscribers/inactive/{id}', [NewletterSubscriberController::class, 'inactive'])->name('inactive_newslettersubscribers');
        Route::get('newslettersubscribers/active/{id}', [NewletterSubscriberController::class, 'active'])->name('active_newslettersubscribers');
        Route::get('newslettersubscribers/delete/{id}', [NewletterSubscriberController::class, 'delete'])->name('delete_newslettersubscribers');

        Route::get('send-email-to-all', [NewletterSubscriberController::class, 'create'])->name('send-email-to-all');
        Route::post('send-email-to-all-users', [NewletterSubscriberController::class, 'send'])->name('send-email-to-all-users');
        //routing for advertisement
        Route::get('adverstisements', [AdvertisementController::class, 'index'])->name('adverstisements');
        Route::get('adverstisements/add', [AdvertisementController::class, 'create'])->name('add_adverstisements');
        Route::post('store_adverstisements', [AdvertisementController::class, 'store'])->name('store_adverstisements');
        Route::put('update_adverstisements', [AdvertisementController::class, 'update'])->name('update_adverstisements');

        Route::get('adverstisements/edit/{id}', [AdvertisementController::class, 'edit'])->name('edit_adverstisements');
        Route::get('adverstisements/delete/{id}', [AdvertisementController::class, 'delete'])->name('delete_adverstisements');
        Route::get('adverstisements/inactive/{id}', [AdvertisementController::class, 'inactive'])->name('inactive_adverstisements');
        Route::get('adverstisements/active/{id}', [AdvertisementController::class, 'active'])->name('active_adverstisements');
        //routing for app settings
        Route::get('appsettings', [AppSettingController::class, 'create'])->name('appsettings');
        Route::put('appsettings/update', [AppSettingController::class, 'update'])->name('update_appsettings');

        Route::get('allfaq', [FaqController::class, 'allfaq'])->name('allfaq');
        Route::get('faq/add', [FaqController::class, 'create'])->name('add_faq');
        Route::post('store_faq', [FaqController::class, 'store'])->name('store_faq');
        Route::put('update_faq', [FaqController::class, 'update'])->name('update_faq');

        Route::get('faq/edit/{id}', [FaqController::class, 'edit'])->name('edit_faq');
        Route::get('faq/delete/{id}', [FaqController::class, 'delete'])->name('delete_faq');
        Route::get('faq/inactive/{id}', [FaqController::class, 'inactive'])->name('inactive_faq');
        Route::get('faq/active/{id}', [FaqController::class, 'active'])->name('active_faq');

        Route::get('vendor-notification',[VendorNotificationController::class,'index'])->name('vendor-notification');
        Route::patch('vendor/notifications/{id}/read', [VendorNotificationController::class, 'markAsRead'])
    ->name('vendor.notifications.markAsRead');

        Route::get('cms-pages', [CmsController::class, 'cmspages']);
        Route::get('cms/active/{cms_id}', [CmsController::class, 'active'])->name('active_cms');
        Route::get('cms/inactive/{cms_id}', [CmsController::class, 'inactive'])->name('inactive_cms');
        Route::get('cms/delete/{cms_id}', [CmsController::class, 'delete'])->name('delete_cms');

        Route::get('add_cms_page', [CmsController::class, 'create'])->name('add_cms_page');
        Route::get('edit_cms_page/{id}', [CmsController::class, 'edit'])->name('edit_cms_page');
        Route::post('store_cms_page', [CmsController::class, 'store'])->name('store_cms_page');
        Route::put('update_cms_page', [CmsController::class, 'update'])->name('update_cms_page');

        //Routing for product Categories
        Route::get('append-categories-level', [CategoriesController::class, 'appendCategoryLevel'])->name('append-categories-level');
        Route::get('categories', [CategoriesController::class, 'index'])->name('categories');
        Route::get('categories/add', [CategoriesController::class, 'create'])->name('add_categories');
        Route::post('categories/store', [CategoriesController::class, 'store'])->name('store_categories');
        Route::get('categories/{id}/edit', [CategoriesController::class, 'edit'])->name('edit_categories');
        Route::get('categories/{categoires_id}/delete', [CategoriesController::class, 'destory'])->name('delete_categories');
        Route::put('categories/update', [CategoriesController::class, 'update'])->name('upate_categories');

        Route::get('active/category/{categories_id}', [CategoriesController::class, 'active'])->name('active_category');
        Route::get('inactive/category/{categories_id}', [CategoriesController::class, 'inactive'])->name('inactive_category');

        //routing for groups
        Route::get('groups', [GroupController::class, 'index'])->name('groups');
        Route::get('groups/{group_id}/edit', [GroupController::class, 'edit'])->name('edit_group');
        Route::get('groups/delete/{group_id}', [GroupController::class, 'destory'])->name('group_destory');
        Route::get('groups/add', [GroupController::class, 'create'])->name('add_group');
        Route::post('groups/store', [GroupController::class, 'store'])->name('store_group');
        Route::put('group/{group_id}/update', [GroupController::class, 'update'])->name('update_group');

        Route::get('active/group/{group_id}', [GroupController::class, 'active'])->name('active_groups');
        Route::get('inactive/group/{group_id}', [GroupController::class, 'inactive'])->name('inactive_groups');


        //routing for brands
        Route::get('brands', [BrandController::class, 'index'])->name('brands');
        Route::get('brands/add', [BrandController::class, 'create'])->name('add_brand');
        Route::get('brands/{brand_id}/edit', [BrandController::class, 'edit'])->name('edit_brand');
        Route::post('brands/store', [BrandController::class, 'store'])->name('store_brand');
        Route::put('brands/update', [BrandController::class, 'update'])->name('update_brand');
        Route::get('barnds/{brand_id}/delete', [BrandController::class, 'destory'])->name('delete_brand');

        Route::get('active/brands/{brand_id}', [BrandController::class, 'active'])->name('active_brands');
        Route::get('inactive/brands/{brand_id}', [BrandController::class, 'inactive'])->name('inactive_brands');
        //Routing for Filters
        Route::get('filters', [FilterController::class, 'filters'])->name('filters');
        Route::get('active/filters/{id}', [FilterController::class, 'active'])->name('active_filters');
        Route::get('inactive/filters/{id}', [FilterController::class, 'inactive'])->name('inactive_filters');
        Route::get('filters/create', [FilterController::class, 'create'])->name('create_filter');
        Route::post('filters/store', [FilterController::class, 'store'])->name('store_filter');
        Route::get('filters/delete/{id}', [FilterController::class, 'delete'])->name('filters-delete');
        //Routing for fiters_values
        Route::get('filters_values', [FilterController::class, 'filtersValues'])->name('filters_values');
        Route::get('active/filters_values/{id}', [FilterController::class, 'active_filters_value'])->name('active_filters_values');
        Route::get('inactive/filters_values/{id}', [FilterController::class, 'inactive_filters_value'])->name('inactive_filters_values');

        Route::post('category-filters', [FilterController::class, 'categoryFilters'])->name('category_filters');
        Route::get('filters/create_filter_values', [FilterController::class, 'createfiltervalues'])->name('create_filter_values');
        Route::post('filters/store_filter_value', [FilterController::class, 'storefiltervalues'])->name('store_filter_value');

        Route::get('filters_value/delete/{id}', [FilterController::class, 'deletefiltervalue'])->name('filters_value-delete');


        Route::get('orders_report', [DashboardController::class, 'order_reports'])->name('orders_reports');
        Route::get('view-users-city', [DashboardController::class, 'userscity'])->name('users_city');

        // for subscriptions
        Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        // for shipping zones
        Route::get('shipping-zones', [ShippingZoneController::class, 'index'])->name('shipping-zones.index');
        // shipping method
        Route::get('shipping-methods', [ShippingMethodController::class, 'index'])->name('shipping-methods');

        // offers
        Route::get('offers/products/', [OfferController::class, 'index'])->name('offers.products.index');
        Route::get('offer/detail/{offerId}', [OfferController::class, 'detail'])->name('offer.detail');
        Route::get('offer-products/{productId}/offers', [OfferController::class, 'product_offer'])->name('product-offer');

        // stream_socket_accept
        Route::get('all-stock', [StockController::class, 'live_wire'])->name('all-stock');

        Route::post('login-as-vendor/{vendor}', [AdminLoginInToVendorController::class, 'loginAsVendor'])->name('admin.login-as-vendor');
        Route::post('switch-back-to-admin', [AdminLoginInToVendorController::class, 'switchBackToAdmin'])->name('switch-back-to-admin');

        //assign warehouse to user
        Route::get('assign-warehouse', [WerehouseController::class, 'assign_warehouse'])->name('assign-warehouse');
        Route::post('assign', [WerehouseController::class, 'assign'])->name('assign.store');
        Route::get('delete-assigned-warehouse/{id}', [WerehouseController::class, 'delete_assigned'])->name('assigned.delete');

        Route::get('sales-users', [SalesUsersController::class, 'index'])->name('sales-users');
        Route::get('sales-user/{id}/detail', [SalesUsersController::class, 'detail'])->name('salesuser.view');

        // withdrawrequest for vendor
        Route::get('withdraw-request', [VendorWithdrawRequestController::class, 'index'])->name('withdrawrequest.index');
        Route::get('all-withdraw-requests', [AdminWithdrawRequestController::class, 'index'])->name('admin.withdrawrequest.index');
        Route::get('tax-settings', [TaxController::class, 'index'])->name('tax-settings.index');
        Route::get('withdraw-settings', [WithdrawSettingController::class, 'index'])->name('withdraw-settings.index');

        Route::get('out-of-products',[OutOfStockProductController::class,'index'])->name('out-of-products');

        Route::resource('tips',TipSettingsController::class)->except(['create', 'edit', 'show']);

        Route::resource('banks', BankController::class)->except(['create', 'edit', 'show']);

        Route::get('/withdrawals', [DeliveryManWithdrawController::class, 'index'])->name('admin.withdrawals');
        Route::post('/withdrawals/{id}/approve', [DeliveryManWithdrawController::class, 'approve'])->name('admin.withdrawals.approve');
        Route::post('/withdrawals/{id}/reject', [DeliveryManWithdrawController::class, 'reject'])->name('admin.withdrawals.reject');



    });
        Route::group(['middleware' => 'admin'], function () {

        Route::get('vendor/withdraw-requests',[VendorVendorWithdrawRequestController::class,'index']);

        Route::post('withdraw.update/{id}',[VendorVendorWithdrawRequestController::class,'updateWithdrawStatus'])->name('admin.withdraw.update');
        Route::put('update_vendor_details', [AdminController::class, 'update_vendor_details'])->name('update_vendor_details')->middleware('admin');
        Route::put('update_vendor_businessdetails', [AdminController::class, 'update_vendor_businessdetails'])->name('update_vendor_businessdetails')->middleware('admin');
        Route::put('update_vendor_bank_details', [AdminController::class, 'update_vendor_bank_details'])->name('update_vendor_bank_details')->middleware('admin');


        Route::get('vendor/wallet',[VendorBalanceController::class,'index']);
        Route::post('vendor-withdraw-request',[VendorBalanceController::class,'requestWithdraw'])->name('vendor-withdraw-request');
    });
});


Route::get('delivery-boy/login', [DeliveryDeliveryManController::class, 'login'])->name('delivery_boy_login');
Route::post('delivery-boy/login', [DeliveryDeliveryManController::class, 'login_validate'])->name('delivery_boy');

Route::get('delivery-boy/forget-password', [DeliveryDeliveryManController::class, 'forgetpassword'])->name('delivery-man-forget-password');
Route::post('delivery-boy/forget-password', [DeliveryDeliveryManController::class, 'ForgetPasswordStore'])->name('delivery-man-forgetpassword');
Route::get('delivery-boy/reset-password/{token}', [DeliveryDeliveryManController::class, 'ResetPassword'])->name('delivery-man-ResetPasswordGet');
Route::match(['get', 'post'], 'delivery-boy/reset-password', [DeliveryDeliveryManController::class, 'ResetPasswordStore'])->name('delivery-man-ResetPasswordPost');

Route::group(['middleware' => 'deliverymen'], function () {

    Route::post('/delivery/accept/{id}', [DeliveryOrderController::class, 'accept'])->name('delivery.accept');
    Route::post('/delivery/decline/{id}', [DeliveryOrderController::class, 'decline'])->name('delivery.decline');
    Route::get('/delivery/restaurant-orders', [DeliveryOrderController::class, 'orders'])->name('delivery.restaurant-orders');
    Route::post('/notification/{id}/seen', [DeliveryOrderController::class, 'markNotificationSeen'])->name('delivery.markNotificationSeen');
    Route::post('/delivery/mark-delivered/{orderId}', [DeliveryOrderController::class, 'verifyDeliveryCode'])->name('delivery.markDelivered');

    Route::post('/delivery/confirm-pickup', [DeliveryOrderController::class, 'confirmPickup'])->name('delivery.pickup.confirm');

    Route::get('/delivery-boy/dashboard', [DeliveryDeliveryManController::class, 'index'])->name('delivery_man.dashboard');
    //delviery boy login and registeration
    Route::get('delivery-boy/logout', [DeliveryDeliveryManController::class, 'logout'])->name('delivery-boy-logout');
    Route::get('deilvery-boy/update-password', [DeliveryDeliveryManController::class, 'update_password'])->name('update-password');
    Route::post('deilvery-boy/update_delivery_boy_password', [DeliveryDeliveryManController::class, 'update_delivery_boy_password'])->name('update_delivery_boy_password');
    Route::get('delivery-boy/update-profile', [DeliveryDeliveryManController::class, 'update_profile'])->name('update_profile');
    Route::put('delivery-boy/update-profile-information', [DeliveryDeliveryManController::class, 'update'])->name('update_profile-information');

    Route::get('delivery-boy/orders', [DeliveryDeliveryManController::class, 'orders'])->name('delivery_boy_order');
    Route::get('delivery-boy/order-detail/{id}', [DeliveryDeliveryManController::class, 'order_detail'])->name('delivery_boy_order_detail');

    Route::get('delivery-boy/order/invoice/{id}', [OrdersController::class, 'viewOrderInvoice'])->name('delivery_boy_view_order_invoice');
    Route::get('delivery-boy/order/invoice/pdf/{id}', [OrdersController::class, 'viewPDFInvoice'])->name('delivery_boy_view_pdf_invoice');

    Route::post('delivery-boy/update-order-status', [DeliveryDeliveryManController::class, 'updateOrderStatus']);
    Route::post('delivery-boy/update-order-item-status', [DeliveryDeliveryManController::class, 'updateOrderItemStatus']);

    Route::post('update_acceptance_order', [DeliveryDeliveryManController::class, 'update_acceptance'])->name('update_acceptance_order');
    //for custome order invoice
    Route::get('delivery-boy/stock-transfer/invoice/{id}', [DeliveryCustomOrderController::class, 'viewinvoice'])->name('delivery-boy-stock-tranfer-invoice');

    Route::get('delivery-boy/product/stock-transfer/invoice/{id}', [ProductTransferController::class, 'viewinvoice'])->name('delivery-boy-view-stock-tranfer-invoice');
    //invoice for grn
    Route::get('delivery-boy/good-receiving-note/invoice/{id}', [ProductTransferController::class, 'good_receiving_note_invoice'])->name('delivery-boy-good-receiving-note_invoice');

    Route::post('/withdraw-request', [WithdrawController::class, 'requestWithdraw'])->name('delivery.withdraw.request');

    Route::controller(DeliveryCustomOrderController::class)->group(function () {
        //for fast orders
        Route::get('delivery-boy/custom-orders', 'index')->name('delivery_boy_custom_orders');
        Route::get('delivery-boy/custom-orders/detail/{id}', 'detail')->name('delivery_boy_custom_order_detail');
        Route::post('delivery-boy/custom-orders/update-custom-order-status', 'update_delivery_status')->name('update_delivery_status');
        Route::post('delivery-boy/custom-orders/update-custom-order-product-status', 'update_product_delivery_status')->name('update_product_delivery_status');

        Route::get('delivey-boy/stock-products', [StockTransferProductController::class, 'index'])->name('delivery-boy-stock-products');
        Route::get('delivery-boy/stock-product/detail/{id}', [StockTransferProductController::class, 'detail'])->name('delivery-boy-stock-product-detail');
        Route::post('delivery-boy/update-stock-product-transfer-status', [StockTransferProductController::class, 'update_status'])->name('updata_stock_transfer_status');
    });

    Route::get('delivery-boy/pickup-order/{orderId}/{restaurantId}',[DeliveryOrderController::class,'pickupView']);
    Route::get('delivery-boy/get-customer-location/{orderId}',[DeliveryOrderController::class,'getCustomerLocation']);
    Route::get('delivery-boy/ecommerce/get-customer-location/{orderId}',action: [GetLocationController::class,'getCustomerLocation']);
    Route::get('delivery-boy/ecommerce/pickup-order/{orderId}/{vendorId}',[GetLocationController::class,'pickupView']);
});

Route::get('page/{url}', [FrontCmsController::class, 'pages'])->name('pages');
Route::post('store-custom-orders', [CustomOrderController::class, 'store_fast_order'])->name('store_custom_order');

// /Route::match(['GET', 'POST'], '/add-rating', [RatingController::class, 'addRating'])->name('add_rating');
Route::post('newslettersubscriber', [NewletterSubscriberController::class, 'store'])->name('newslettersubscriber');
//User Logout
Route::get('user/logout', [UserController::class, 'userLogout']);
//Confirm User Account
Route::get('faq', [FaqController::class, 'index'])->name('faq');

// for sales man

Route::prefix('sales')->name('sales.')->group(function () {
    // Login Routes...
    Route::get('login', [SalesUserAuthLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [SalesUserAuthLoginController::class, 'login']);
    Route::post('logout', [SalesUserAuthLoginController::class, 'logout'])->name('logout');

    // Registration Routes...
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::middleware('sales')->group(function () {
        Route::get('dashboard', [SalesUserAuthDashboardController::class, 'index'])->name('dashboard');
    });
});


// Restaurant Routes
Route::prefix('admin/restaurant')->group(function () {
    Route::group(['middleware' => ['admin', 'check.admin:Restaurant Manager']], function () {
        Route::get('dashboard', [RestaurantDashboardController::class, 'index'])
            ->name('restaurant.dashboard');
        Route::get('/dashboard/orders/trend', [RestaurantDashboardController::class, 'orderTrend'])->name('orders.trend');
        Route::get('/dashboard/orders.by.category', [RestaurantDashboardController::class, 'ordersByCategory'])->name('orders.by.category');
        Route::get('/chart/top-users', [RestaurantDashboardController::class, 'topOrderingUsers'])->name('chart.top.users');
        Route::get('/dashboard/sales-summary', [RestaurantDashboardController::class, 'salesSummary'])->name('dashboard.sales.summary');
        Route::get('/dashboard/orderStatusBreakdown', [RestaurantDashboardController::class, 'orderStatusBreakdown'])->name('orderStatusBreakdown');
        Route::get('/dashboard/orderbycity', [RestaurantDashboardController::class, 'ordersByCity'])->name('orderbycity');

        Route::resource('slider-banners', SliderBannerController::class);
        Route::resource('restaurants', RestaurantController::class);
        Route::get('my-restaurant/{id}', [RestaurantController::class, 'show'])->name('my-restaurant');
        Route::delete('/restaurant-images/{id}', [RestaurantController::class, 'deleteImage'])->name('restaurants.deleteImage');
        Route::resource('categories', CategoryController::class);
        Route::resource('menus', RestaurantMenuController::class);

        Route::resource('subcategories', FrontendSubCategoryController::class);
        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
        Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
        Route::post('/coupons/update/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::post('/coupons/delete/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');

        Route::get('/cities', [DashboardCityController::class, 'index'])->name('cities.index');
        Route::post('/cities/store', [DashboardCityController::class, 'store'])->name('cities.store');
        Route::post('/cities/update/{id}', [DashboardCityController::class, 'update'])->name('cities.update');
        Route::delete('/cities/destroy/{id}', [DashboardCityController::class, 'destroy'])->name('cities.destroy');

        Route::resource('products', DashboardProductController::class);
        Route::get('show-product/{id}', [DashboardProductController::class, 'show'])->name('show.product');

        Route::post('products/{product}/sizes', [ProductSizeController::class, 'store'])->name('productSizes.store');
        Route::put('product-sizes/{size}', [ProductSizeController::class, 'update'])->name('productSizes.update');
        Route::delete('product-sizes/{product}/{size}', [ProductSizeController::class, 'destroy'])->name('productSizes.destroy');

        Route::get('/orders', [DashboardOrderController::class, 'index'])->name('restaurant.orders.index');
        Route::get('/orders/{id}', [DashboardOrderController::class, 'show'])->name('restaurant.orders.show');
        Route::post('/assignToDeliveryMan/{order_id}', [AssignOrderController::class, 'assignToDeliveryMan'])->name('restaurant.assignToDeliveryMan');
        Route::post('/orders/{id}/update', [DashboardOrderController::class, 'updateStatus'])->name('restaurant.orders.updateStatus');


        Route::get('/nearby-deliverymen/{order_id}',[DashboardNearbyDeliveryMenMapController::class,'index']);
        Route::get('/api/orders/{order}/nearby-deliverymen', action: [DashboardNearbyDeliveryMenMapController::class, 'getNearbyDeliveryMen']);

        Route::get('update-vendor-details', action: [RestaurantAdminController::class, 'updatevendordetails'])->name(name: 'restaurant.updatevendordetails');
        Route::get('update-vendor-bank-details', action: [RestaurantAdminController::class, 'updatevendorbankdetails'])->name(name: 'restaurant.updatevendorbankdetails');

        Route::get('vendor/wallet',action: [DashboardVendorBalanceController::class,'index']);

     });
});

Route::post('/send-message', function () {
    broadcast(new MessageSent(request('message')))->toOthers();
    return response()->json(['status' => 'Message broadcasted!']);
});
// Hotel Reservations
Route::group(['middleware' => ['admin', 'check.admin:Hotel Manager']], function () {
    Route::resource('admin/hotels', HotelController::class);
    Route::get('admin/hotel/{id}/toggleAdvertise', [HotelController::class, 'toggleAdvertise']);
    Route::get('admin/hotel/{id}/toggleFeatured', [HotelController::class, 'toggleFeatured']);
    Route::prefix('admin/hotel')->middleware(['admin'])->group(function () {
        Route::get('dashboard', [DashboardDashboardController::class, 'index'])
            ->name('hotel.dashboard');
            Route::post('/dashboard/filter', [DashboardDashboardController::class, 'filterStats'])->name('dashboard.filter');

        Route::resource('amenities', AmenityController::class);
        Route::resource('hotel-categories', HotelCategoryController::class);
        Route::post('/hotel-photos', [HotelPhotoController::class, 'store'])->name('hotel_photos.store');
        Route::delete('/hotel-photos/{id}', [HotelPhotoController::class, 'destroy'])->name('hotel_photos.destroy');
        Route::get('{id}/reviews', [HotelReviewController::class, 'index'])->name('hotel-reviews.index');
        Route::get('/reservations', [ReservationsController::class, 'index'])->name('reservations.index');
        Route::put('/reservations/{id}/status', [ReservationsController::class, 'updateStatus'])->name('reservations.updateStatus');
        Route::put('/reservations/{id}/payment_status', [ReservationsController::class, 'updatePaymentStatus'])->name('reservations.updatePaymentStatus');
        Route::delete('/reservations/{id}', [ReservationsController::class, 'destroy'])->name('reservations.destroy');
        Route::resource('rooms', RoomController::class);
        Route::get('my-hotel', [HotelController::class, 'my_hotel'])->name('my-hotel');
        Route::resource('/hotel-slider-banners', DashboardSliderBannerController::class);
        Route::get('/coupons', [DashboardCouponController::class, 'index'])->name('hotel.coupon.index');
        Route::post('/coupons', [DashboardCouponController::class, 'store'])->name('hotel.coupon.store');
        Route::put('/coupons/{coupon}', [DashboardCouponController::class, 'update'])->name('hotel.coupon.update');
        Route::delete('/coupons/{coupon}', [DashboardCouponController::class, 'destroy'])->name('hotel.coupon.destroy');

        Route::get('vendor/wallet',action: [HotelDashboardVendorBalanceController::class,'index']);

    Route::get('update-vendor-details', action: [HotelAdminController::class, 'updatevendordetails'])->name('hotel.updatevendordetails');
    Route::get('update-vendor-bank-details', action: [HotelAdminController::class, 'updatevendorbankdetails'])->name('hotel.updatevendorbankdetails');

    });
});

Route::get('/', [FrontendController::class, 'index'])->name('restaurant.index.page');

// Authentication Routes
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('login', [UserController::class, 'loginRegister'])->name('auth.login');
    Route::post('login', [UserController::class, 'userLogin'])->name('auth.login.submit');
    Route::post('register', [UserController::class, 'userRegister'])->name('auth.register');
    Route::match(['get', 'post'], 'forgot-password', [UserController::class, 'forgotPassword']);
    Route::get('google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->middleware('web');;

    Route::get('/verify-otp', [UserController::class, 'showOTPVerification'])->name('verify-otp');
    Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('user-verify-otp');

});

// User Account Routes (Requires Authentication)
Route::middleware('auth')->group(function () {
    Route::put('account', [UserController::class, 'userAccount'])->name('account.update');
    Route::post('/products/{product}/request-stock', [ProductRequestController::class, 'store'])->name('product.request-stock');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('thanks', [FrontProductController::class, 'thanks'])->name('thanks');

});
 Route::post('/forgot-password/send-otp', [ForgetPasswordController::class, 'sendOTPForReset'])->name('forgot.sendotp');
    Route::get('/verify-otp', [ForgetPasswordController::class, 'showOTPVerifyForm'])->name('forgot.verify.form');
    Route::post('/verify-otp', [ForgetPasswordController::class, 'verifyResetOTP'])->name('forgot.verify');
    Route::get('/reset-password', [ForgetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.form');
    Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('reset.password');

// Pages
Route::get('restaurants', [FrontendRestaurantController::class, 'index'])->name('restaurants');
Route::get('/restaurants/filter', [FrontendRestaurantController::class, 'filter'])->name('restaurants.filter');

// Route::get('ecommerce',[FrontendRestaurantController::class,'index'])->name('restaurants');
Route::prefix('/restaurant')->group(function () {
    Route::get('/{id}/detail', [FrontendRestaurantController::class, 'detail'])->name('restaurant.detail');
    Route::post('/restaurant/products/filter', function (Request $request) {
        $categoryId = $request->category_id;
        $restaurantId = $request->restaurant_id;
        $products = RestaurantProduct::where('restaurant_id', $restaurantId)
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })->get(['id', 'name', 'image', 'price']); // Fetch necessary fields only
        $products->transform(function ($product) {
            $product->final_price = $product->getFinalPrice();
            $product->encrypted_id = encrypt($product->id); // 🔐 Encrypt the ID

            return $product;
        });
        return response()->json(['products' => $products]);
    })->name('restaurant.products.filter');

    Route::get('/restaurant/filter-products', [FrontendRestaurantController::class, 'filterProducts'])->name('restaurant.filter.products');

    Route::get('/products', [FrontendProductController::class, 'filter'])->name('all-restaurant-products');
    Route::get('all-products', [FrontendProductController::class, 'index'])->name('all-restaurant-products-filter');
    Route::post('filter-all-products', [FrontendProductController::class, 'filterProducts'])->name('filter-restaurant-products');

    Route::get('product-detail/{id}', [FrontendProductController::class, 'detail'])->name('restaurant-product-detail');
    Route::get('categories', [FrontendCategoryController::class, 'index'])->name('restaurant.categories');
    Route::get('category/{id}', [FrontendCategoryController::class, 'detail'])->name('restaurant.categories.detail');
    Route::get('/search', [FrontendProductController::class, 'search'])->name('search');

    Route::get('/live-search', [FrontendProductController::class, 'liveSearch']);

    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('restaurant.cart.add');
    Route::get('/cart/update/{key}/{action}', [CartController::class, 'updateCart'])->name('restaurant.cart.update');;
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('restaurant.cart.count');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('restaurant.apply.coupon');
    Route::post('/apply-coupon-order-now', [CartController::class, 'applyCouponOrderNow'])->name('restaurant.apply.coupon.order.now');
    Route::get('/cart/remove/{key}', [CartController::class, 'removeFromCart']);
    Route::get('/get-product-sizes/{id}', [CartController::class, 'getProductSizes']);

    // for wishlist
    Route::middleware('auth')->group(function () {

        Route::post('/wishlist/add', [WishController::class, 'addToWishlist'])->name('restaurant.wishlist.add');
        Route::post('/wishlist/remove', [WishController::class, 'removeFromWishlist'])->name('restaurant.wishlist.remove');
        Route::get('/wishlist/count', function () {
            return response()->json(['count' => Auth::check() ? \App\Models\Restaurant\Wishlist::where('user_id', Auth::id())->count() : 0]);
        })->name('wishlist.count');

        Route::get('check-out', [CheckoutController::class, 'index'])->name('restaurant.checkout');
        Route::get('checkout/order-now',[CheckoutController::class, 'orderNowPage'])->name('restaurant.checkout.orderNowPage');
        Route::post('/checkout/order-now', [CheckoutController::class, 'orderNow'])->name('restaurant.checkout.orderNow');
        Route::post('order-now/checkout/applyCoupon', [CheckoutController::class, 'applyCoupon'])->name('restaurant.checkout.orderNow.applyCoupon');


        Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('restaurant.checkout.placeOrder');
        Route::post('/checkout/place-order-now', [CheckoutController::class, 'placeOrderNow'])->name('restaurant.checkout.placeOrderNow');        Route::get('/order/success/{order}', [FrontendOrderController::class, 'success'])->name('restaurant.order.success');
        Route::post('/order-receipt', [FrontendOrderController::class, 'receipt']);

        Route::get('/order/{order}/track', [FrontendOrderController::class, 'track'])->name('order.track');
    });

    Route::post('/rate-restaurant', [FrontendRatingController::class, 'store'])->name('restaurant.rate');
    Route::post('/rate-restaurant-product', [FrontendRatingController::class, 'product_rating_store'])->name('restaurant.product.rate');
});

Route::get('all-restaurant-products',[FrontendProductController::class,'fetchProducts'])->name('fetch.products');
Route::get('all-restaurants',[FrontendRestaurantController::class,'fetchRestaurant'])->name('fetch.restaurants');
Route::middleware('auth')->group(function () {
    Route::get('/count-ecommerce-wishlist', function () {
        return response()->json(['count' => Auth::check() ? \App\Models\Wishlist::where('user_id', Auth::id())->count() : 0]);
    })->name('count-ecommerce-wishlist');
    Route::post('/addresses', [UserDeliveryAddressController::class, 'store'])->middleware('auth');
    Route::get('/addresses', [UserDeliveryAddressController::class, 'index'])->middleware('auth');

    Route::delete('/addresses/{id}', [UserDeliveryAddressController::class, 'destroy'])->middleware('auth');

    Route::get('/my-delivery-addresses', [DeliveryAddressController::class, 'index'])->name('user.addresses.index');
    Route::delete('/user-addresses/{id}', [DeliveryAddressController::class, 'destroy'])->name('user.addresses.destroy');
    // account detail
    Route::put('user/account/update', [UserController::class, 'updateAccountDetails'])->name('user.account.update');
    // Route to update password
    Route::put('user-password/update', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::get('user/account/update', [UserController::class, 'createuserAccount'])->name('user.account.update.form');

    Route::get('/my-orders', [FrontendOrderController::class, 'index'])->name('user.orders');
    Route::get('/my-wishlist', [WishController::class, 'index'])->name('restaurant.wishlist.index');

    Route::post('/wishlist/remove', [WishController::class, 'remove'])->name('wishlist.remove');
    Route::post('/restaurant-wishlist/remove', [WishController::class, 'rremove'])->name('restaurant-wishlist/remove');



});

// routes/detail.php


// web.php
Route::post('/set-user-location', function (\Illuminate\Http\Request $request) {
    session([
        'user_lat' => $request->lat,
        'user_lng' => $request->lng
    ]);
    return response()->json(['status' => 'Location saved']);
});

Route::get('/restaurants/nearby', [FrontendRestaurantController::class, 'getNearbyRestaurants']);
Route::get('/states/{countryId}', [UserDeliveryAddressController::class, 'getRegions']);
Route::get('/cities/{stateId}', [UserDeliveryAddressController::class, 'getCities']);
Route::get('/sub-cities/{cityId}', [UserDeliveryAddressController::class, 'getSubCities']);
Route::get('/streets/{subCityId}', [UserDeliveryAddressController::class, 'getStreets']);

// hotel reservation

Route::prefix('/hotel')->group(function () {
    Route::get('/', [FrontendFrontendController::class, 'index'])->name('hotel-reservation.index');
    Route::get('categories', [HotelFrontendCategoryController::class, 'index'])->name('hotel.categories');

    Route::get('categories/{category}', [HotelFrontendCategoryController::class, 'show'])->name('hotel.category.detail');
    Route::get('{id}/detail', [FrontendHotelController::class, 'index'])->name('hotel.detail');
    Route::get('room/{id}/detail', [FrontendRoomController::class, 'index'])->name('hotel.room.detail');
    Route::get('discounted-hotels', [FrontendHotelController::class, 'discounted'])->name('discounted-hotels');
    Route::get('latest-hotels', [FrontendHotelController::class, 'latest'])->name('latest-hotels');
    Route::get('{id}/gallery', [FrontendHotelController::class, 'gallery'])->name('hotel.photo.gallery');
    Route::get('select-date/{id}', [FrontendHotelController::class, 'select_date'])->name('select_date');
    Route::get('rooms', [FrontendRoomController::class, 'indexs'])->name('room.indexs');
    Route::get('/rooms/filter', [FrontendRoomController::class, 'filter'])->name('rooms.filter');

    Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('check.availability');

    Route::middleware('auth')->group(function () {
        Route::post('/reservation/preview', [ReservationController::class, 'preview'])->name('reservation.preview');
        Route::post('/apply-coupon', [ReservationController::class, 'apply'])->name('hotel.coupons.apply');
        Route::post('/reserve', [ReservationController::class, 'store'])->name('reservation.store');
        Route::get('/reservation/confirmation', [ReservationController::class, 'confirmation'])->name('reservation.confirmation');
        // Route::get('my-reservation',[ReservationController::class, 'my_reservation'])->name('my.reservation');
        Route::post('/rate-hotel-room', [FrontendRoomController::class, 'room_rating_store'])->name('hotel.room.rate');
    });
    Route::get('/reservations/receipt', [ReservationsController::class, 'receipt'])->name('reservations.receipt');


});

Route::get('hotels', [FrontendHotelController::class, 'latest'])->name('hotels');
Route::get('nearby-hotels', [FrontendHotelController::class, 'nearby'])->name('nearby.hotels');
Route::get('/hotels/filter', [FrontendHotelController::class, 'filter'])->name('hotels.filter');
Route::get('/get-nearby-hotels', [FrontendHotelController::class, 'getNearbyHotels']);



// ecommerce
Route::prefix('/ecommerce')->group(function () {

    Route::get('/', [EcommerceFrontendFrontendController::class, 'index'])->name('ecommerce.index');
    Route::get('/categories', action: [FrontendCategoriesController::class, 'index'])->name('ecommerce.categories.index');
    Route::get('/category/{id}', [FrontendCategoriesController::class, 'show'])->name('ecommerce.category.show');
    Route::get('/products/latest', [ProductsController::class, 'latest'])->name('ecommerce.products.latest');
    Route::get('/products/featured', [ProductsController::class, 'featured'])->name('ecommerce.products.featured');
    Route::get('/flash-sales/products', [ProductsController::class, 'flash'])->name('ecommerce.products.flash.sales');
    Route::get('/product/{id}',[ProductsController::class, 'detail'])->name('ecommerce.product.detail');
    Route::get('/products/discounted', action: [ProductsController::class, 'discounted'])->name('ecommerce.products.discounted');
    Route::get('/all-products', [ProductsController::class, 'all'])->name('ecommerce.products.all');
    Route::get('/ecommerce/products/load', [ProductsController::class, 'fetchMore'])->name('ecommerce.products.load');

    Route::get('brand/{id}', [FrontendCategoriesController::class, 'bybrands'])->name('product_by_brands');

    Route::get('/vendors', [FrontendVendorController::class, 'index'])->name('ecommerce.vendors.index');
    Route::middleware('auth')->group(function () {
        Route::match(['GET', 'POST'], '/orders/{id}/cancel', [EcommerceFrontendOrderController::class, 'ordercancel']);
        Route::match(['GET', 'POST'], '/orders/{id}/return', [EcommerceFrontendOrderController::class, 'orderreturn']);
        Route::get('/orders/{id?}', [EcommerceFrontendOrderController::class, 'orders'])->name('ecommerce.order.detail');
        Route::get('/track-order/{id}',[EcommerceFrontendOrderController::class, 'track']);
    });

    Route::middleware('auth')->group(function () {

    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/checkout', [FrontendCheckoutController::class, 'showOrderSummary'])->name('ecommerce.checkout.summary');
    Route::post('/checkout', [FrontendCheckoutController::class, 'placeOrder'])->name('ecommerce.checkout.placeOrder');

    Route::post(uri: '/checkout/direct', action: [DirectCheckoutController::class, 'directCheckout'])->name('direct.checkout');
    Route::post('/checkout/direct/submit', [DirectCheckoutController::class, 'placeOrder'])->name('checkout.submit.direct');

    Route::post('/rate-ecommerce-product', [EcommerceFrontendRatingController::class, 'product_rating_store'])->name('ecommerce.product.rate');

        // routes/web.php
    Route::post('/calculate-shipping', [FrontendCheckoutController::class, 'calculateShipping']);

    Route::get('/products/filter', action: [FilterProductController::class, 'filter'])->name('products.filter');
    Route::get('/products/search', [FilterProductController::class, 'search'])->name('ecommerce.products.search');

    });
});


Route::get('blogs', [BlogController::class, 'index'])->name('display-blogs');
Route::get('blogs/details/{id}', [BlogController::class, 'details'])->name('blogs-details');
Route::post('store-blogs', [BlogController::class, 'store'])->name('store-blogs');
Route::match(['GET', 'POST'], '/contact', [FrontCmsController::class, 'contact']);

Route::get('page/{url}', [FrontendCmsController::class, 'pages'])->name('pages');
Route::post('/subscribe-newsletter', [NewslettersController::class, 'store']);
Route::post('/add-to-cart', [FrontendCartController::class, 'addToCart']);
Route::get('/my-cart', [CartController::class, 'viewCart'])->name('my.cart.view');
Route::get('/cart/count', function () {
    $sessionCount = \App\Helper\Helper::totalRestaurantCartItems();
    $helperCount = \App\Helper\Helper::totalCartItems();
    return response()->json([
        'session' => $sessionCount,
        'helper' => $helperCount,
        'total' => $sessionCount + $helperCount,
    ]);
})->name('cart.count');

Route::get('/vendor/detail/{vendorid}', [VendorsController::class, 'vendorListing']);

Route::get('track-custom-order', [CustomController::class, 'index'])->name('track-custom-order');
Route::match(['GET', 'POST'], 'check-custom-order', [CustomController::class, 'checkcustomorder'])->name('check_custom_order');
Route::get('/custom-orders/{id}', [CustomController::class, 'showOrderDetails'])->name('create_custom_order');

Route::get('register/vendor',[VendorRegistrationController::class,'index'])->name('vendor-register');
Route::post('/vendor/register', [VendorRegistrationController::class, 'RegisterVendor'])->name('vendor_register');
Route::get('/vendor/confirm/{code}', [VendorRegistrationController::class, 'confirmVendor'])->name('confirm_vendor');


Route::get('map',[MapController::class,'index'])->name('map');
Route::get('/api/reverse-geocode', [MapController::class, 'reverse']);
Route::get('/api/forward-geocode', [MapController::class, 'forward']);


Route::get('/orders/route-map', [OrderRouteMapController::class, 'show']);
Route::get('/order/route', [OrderRouteMapController::class, 'getRoute']);


Route::middleware('auth')->get('/check-notifications', function () {
    $count = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();

    return response()->json(['unread' => $count]);
});

Route::middleware('auth')->get('/notifications', function () {
    $notifications = \App\Models\Notification::where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->paginate(10); // 10 notifications per page

    // Mark unread notifications as read
    \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return view('all_frontend_layouts.notifications.index', compact('notifications'));
});

Route::get('/register/delivery-man', [RegisterDeliveryManController::class, 'create'])->name('delivery_man.registeration_page');
Route::post('/register_delivery_man', action: [RegisterDeliveryManController::class, 'store'])->name('delivery_man.register');


Route::get('notifications/delete/{id}',[NotificationController::class,'delete'])->name('delete-notification')->middleware('auth');


Route::get('/live-location', function () {
    // Replace this with dynamic DB/Redis fetch
    return response()->json([
        'lat' => 38.7492,
        'lng' => 8.9911
    ]);
});
