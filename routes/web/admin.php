<?php

use App\Http\Controllers\Admin\JollofPointController;
use App\Http\Controllers\Admin\LayawayController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Merchant\ExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$roles = adminMiddlewareRoles();

Route::namespace('Admin')
    ->prefix('admin')
    ->name('admin.')
    ->middleware(['auth', "role:{$roles}"])
    ->group(function () {
        // Controllers Within The "App\Http\Controllers\Admin" Namespace

        Route::get('/', 'IndexController@index')->name('index');

        // Layaway routes
        Route::post('/layaway/settings', [LayawayController::class, 'settings'])->name('layaway.settings');
        Route::post('/jollofpoint/settings', [JollofPointController::class, 'settings'])->name('jollofpoint.settings');

        Route::get('setting-type/{settingType:slug}', 'SettingsController@index')->name('settings.index');

        Route::post('setting-type/{settingType:slug}', 'SettingsController@store')->name('settings.store');

        Route::get('setting-type/{settingType:slug}/{settings:slug}/edit', 'SettingsController@edit')->name('settings.edit');

        Route::patch('setting-type/{settingType:slug}/{settings:slug}', 'SettingsController@update')->name('settings.update');

        Route::resource('roles', 'RoleController')->parameters(['roles' => 'role:name']);

        Route::patch('roles/{role:name}/restore', 'RoleController@restore')->name('roles.restore');

        Route::get('audit', 'AuditController@index')->name('audit.index');

        Route::get('/users', 'UserController@index')->name('users.index');

        Route::get('/users/create/{role?}', 'UserController@create')->name('users.create');

        Route::post('/users', 'UserController@store')->name('users.store');

        Route::get('/users/{user:username}', 'UserController@show')->name('users.show');
        Route::get('/users/{user:username}/orders', 'UserController@orders')->name('users.orders');
        Route::get('/users/{user:username}/referrals', 'UserController@referrals')->name('users.referrals');
        Route::get('/users/{user:username}/reviews', 'UserController@reviews')->name('users.reviews');
        Route::get('/users/{user:username}/promos', 'UserController@promos')->name('users.promos');
        Route::get('/users/{user:username}/rewards', 'UserController@rewards')->name('users.rewards');

        Route::patch('/users/{user:username}', 'UserController@update')->name('users.update');

        Route::delete('/users/{user:username}', 'UserController@destroy')->name('users.destroy');

        Route::patch('users/{user:username}/restore', 'UserController@restore')->name('users.restore');

        Route::get('/businesses', 'BusinessController@index')->name('business.index');

        Route::get('/businesses/{business:slug}', 'BusinessController@show')->name('business.show');

        Route::patch('/business/{business:slug}/approve', 'BusinessReviewController@approve')->name('business.approve');

        Route::patch('/business/{business:slug}/unapprove', 'BusinessReviewController@unapprove')->name('business.unapprove');

        Route::patch('/business/{business:slug}/decline', 'BusinessReviewController@decline')->name('business.decline');

        Route::get('voucher', 'VoucherController@index')->name('voucher.index');
        Route::get('voucher/create', 'VoucherController@create');
        Route::post('voucher', 'VoucherController@store');
        Route::get('voucher/edit/{id}', 'VoucherController@edit');
        Route::patch('voucher/{id}', 'VoucherController@update');
        Route::delete('voucher/{id}', 'VoucherController@destroy');

        // Admin reviews rotues
        Route::get('reviews', 'IndexController@reviews')->name('admin.reviews');
        Route::get('reviews/{review}', 'IndexController@deleteReview')->name('review.delete');

        Route::get('notification', 'NotificationController@index')->name('notification.index');
        Route::get('notification/create', 'NotificationController@create');
        Route::post('notification', 'NotificationController@store');
        Route::get('notification/edit/{id}', 'NotificationController@edit');
        Route::patch('notification/{id}', 'NotificationController@update');
        Route::delete('notification/{id}', 'NotificationController@destroy');

        Route::get('/audit', 'AuditController@index');

        // Add fashion product categories
        Route::get('/extra', 'CategoryController@index')->name('fashioncategories.index');
        Route::get('/categories/create', 'CategoryController@create')->name('fashioncategories.create');
        Route::post('/categories/store', 'CategoryController@store')->name('fashioncategories.store');
        Route::get('fashioncategory/{categoryID}', 'CategoryController@getSubCategory')->name('fashion.category');
        Route::post('maincategory/add', 'CategoryController@addMainCategory');
        Route::post('material/add', 'CategoryController@addMaterial');
        Route::post('subcategory/add', 'CategoryController@addSubCategory');
        Route::post('subvariant/add', 'CategoryController@addSubVariant');

        Route::get('coupon', 'CouponController@index')->name('coupon.index');
        Route::get('coupon/create', 'CouponController@create');
        Route::post('coupon', 'CouponController@store');
        Route::get('coupon/edit/{id}', 'CouponController@edit');
        Route::patch('coupon/{id}', 'CouponController@update');
        Route::delete('coupon/{id}', 'CouponController@destroy');

        Route::post('admin/updateBanner', 'BannerController@updateBanner')->name('banner.update');

        // Promo resource route
        Route::get('promo', [PromoController::class, 'index']);
        Route::get('promo/create', [PromoController::class, 'create']);
        Route::post('promo', [PromoController::class, 'store']);
        Route::get('promo/edit/{promo}', [PromoController::class, 'edit']);
        Route::patch('promo/{promo}', [PromoController::class, 'update']);
        Route::delete('promo/{promo}', [PromoController::class, 'destroy']);


        // Banner - Slider routes
        Route::get('slider', 'SliderController@index');
        Route::get('slider/p/{any}', 'SliderController@microsite');
        Route::get('slider/create/{any}', 'SliderController@create');
        Route::post('slider', 'SliderController@store');
        Route::get('slider/{id}', 'SliderController@show');
        Route::get('slider/edit/{id}', 'SliderController@edit');
        Route::patch('slider/{id}', 'SliderController@update');
        Route::delete('slider/{id}', 'SliderController@destroy');
        Route::delete('slider/slide/{id}/{index}', 'SliderController@destroy_slide');

        // Banner - Advert routes
        Route::get('advert', 'AdvertController@index');
        Route::get('advert/p/{any}', 'AdvertController@microsite');
        Route::get('advert/create/{any}', 'AdvertController@create');
        Route::post('advert', 'AdvertController@store');
        Route::get('advert/{id}', 'AdvertController@show');
        Route::get('advert/edit/{id}', 'AdvertController@edit');
        Route::patch('advert/{id}', 'AdvertController@update');
        Route::delete('advert/{id}', 'AdvertController@destroy');
        Route::delete('advert/ad/{id}/{index}', 'AdvertController@destroy_advert');

        // Banner - Popup routes
        Route::get('popup', 'PopupController@index');
        Route::get('popup/p/{any}', 'PopupController@microsite');
        Route::get('popup/create/{any}', 'PopupController@create');
        Route::post('popup', 'PopupController@store');
        Route::get('popup/{id}', 'PopupController@show');
        Route::get('popup/edit/{id}', 'PopupController@edit');
        Route::patch('popup/{id}', 'PopupController@update');
        Route::delete('popup/{id}', 'PopupController@destroy');
        Route::delete('popup/pop/{id}/{index}', 'PopupController@destroy_popup');

        Route::get('home-images', 'BannerController@homeImages');
        Route::post('home-images/update', 'BannerController@updateImage')->name('home.image.update');

        Route::get('restaurants', 'RestaurantController@index');
        Route::get('restaurant/create', 'RestaurantController@create');
        Route::post('restaurant', 'RestaurantController@store');
        Route::get('restaurant/{id}', 'RestaurantController@show');
        Route::get('restaurant/edit/{id}', 'RestaurantController@edit');
        Route::patch('restaurant/{id}', 'RestaurantController@update');
        Route::delete('restaurant/{id}', 'RestaurantController@destroy');
        Route::post('restaurant/upload/{id}', 'RestaurantController@upload')->name('restaurant.upload');

        Route::post('restaurant/create_category', 'CuisineCategoryController@store');
        Route::patch('restaurant/update_category/{id}', 'CuisineCategoryController@update');
        Route::delete('restaurant/delete_category/{id}', 'CuisineCategoryController@destroy');

        Route::post('restaurant/create_consumable', 'ConsumableController@store');
        Route::patch('restaurant/update_consumable/{id}', 'ConsumableController@update');
        Route::delete('restaurant/delete_consumable/{id}', 'ConsumableController@destroy');

        Route::get('restaurant/create_menu/{id}', 'CuisineMenusController@create');
        Route::post('restaurant/create_menu/{id}', 'CuisineMenusController@store');
        Route::patch('restaurant/update_menu/{id}', 'CuisineMenusController@update');
        Route::delete('restaurant/delete_menu/{id}', 'CuisineMenusController@destroy');

        Route::get('locations', 'LocationController@index')->name('locations');
        Route::post('locations', 'LocationController@store')->name('location.store');
        Route::get('location/{id}', 'LocationController@show')->name('location.show');
        Route::patch('location', 'LocationController@update')->name('location.update');
        Route::post('location/create_area/{id}', 'LocationController@store_area')->name('location.create');
        Route::delete('location/delete/area', 'LocationController@delete_area')->name('location.delete');
        Route::get('location/p/json', 'LocationController@json');

        Route::get('orders', 'OrdersController@index')->name('orders.index');
        Route::get('order/{code}', 'OrdersController@details')->name('order.details');
        Route::patch('order/update', 'OrdersController@update')->name('order.update');

        Route::get('shipping', 'ShippingController@index')->name('shipping');
        Route::get('shipping/state/{id}', 'ShippingController@state')->name('shipping.state');
        Route::get('shipping/create/{id}', 'ShippingController@create')->name('shipping.create');
        Route::post('shipping/store', 'ShippingController@store')->name('shipping.store');

        Route::post('vat/update', 'ShippingController@vat')->name('vat.update');

        Route::get('referals', 'ReferalController@index')->name('referal');
        Route::post('referals', 'ReferalController@sendReward')->name('post.referal');

        Route::get('report', 'ReportController@index')->name('report');
        Route::post('report/filter', 'ReportController@filter')->name('report.filter');

        Route::get('billing', 'BillingController@index')->name('billing');
        Route::post('billing/update', 'BillingController@update')->name('billing.update');
        Route::post('billing/{business:slug}', 'BillingController@show')->name('billing.details');
        Route::post('billing/{business:slug}/payout', 'BillingController@payout')->name('billing.payout');
        Route::get('billing/{business:slug}/history', 'BillingController@history')->name('billing.history');
        Route::get('billing/{business:slug}/completed', 'BillingController@completed')->name('billing.payout.completed');

        Route::get('welcomeback', 'UserController@move_users')->name('welcome.back.users');

        // Export routes
        Route::get('export/order/{format}', [ExportController::class, 'adminOrderExport']);
        Route::get('export/users/{format}', [ExportController::class, 'adminUsersExport']);
        Route::get('export/billing/csv/{business}/{start}/{end}', [ExportController::class, 'billingExportCsv'])->name('billing.export.csv');
        Route::get('export/billing/excel/{business}/{start}/{end}', [ExportController::class, 'billingExportExcel'])->name('billing.export.excel');
        Route::get('export/report/{format}/{start}/{end}/{business}/{payment}', [ExportController::class, 'report'])->name('export.report');

        // Error logs routes
        Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('error.logs');
        // Route::middleware(['auth', 'permission:read-error-logs'])->group(function () {
            // Route::get('logs', 'LogViewerController@index');
        // });
    });
