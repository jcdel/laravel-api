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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* Login and Register Route **/
Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

});


/** Api Routes with Authentication */
Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'middleware' => 'auth:api'], function() {

    Route::post('logout', 'Api\AuthController@logout');

    Route::apiResource('customers', 'CustomerController');
    
    Route::group(['prefix' => 'customers'],function(){
        Route::get('/{id}/orders',[
            'uses' => 'CustomerController@orders',
            'as' => 'customers.orders',
        ]);

        Route::post('/{customer_id}/orders/{order_id}',[
            'uses' => 'CustomerController@order',
            'as' => 'orders.details',
        ]);

        Route::post('/{id}/orders',[
            'uses' => 'CustomerController@order',
            'as' => 'customers.orders',
        ]);
    });
    
    Route::apiResource('inventories', 'InventoryController');
    Route::apiResource('orders', 'OrderController');

});
