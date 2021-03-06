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

Route::get('/', 'LandingController@index');

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'BackendController@index');
    Route::resource('kategori', 'Backend\CategoryController');
    Route::resource('gudang', 'Backend\WarehouseController');
    Route::resource('rak', 'Backend\ShelfController');
});

Route::get('/home', 'HomeController@index')->name('home');
