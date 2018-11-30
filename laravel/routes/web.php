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

Route::get('/', 'IndexController@index');
Route::get('/dummy', 'IndexController@dummy');
Route::get('/dum_restaurants', 'IndexController@dumrestaurants');

Route::prefix('company')->group(function () {

    Route::get('/', 'CompanyController@index');

    Route::prefix('add')->group(function () {
        Route::get('/', 'CompanyController@add');

        Route::post('/confirm', 'CompanyController@confirm');

        Route::post('/complete', 'CompanyController@complete');
    });

    Route::prefix('edit')->group(function () {
        Route::any('/', 'CompanyController@edit');

        Route::post('/confirm', 'CompanyController@editconfirm');

        Route::post('/complete', 'CompanyController@editcomplete');
    });

});

Route::prefix('user')->group(function () {

    Route::get('/', 'UserController@index');

    Route::prefix('create')->group(function () {
        Route::any('/', 'UserController@create');

        Route::post('/confirm', 'UserController@confirm');

        Route::post('/complete', 'UserController@complete');
    });

    Route::post('/login', 'UserController@login');

    Route::get('/logout', 'UserController@logout');

    Route::prefix('edit')->group(function () {
        Route::get('/', 'UserController@edit');

        Route::post('/confirm', 'UserController@confirm');

        Route::post('/complete', 'UserController@complete');
    });

});

Route::prefix('restaurants')->group(function () {

    Route::get('/', 'RestaurantController@index');

    Route::prefix('detail')->group(function () {
        Route::get('/', 'RestaurantController@detail');

        Route::post('/addComment', 'RestaurantController@addComment');

        Route::post('/addGood', 'RestaurantController@addGood');

        Route::post('/deleteGood', 'RestaurantController@deleteGood');
    });

    Route::prefix('add')->group(function () {
        Route::get('/', 'RestaurantController@add');

        Route::post('/confirm', 'RestaurantController@confirm');

        Route::post('/complete', 'RestaurantController@complete');
    });

    Route::prefix('edit')->group(function () {
        Route::get('/', 'RestaurantController@edit');

        Route::post('/confirm', 'RestaurantController@editconfirm');

        Route::post('/complete', 'RestaurantController@editcomplete');
    });

    Route::post('/delete', 'RestaurantController@delete');

});

Route::prefix('category')->group(function () {

  Route::get('/', 'CategoryController@index');

  Route::get('/detail', 'CategoryController@detail');

  Route::post('/delete', 'CategoryController@delete');

    Route::prefix('add')->group(function () {
        Route::get('/', 'CategoryController@add');

        Route::post('/confirm', 'CategoryController@confirm');

        Route::post('/complete', 'CategoryController@complete');
    });

    Route::prefix('edit')->group(function () {
        Route::any('/', 'CategoryController@edit');

        Route::post('/confirm', 'CategoryController@editconfirm');

        Route::post('/complete', 'CategoryController@editcomplete');
    });

});
