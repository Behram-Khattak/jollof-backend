<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true, 'register' => false]);

Route::get('{role:name}/register/{referal?}', 'Auth\RegisterController@showRegistrationForm')->name('register.create');

Route::post('{role:name}/register', 'Auth\RegisterController@register')->name('register.store');

Route::post('welcome/back', 'Auth\RegisterController@registerback')->name('register.welcome.store');

Route::get('account/setup', 'Auth\AccountSetupController@show')->name('account.setup')->middleware('signed');

Route::post('account/setup', 'Auth\AccountSetupController@setup')->name('account.setup.finish');
