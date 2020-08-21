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
    Route::post( "/byte_click/{app_id}", "HomeChartController@byte_click" )->where('app_id', "\w+")->name( 'home_chart_byte_click' );
    Route::post( "/app_init/{app_id}", "HomeChartController@app_init" )->where('app_id', "\w+")->name( 'home_chart_app_init' );
    Route::post( "/activation/{app_id}", "HomeChartController@activation" )->where('app_id', "\w+")->name( 'home_chart_activation' );
    Route::post( "/active/{app_id}", "HomeChartController@active" )->where('app_id', "\w+")->name( 'home_chart_active' );
    Route::post( "/oneRetained/{app_id}", "HomeChartController@oneRetained" )->where('app_id', "\w+")->name( 'home_chart_oneRetained' );
    Route::post( "/channel/{app_id}", "HomeChartController@channel" )->where('app_id', "\w+")->name( 'home_chart_channel' );
    Route::post( "/click_type/{app_id}", "HomeChartController@click_type" )->where('app_id', "\w+")->name( 'home_chart_click_type' );
    Route::post( "/click_site/{app_id}", "HomeChartController@click_site" )->where('app_id', "\w+")->name( 'home_chart_click_site' );
} );
