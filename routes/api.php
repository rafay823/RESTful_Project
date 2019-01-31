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

Route::group(['prefix' => 'api/v1'], function () {

    Route::Resource('Products','ProductController');
    Route::Resource('Products/discounts','PriceDiscountController');
    Route::Resource('Products/Price/Update','PriceUpdateController');
    Route::Resource('groups/make/bundle','GroupController');
    Route::Resource('Products/Order','ProductsOrderController');

});








