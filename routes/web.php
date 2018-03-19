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

Route::get('/home', 'NewsController@index')->name('home');


Route::get('/news', 'NewsController@index');
Route::get('/news/create', 'NewsController@create');
Route::post('/news/create', 'NewsController@store');

