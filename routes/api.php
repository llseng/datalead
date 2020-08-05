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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 接受Api路由组
 */
Route::namespace('Api')->prefix('receiver')->group( function () {
    Route::get( "/byte_click/{app_id}", "ReceiverController@byte_click" )->where('app_id', "\w+")->name( 'byte_click' );
    Route::get( "/byte_click_v2/{app_id}", "ReceiverController@byte_click_v2" )->where('app_id', "\w+")->name( 'byte_click_v2' );
    Route::get( "/byte_show/{app_id}", "ReceiverController@byte_show" )->where('app_id', "\w+")->name( 'byte_show' );
} );

/**
 * 监听Api路由组
 */
Route::namespace('Api')->prefix('listen')->group( function () {
    Route::get( "/app_init/{app_id}", "ListenController@app_init" )->where('app_id', "\w+")->name( 'app_init' );
} );
