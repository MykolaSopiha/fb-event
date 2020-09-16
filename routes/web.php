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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resources([
    'fb-apps' => 'FbAppController',
    'fb-app-events' => 'FbAppEventController',
]);

Route::get('fb-apps/{fb_app}/logs', 'FbAppController@logs')->name('fb-apps.logs');
Route::get('fb-app-events/{fb_app_event}/logs', 'FbAppEventController@logs')->name('fb-app-events.logs');
