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

Auth::routes();
Route::get('/', 'PagesController@index');

/**
 * --------------------------------------------------------------------------
 * Admin Routes
 * --------------------------------------------------------------------------
 */

Route::get('/admin/login', 'Admin\AdminController@login')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function() {
    Route::get('/admin', 'AdminController@index');
    
    // Cities
    Route::get('/admin/miasta', 'CitiesController@index')->name('admin.cities');
    Route::get('/admin/miasta/dodaj', 'CitiesController@create')->name('admin.cities.create');
    Route::post('/admin/miasta', 'CitiesController@store')->name('admin.cities.store');
    Route::get('/admin/{city}/edit', 'CitiesController@edit')->name('admin.cities.edit');
    
    // Adverts
    Route::get('/admin/pokoje', 'AdvertsController@index')->name('admin.adverts');
    Route::get('/admin/pokoje/dodaj', 'AdvertsController@create')->name('admin.adverts.create');
    Route::post('/admin/pokoje', 'AdvertsController@store')->name('admin.adverts.store');
    Route::get('/admin/{city}/{advert}/edytuj', 'AdvertsController@edit')->name('admin.adverts.edit');
});

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

Route::get('/pokoje', 'AdvertsController@index'); // Display all adverts.

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // Adverts actions
    Route::post('/pokoje', 'AdvertsController@store');
    Route::get('/pokoje/edytuj/{advert}', 'AdvertsController@edit'); // Edit advert.
});

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

Route::get('/miasta', 'CitiesController@index');
Route::get('/{city}', 'CitiesController@show');
Route::get('/pokoje/dodaj', 'AdvertsController@create');
Route::get('/pokoje/{advert}', 'AdvertsController@show'); // Display a single advert.
