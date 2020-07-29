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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/game', 'GameAppController@index')->name('game');
Route::get('/game/create', 'GameAppController@create')->name('game_create');
Route::get('/game/select/{id}', 'GameAppController@select')->name('game_select');
Route::get('/game/update/{id}', 'GameAppController@update')->name('game_update');
Route::get('/game/delete/{id}', 'GameAppController@delete')->name('game_delete');
Route::post('/game/dealwith', 'GameAppController@dealwith')->name('game_dealwith');
