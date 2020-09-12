<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('home')->group( function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::prefix('game')->group( function () {
    Route::get('/', 'GameAppController@index')->name('game');
    Route::get('/create', 'GameAppController@create')->name('game_create');
    Route::get('/select/{id}', 'GameAppController@select')->where("id", "\w+")->name('game_select');
    Route::get('/update/{id}', 'GameAppController@update')->where("id", "\w+")->name('game_update');
    Route::get('/delete/{id}', 'GameAppController@delete')->where("id", "\w+")->name('game_delete');
    Route::post('/dealwith', 'GameAppController@dealwith')->name('game_dealwith');
    Route::get('/info/{id}', 'GameAppController@info')->where("id", "\w+")->name('game_info');
} );

Route::prefix('user')->group( function () {
    Route::get('/', 'UserController@index')->name('user');
    Route::post('/reset_pwd', 'UserController@reset_pwd')->name('user_reset_pwd');
    Route::post('/dealwith', 'UserController@dealwith')->name('user_dealwith');
} );

Route::prefix('callback')->group( function () {
    Route::get('/', 'CallbackController@index')->name('callback');
    Route::get('/info', 'CallbackController@info')->name('callback_info');
    Route::get('/handle', 'CallbackController@handle')->name('callback_handle');
    Route::get('/delete', 'CallbackController@delete')->name('callback_delete');
} );

Route::prefix('log_stream')->group( function () {
    Route::get('/byteshow', 'LogStreamController@byteshow')->name('log_stream_byteshow');
    Route::get('/byteclick', 'LogStreamController@byteclick')->name('log_stream_byteclick');
    Route::get('/inits', 'LogStreamController@inits')->name('log_stream_inits');
    Route::get('/users', 'LogStreamController@users')->name('log_stream_users');
} );

Route::prefix('test')->group( function(){
    Route::get('/', "Test@index");
} );
