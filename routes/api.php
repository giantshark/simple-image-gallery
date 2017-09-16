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

Route::group(['middleware' => 'api.auth'], function() {
    Route::group(['namespace' => 'Gallery\Controllers\Api','prefix' => 'galleries', 'as' => 'gallery.'], function() {
        Route::get('/', ['as' => 'index', 'uses' => 'ApiGalleryController@index']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'ApiGalleryController@delete']);
        Route::post('/', ['as' => 'store', 'uses' => 'ApiGalleryController@store']);
    });
});

