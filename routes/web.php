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

Route::get('/', 'HomeController@index')->name('home');
Route::get("/groups", "HomeController@groups");

Route::get("/matches", "HomeController@matches");
Route::get("/matches/{match}", "HomeController@showMatch");

Route::get("/predictions/", "PredictionsController@index");