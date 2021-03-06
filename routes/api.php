<?php

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

Route::group([
    'middleware' => ['api', 'cors'],
    'prefix' => 'auth',
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([

    'middleware' => ['auth:api', 'cors'],
], function () {

    // News API
    Route::get('news', 'NewsApiController@index');

    // Posts API
    Route::post('/post/uploadpostphoto', 'NewsApiController@uploadFile');
    Route::post('/post/create', 'NewsApiController@store');
    Route::put('/post/{id}', 'NewsApiController@update');
    Route::delete('/post/{id}', 'NewsApiController@destroy');
});
