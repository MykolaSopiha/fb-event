<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api', 'as' => 'api.apps.'], function () {
    Route::get('send-events', ['uses' => 'EventController@send', 'as' => 'sendEvents']);
});
