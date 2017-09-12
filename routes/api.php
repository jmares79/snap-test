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
Route::post('/snap/checkout/scan', 'CheckoutController@scanItem')->name('scan-item');
Route::post('/snap/product/create', 'ProductController@create')->name('create-product');
Route::get('/snap/total', 'CheckoutController@getTotal')->name('get-total');
