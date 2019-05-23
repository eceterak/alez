<?php

/****************
 * Backend routes 
 ***************/

Route::get('/admin/login', 'Admin\AdminLoginController@index')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function() 
{
    // Home
    Route::get('/', 'AdminDashboardController@index')->name('admin.dashboard');
    
    // Cities
    Route::get('/miasta', 'CitiesController@index')->name('admin.cities');
    Route::get('/miasta/dodaj', 'CitiesController@create')->name('admin.cities.create');
    Route::post('/miasta', 'CitiesController@store')->name('admin.cities.store');
    Route::get('/miasta/{city}', 'CitiesController@edit')->name('admin.cities.edit');
    Route::get('/miasta/{city}/pokoje', 'CitiesController@adverts')->name('admin.cities.adverts'); // @Refactor
    Route::patch('/miasta/{city}', 'CitiesController@update')->name('admin.cities.update');
    Route::delete('/miasta/{city}', 'CitiesController@destroy')->name('admin.cities.destroy');

    // Streets
    Route::get('/miasta/{city}/ulice', 'CityStreetsController@index')->name('admin.cities.streets');
    Route::get('/miasta/{city}/ulice/dodaj', 'CityStreetsController@create')->name('admin.streets.create');
    Route::post('/miasta/{city}/ulice', 'CityStreetsController@store')->name('admin.streets.store');
    Route::get('/miasta/{city}/ulice/{street}', 'CityStreetsController@edit')->name('admin.streets.edit');
    Route::patch('/miasta/{city}/ulice/{street}', 'CityStreetsController@update')->name('admin.streets.update');
    Route::delete('/miasta/{city}/ulice/{street}', 'CityStreetsController@destroy')->name('admin.streets.destroy');
    
    // Adverts
    Route::get('/pokoje', 'AdvertsController@index')->name('admin.adverts');
    Route::get('/pokoje/dodaj', 'AdvertsController@create')->name('admin.adverts.create');
    Route::post('/pokoje', 'AdvertsController@store')->name('admin.adverts.store');
    Route::get('/pokoje/{advert}', 'AdvertsController@edit')->name('admin.adverts.edit');
    Route::patch('/pokoje/{advert}', 'AdvertsController@update')->name('admin.adverts.update');
    Route::delete('/pokoje/{advert}', 'AdvertsController@destroy')->name('admin.adverts.destroy');
});


/*****************
 * Frontend routes 
 ****************/

Route::get('/', 'PagesController@index')->name('index'); //@refactor - I dont like the name pagesController

// Search
Route::get('/szukaj', 'SearchController@index')->name('search.index');

// Adverts
Route::get('/pokoje', 'AdvertsController@index')->name('adverts');
Route::get('/pokoje/{city}/{advert}', 'AdvertsController@show')->name('adverts.show');

Route::group(['middleware' => ['auth', 'verified']], function() 
{
    // Subscriptions //@refactor to API
    Route::post('/pokoje/{city}/obserwuj', 'CitySubscriptionsController@store')->name('city.subscribe');
    Route::delete('/pokoje/{city}/obserwuj', 'CitySubscriptionsController@destroy')->name('city.unsubscribe');

    // User account
    Route::get('/moj-alez', 'HomeController@index')->name('home');
    Route::get('/moj-alez/ogloszenia', 'AdvertsController@mine')->name('adverts.mine'); // @Refactor

    // Conversations
    Route::get('/moj-alez/odebrane', 'ConversationsController@index')->name('conversations.inbox');
    Route::post('/pokoje/{city}/{advert}/odpowiedz', 'ConversationsController@store')->name('conversations.store');
    Route::get('/moj-alez/odebrane/{conversation}', 'ConversationsController@show')->name('conversations.show');
    Route::post('/moj-alez/odebrane/{conversation}', 'ConversationsController@reply')->name('conversations.reply'); // Should be message controller@store

    // Adverts
    Route::get('/pokoje/dodaj', 'AdvertsController@create')->name('adverts.create');
    Route::post('/pokoje', 'AdvertsController@store')->name('adverts.store');
    Route::get('/pokoje/{city}/{advert}/edytuj', 'AdvertsController@edit')->name('adverts.edit');
    Route::patch('/pokoje/{city}/{advert}/edytuj', 'AdvertsController@update')->name('adverts.update');
    Route::delete('/pokoje/{city}/{advert}', 'AdvertsController@destroy')->name('adverts.destroy');

    // Favourites //@refactor to API
    Route::post('/pokoje/{city}/{advert}/ulubione', 'FavouritesController@store')->name('adverts.favourite.store');
    Route::delete('/pokoje/{city}/{advert}/ulubione', 'FavouritesController@destroy')->name('adverts.favourite.delete');

    // Notifications
    Route::get('/uzytkownicy/{user}/notyfikacje', 'UserNotificationsController@index')->name('profiles.notifications');
    Route::delete('/uzytkownicy/{user}/notyfikacje/{notification}', 'UserNotificationsController@destroy')->name('profiles.notifications.delete');
});

// Cities
Route::get('/miasta', 'CitiesController@index')->name('cities');
Route::get('/pokoje/{city}', 'CitiesController@show')->name('cities.show');

// Profiles
Route::get('/uzytkownicy/{user}', 'ProfilesController@show')->name('profiles.show');

// Ajax @Refactor to API
Route::get('/ajax/cities', 'AjaxController@cities');
Route::get('/ajax/streets', 'AjaxController@streets');
Route::post('/ajax/images/upload', 'AjaxController@upload');
Route::get('/pokoje/{city}/ajax/adverts', 'AjaxController@index')->name('ajax.city.adverts');

// Api
Route::post('/api/uzytkownicy/{user}/avatars', 'Api\AvatarsController@store')->middleware('auth')->name('api.users.avatars.store');
Route::post('/api/ogloszenia/zdjecia', 'Api\PhotosUploadController@store')->middleware('auth')->name('api.adverts.photos.store');
Route::delete('/api/ogloszenia/zdjecia/{photo}', 'Api\PhotosUploadController@destroy')->middleware('auth')->name('api.adverts.photos.delete');

// Auth
Auth::routes(['verify' => true]);
Auth::routes();