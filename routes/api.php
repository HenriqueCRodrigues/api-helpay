<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('products')->group(function (){
    Route::post('', 'ProductController@store')->name('products.store');
    Route::get('', 'ProductController@list')->name('products.list');
    Route::get('{productId}', 'ProductController@show')->name('products.show');
    Route::delete('{productId}', 'ProductController@delete')->name('products.delete');
});

Route::prefix('purchase')->group(function (){
    Route::post('', 'OrderController@store')->name('orders.store');
});

Route::prefix('google')->group(function (){
    Route::get('callback', 'GoogleController@callback');
});