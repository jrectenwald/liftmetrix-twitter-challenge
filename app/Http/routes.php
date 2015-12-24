<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','HomeController@index');

Route::get('/users','UsersController@store');
Route::post('/users','UsersController@store');

Route::get('/retweets','TweetsController@index');

Route::get('/favorites','FavoritesController@index');


