<?php

use App\Http\Controllers\Merchant\ExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Merchant Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web merchant routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$roles = merchantMiddlewareRoles();

Route::namespace('Merchant')
    ->prefix('merchant')
    ->name('merchant.')
    ->middleware(['auth', "role:{$roles}", "verified"])
    ->group(function () {
        // Controllers Within The "App\Http\Controllers\Merchant" Namespace

        Route::get('/', 'IndexController@index')->middleware('verified')->name('index');
        Route::get('fashion/delete/{id}', 'FashionProductController@delete')->name('fashion.delete');

        Route::get('orders', 'OrdersController@index')->name('restaurant.orders');
        Route::get('pending', 'OrdersController@pending')->name('restaurant.pending');
        Route::get('preorders', 'OrdersController@preorders')->name('restaurant.preorders');
        Route::get('order/{code}', 'OrdersController@details')->name('restaurant.order.details');
        Route::patch('order/update', 'OrdersController@update')->name('restaurant.order.update');
        Route::get('orders/processed', 'OrdersController@processed')->name('restaurant.orders.processed');
        Route::get('orders/picked', 'OrdersController@picked')->name('restaurant.orders.picked');
        Route::get('orders/delivered', 'OrdersController@delivered')->name('restaurant.orders.delivered');

        Route::get('report', 'ReportController@index')->name('report');
        Route::post('report/filter', 'ReportController@filter')->name('report.filter');

        Route::prefix('business')->group(function () {
            Route::get('/create', 'BusinessController@create')->name('business.create');

            Route::post('/', 'BusinessController@store')->name('business.store');

            Route::get('{business:slug}', 'BusinessController@show')->name('business.show');

            Route::patch('{business:slug}', 'BusinessController@update')->name('business.update');

            Route::get('{business:slug}/locations', 'BusinessLocationController@index')->name('business.location.index');

            Route::post('{business:slug}/locations', 'BusinessLocationController@store')->name('business.location.store');

            Route::post('{business:slug}/logo', 'BusinessImageController@logo')->name('business.logo.store');

            Route::post('{business:slug}/banner', 'BusinessImageController@banner')->name('business.banner.store');

            Route::get('{business:slug}/kyc', 'BusinessKycController@create')->name('business.kyc.create');

            Route::post('{business:slug}/kyc', 'BusinessKycController@store')->name('business.kyc.store');

            Route::post('{business:slug}/approval', 'BusinessController@requestApproval')->name('business.approval');

            Route::get('{business:slug}/teams', 'TeamController@index')->name('teams.index');

            Route::post('{business:slug}/teams', 'TeamController@store')->name('teams.store');

            Route::get('{business:slug}/reviews', 'IndexController@review')->name('review');

            Route::get('{business:slug}/teams/{team:slug}', 'TeamController@show')->name('teams.show');

            Route::patch('{business:slug}/teams/{team:slug}', 'TeamController@update')->name('teams.update');

            Route::post('teams/{team:slug}/members', 'TeamMemberController@store')->name('teams_members.store');

            Route::get('teams/{team:slug}/members/{username}', 'TeamMemberController@show')->name('teams_members.show');

            Route::patch('teams/{team:slug}/members/{user:username}', 'TeamMemberController@update')->name('teams_members.update');

            Route::delete('teams/{team:slug}/members/{user:username}', 'TeamMemberController@destroy')->name('teams_members.destroy');

            Route::patch('teams/{team:slug}/members/{username}/restore', 'TeamMemberController@restore')->name('teams_members.restore');
        });

        Route::prefix('user')->group(function () {
            Route::get('', 'UserController@show')->name('profile.show');

            Route::patch('', 'UserController@update')->name('profile.update');

            Route::post('/photo', 'MerchantProfilePictureController')->name('photo.store');
        });


        Route::prefix('settings')->group(function () {
            Route::get('password', 'UserPasswordController@edit')->name('password.edit');

            Route::patch('password', 'UserPasswordController@update')->name('password.update');
        });

        Route::get('fashioncategory/{categoryID}', 'FashionProductController@getSubCategory')->name('fashion.category');
        Route::post('fashion/upload/media', 'FashionProductController@storeMedia')->name('fashion.media');
        Route::get('fashion/get/media/{id}', 'FashionProductController@getMedia')->name('fashion.get.media');

        Route::prefix('fashion/{business:slug}')->group(function () {
            Route::get('products', 'FashionProductController@index')->name('fashion.index');

            Route::get('products/create', 'FashionProductController@create')->name('fashion.create');

            Route::post('products', 'FashionProductController@store')->name('fashion.store');

            Route::get('products/{fashionProduct:slug}', 'FashionProductController@edit')->name('fashion.edit');


            Route::patch('products/{fashionProduct:slug}', 'FashionProductController@update')->name('fashion.update');
        });

        Route::prefix('{business:slug}')->group(function () {
            Route::get('/', 'RestaurantController@index')->name('restaurants');
            Route::get('/settings', 'RestaurantSettingsController@index')->name('restaurant.settings');
            Route::patch('/settings', 'RestaurantSettingsController@update')->name('restaurant.setting.update');
            Route::get('category', 'RestaurantController@category')->name('restaurant.category');
            Route::get('menu', 'RestaurantController@menu')->name('restaurant.menu');
            Route::get('create_menu', 'CuisineMenusController@create')->name('restaurant.create.menu');
            Route::post('create_menu', 'CuisineMenusController@store')->name('restaurant.store.menu');
            Route::get('update_menu/{id}', 'CuisineMenusController@edit')->name('restaurant.edit.menu');
            Route::patch('update_menu', 'CuisineMenusController@update')->name('restaurant.update.menu');
            Route::delete('delete_menu/{id}', 'CuisineMenusController@destroy')->name('restaurant.delete.menu');

            Route::post('create_category', 'CuisineCategoryController@store')->name('restaurant.create.category');
            Route::patch('update_category/{id}', 'CuisineCategoryController@update')->name('restaurant.edit.category');
            Route::delete('delete_category/{id}', 'CuisineCategoryController@destroy')->name('restaurant.delete.category');
        });

        // Export routes
        Route::get('export/order/{format}',[ExportController::class, 'AllOrder']);
        Route::get('export/report/{format}/{start}/{end}/{business}/{payment}',[ExportController::class, 'report'])->name('export.report');
    });
