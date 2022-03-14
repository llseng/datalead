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
    Route::get( "/{app_id}/app_click_byte", "ReceiverController@app_click_byte" )->where('app_id', "\w+")->name( 'app_click_byte' );
    Route::get( "/{app_id}/app_click_kuaishou", "ReceiverController@app_click_kuaishou" )->where('app_id', "\w+")->name( 'app_click_kuaishou' );
    Route::get( "/{app_id}/app_click_txad", "ReceiverController@app_click_txad" )->where('app_id', "\w+")->name( 'app_click_txad' );
    Route::get( "/{app_id}/app_click_huawei", "ReceiverController@app_click_huawei" )->where( 'app_id', "\w+")->name("app_click_huawei");
} );

/**
 * 监听Api路由组
 */
Route::namespace('Api')->prefix('listen')->group( function () {
    Route::get( "/app_init/{app_id}", "ListenController@app_init" )->where('app_id', "\w+")->name( 'app_init' );
    Route::get( "/{app_id}/app_init", "ListenController@app_init" )->where('app_id', "\w+")->name( 'app_init_v2' );
    Route::get( "/{app_id}/app_action", "ListenController@app_action" )->where('app_id', "\w+")->name( 'app_action' );
} );

/**
 * 总览页图表数据api路由组
 */
Route::namespace('Api')->prefix('homeChart')->group( function () {
    Route::post( "/{app_id}/click", "HomeChartController@click" )->where('app_id', "\w+")->name( 'home_chart_click' );
    Route::post( "/{app_id}/app_init", "HomeChartController@app_init" )->where('app_id', "\w+")->name( 'home_chart_app_init' );
    Route::post( "/{app_id}/activation", "HomeChartController@activation" )->where('app_id', "\w+")->name( 'home_chart_activation' );
    Route::post( "/{app_id}/active", "HomeChartController@active" )->where('app_id', "\w+")->name( 'home_chart_active' );
    Route::post( "/{app_id}/oneRetained", "HomeChartController@oneRetained" )->where('app_id', "\w+")->name( 'home_chart_oneRetained' );
    Route::post( "/{app_id}/channel", "HomeChartController@channel" )->where('app_id', "\w+")->name( 'home_chart_channel' );
} );

/**
 * 应用日志Api路由组
 */
Route::namespace("Api")->prefix('appLog')->group( function () {
    Route::get( "/{app_id}/adinfo", "AppLogController@adinfo_v2" )->where('app_id', "\w+")->name( 'applog_adinfo' );
    Route::get( "/{app_id}/adinfo_v2", "AppLogController@adinfo_v2" )->where('app_id', "\w+")->name( 'applog_adinfo_v2' );
    Route::get( "/{app_id}/sort_names", "AppLogController@sort_names" )->where('app_id', "\w+")->name( 'applog_sort_names' );
    Route::match(['get', 'post'], "/{app_id}/search_adinfo", "AppLogController@search_adinfo" )->where('app_id', "\w+")->name( 'applog_search_adinfo' );
} );
