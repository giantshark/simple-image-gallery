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
    return view('home');
});

Route::group(['middleware' => 'auth'], function() {
    Route::group(['namespace' => 'Gallery\Controllers','prefix' => 'galleries', 'as' => 'gallery.'], function() {
        Route::get('/', ['as' => 'home', 'uses' => 'GalleryController@index']);
        Route::get('/', ['as' => 'index', 'uses' => 'GalleryController@index']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'GalleryController@delete']);
        Route::post('/', ['as' => 'store', 'uses' => 'GalleryController@store']);
    });

    Route::group(['prefix' => 'home', 'as' => 'home.'], function() {
        Route::group(['namespace' => 'DiskManagement\Controllers','as' => 'disk.'], function() {
            Route::get('/', ['as' => 'index', 'uses' => 'DiskController@index']);
        });
    });
});


Route::group(['namespace' => 'Authentication\Controllers'], function() {

    Route::group(['prefix' => 'login'], function() {
        Route::get('/', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
        Route::post('/', ['as' => 'login', 'uses' => 'LoginController@login']);
    });

    Route::group(['prefix' => 'logout'], function() {
        Route::post('/', ['as' => 'logout', 'uses' => 'LoginController@logout']);
    });

    Route::group(['prefix' => 'register'], function() {
        Route::get('/', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
        Route::post('/', ['as' => 'register', 'uses' => 'RegisterController@register']);
    });

});




