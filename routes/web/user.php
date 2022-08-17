<?php

use App\Http\Controllers\CacheController;
use App\Http\Controllers\Merchant\ExportController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\LayawayController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('User')->group(function () {
    // Controllers Within The "App\Http\Controllers\User" namespace
    // Route::view('/', 'landing');

    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/myaccount', 'MyAccountController@myaccount')->name('myaccount');
    Route::get('/myaccount/order', 'MyAccountController@order')->name('myaccount.order');
    Route::get('myaccount/order/{any}', 'MyAccountController@orderdetails')->name('myaccount.order.details');
    Route::get('/order', 'MyAccountController@order')->name('orders');
    Route::get('/order/{any}', 'MyAccountController@orderdetails')->name('order.details');
    Route::get('/myaccount/vendors', 'MyAccountController@vendors')->name('myaccount.vendors');
    Route::get('/myaccount/reviews', 'MyAccountController@reviews')->name('myaccount.reviews');
    Route::get('myaccount/referals', 'ReferController@index')->name('refer.dashboard');
    Route::get('myaccount/refer/friend', 'MyAccountController@referafriend')->name('myaccount.refer.friend');
    Route::get('myaccount/layaway', 'MyAccountController@layaway')->name('myaccount.layaway');
    Route::get('myaccount/layaway/topup/{order_code}', 'MyAccountController@layawaytopform')->name('layaway.topup');
    Route::post('myaccount/layaway/topup', 'MyAccountController@layawaytopup')->name('layaway.topup.now');
    Route::get('myaccount/layaway/extend/{layaway_id}/{weeks}', 'MyAccountController@extendLayaway')->name('layaway.extend');
    Route::get('myaccount/settings/profile', 'MyAccountController@profile')->name('myaccount.settings.profile')->middleware('auth');
    Route::get('/rave/layawaytopup/callback/{order_code}', 'MyAccountController@layawaytopupcallback')->name('layaway.topup.callback');
    Route::get('cuisine', 'RestaurantController@index')->name('restaurant.index');

    Route::get('restaurant/{any}', 'RestaurantController@show')->name('restaurant.show');

    Route::post('restaurant/search', 'RestaurantController@search')->name('restaurant.search');

    Route::post('restaurant/booking', 'RestaurantController@booking')->name('restaurant.booking');

    Route::post('restaurant/review', 'RestaurantController@review')->name('restaurant.review');

    Route::get('fashion', 'FashionHomepageController@index')->name('fashion.index');

    // Layaway routes
    Route::get('fashion/layaway', [LayawayController::class, 'index'])->name('fashion.layaway.index');
    Route::get('fashion/layaway/product/{slug}', [LayawayController::class, 'show'])->name('fashion.layaway.product.show');

    Route::post('fashion/layaway/pay', [LayawayController::class, 'pay'])->name('fashion.layaway.pay');
    Route::get('/rave/callback/{order_code}', [LayawayController::class, 'callback'])->name('layaway.callback');

    Route::get('fashion/all-stores', 'FashionHomepageController@allStores')->name('fashion.store.avenue');

    Route::get('fashion/all-products', 'FashionHomepageController@allProducts')->name('fashion.all_products');

    Route::get('fashion/new-arrivals', 'FashionHomepageController@newArrivals')->name('fashion.new_arrivals');

    Route::get('fashion/{business:slug}', 'FashionHomepageController@fashionStore')->name('fashion.store.show');

    Route::get('fashion/{category:slug}', 'FashionCategoryController@index')->name('fashion.category.index');

    Route::get('fashion/product/{fashionProduct:slug}', 'FashionProductController@show')->name('fashion.product.show');

    Route::get('fashion/{categorySlug}/{subcategorySlug}', 'FashionCategoryController@show')->name('fashion.category.show');

    Route::post('fashion/search', 'FashionHomepageController@search')->name('fashion.search');

    Route::post('fashion/search/filter', 'FashionHomepageController@searchfilters')->name('fashion.search.filter');

    Route::post('fashion/store/search', 'FashionHomepageController@searchStore')->name('fashion.store.search');

    Route::post('fashion/post/cart', 'FashionProductController@postCart')->name('fashion.cart.post');

    // Route::get('restaurant/get/toppings', 'RestaurantController@toppings_ajax')->name('restaurant.toppings');
    Route::get('restaurant/add/cart/{id}', 'CartController@addCart')->name('cart.add');

    Route::post('restaurant/post/cart', 'CartController@postCart')->name('cart.post');

    Route::post('restaurant/update/cart', 'CartController@updateCart')->name('cart.update');

    Route::get('restaurant/get/toppings/{id}', 'CartController@getToppings')->name('cart.get.toppings');

    Route::get('restaurant/reduce/cart/{id}', 'CartController@reduceCart')->name('cart.reduce');

    Route::get('restaurant/remove/cart/{id}', 'CartController@removeCart')->name('cart.remove');

    Route::get('restaurant/get/cart', 'CartController@getCart')->name('cart.get');

    Route::get('cart/checkout', 'CartController@checkout')->name('cart.checkout');

    Route::get('cart/show', 'CartController@show')->name('cart.show');

    Route::get('cart/checkout/review', 'CartController@checkout_review')->name('cart.checkout.review');

    Route::get('cart/shipping/review', 'CartController@shipping_review')->name('cart.shipping.review');

    Route::post('cart/place/order', 'CartController@place_order')->name('cart.place.order');

    Route::get('cart/order/summary/{code}/{any?}', 'CartController@summary')->name('cart.order.summary');

    Route::get('cart/order/pay/{code}', 'CartController@pay')->name('cart.order.pay');

    Route::get('cart/order/completed/{code}', 'CartController@complete')->name('cart.order.complete');

    Route::get('cart/order/processing/{code}', 'CartController@processing')->name('cart.order.processing');

    Route::get('cart/check/order/{code}', 'CartController@checkOrder')->name('cart.check.order');

    Route::post('cart/get/shippingCost', 'CartController@getShippingCost')->name('get.shipping.cost');

    // Route::get('orders', 'OrdersController@list')->name('orders.list');

    // Route::get('order/{any}', 'OrdersController@details')->name('order.details');

    Route::delete('order/delete/{id}', 'OrdersController@destroy')->name('order.destroy');
    Route::middleware(['auth'])
    ->group(function() {
        Route::get('dispatch/orders', 'DispatchController@index')->name('dispatch.orders.index');

        Route::get('dispatch/completed', 'DispatchController@completed')->name('dispatch.orders.completed');

        Route::get('dispatch/pickedup', 'DispatchController@pickedup')->name('dispatch.orders.pickedup');

        Route::get('dispatch/order/{code}', 'DispatchController@details')->name('dispatch.order.details');

        Route::patch('dispatch/order/update', 'DispatchController@update')->name('dispatch.order.update');

        Route::get('dispatch/export/order/{format}', [ExportController::class, 'DispatchExport'])->name('dispatch.export.order');
    });


    Route::post('pay/for/me/', 'CartController@payforme')->name('pay.for.me');

    Route::get('settings/shipping', 'SettingsController@shipping')->name('user.settings.shipping')->middleware('auth');

    Route::post('settings/shipping', 'SettingsController@storeShipping')->name('user.settings.shipping.store')->middleware('auth');

    Route::get('settings/profile', 'SettingsController@profile')->name('user.settings.profile')->middleware('auth');

    Route::post('settings/profile', 'SettingsController@updateProfile')->name('user.settings.update.profile')->middleware('auth');

    Route::post('settings/password', 'SettingsController@updatePassword')->name('user.settings.update.password')->middleware('auth');

    Route::get('settings/password/view', 'SettingsController@password')->name('user.settings.password')->middleware('auth');

    Route::post('cart/get/coupon', 'CartController@coupon')->name('get.coupon.cuisine');

    Route::get('cart/remove/coupon/{id}/{any}', 'CartController@removeCoupon')->name('remove.coupon.cuisine');

    Route::get('cart/seemail/{any}', 'CartController@seemail');

    // Route::get('referals', 'ReferController@index')->name('refer.dashboard');
});

Route::get('welcome/{code}', 'PagesController@welcome')->name('welcome');

Route::get('privacy-policy', 'PagesController@privacy')->name('privacy_policy');

Route::get('terms-and-conditions', 'PagesController@terms')->name('terms_and_conditions');

Route::get('cancellation-and-refund', 'PagesController@refund')->name('cancellation.and.refund');

Route::get('faq', 'PagesController@faq')->name('faq');

Route::get('contact', 'PagesController@contact')->name('contact');

Route::post('contact', 'PagesController@sendcontact')->name('contact.post');

Route::post('subscribe', 'PagesController@subscribe')->name('newsletter.post');

Route::get('refer/friend', 'ReferController@index')->name('refer.friend');

Route::post('refer/friend', 'ReferController@sendrefer')->name('send.refer.friend');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('email/view', 'PagesController@mail');

Route::get('paystack/verify/{reference}/{trans_id}/{status}/{message}/{code}', [CartController::class, 'verifyWithPaystack'])->name('paystack.verity');

// clearing cache route
Route::get('clearcache', [CacheController::class, 'clear']);

