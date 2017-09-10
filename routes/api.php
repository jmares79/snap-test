<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/snap/promotion/create', 'PromotionController@create')->name('create-promotion');
Route::post('/snap/checkout/scan/{itemId}', 'CheckoutController@scanItem')->name('scan-item');
Route::get('/snap/total', 'CheckoutController@getTotal')->name('get-total');
