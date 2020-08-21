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

/**
 * 总览页图表数据api路由组
 */
Route::namespace('Api')->prefix('homeChart')->group( function () {
    Route::post( "/{app_id}/byte_click", "HomeChartController@byte_click" )->where('app_id', "\w+")->name( 'home_chart_byte_click' );
    Route::post( "/{app_id}/app_init", "HomeChartController@app_init" )->where('app_id', "\w+")->name( 'home_chart_app_init' );
    Route::post( "/{app_id}/activation", "HomeChartController@activation" )->where('app_id', "\w+")->name( 'home_chart_activation' );
    Route::post( "/{app_id}/active", "HomeChartController@active" )->where('app_id', "\w+")->name( 'home_chart_active' );
    Route::post( "/{app_id}/oneRetained", "HomeChartController@oneRetained" )->where('app_id', "\w+")->name( 'home_chart_oneRetained' );
    Route::post( "/{app_id}/channel", "HomeChartController@channel" )->where('app_id', "\w+")->name( 'home_chart_channel' );
    Route::post( "/{app_id}/click_type", "HomeChartController@click_type" )->where('app_id', "\w+")->name( 'home_chart_click_type' );
    Route::post( "/{app_id}/click_site", "HomeChartController@click_site" )->where('app_id', "\w+")->name( 'home_chart_click_site' );
} );
