<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home')
		->with('active', 'home');
});

Route::get('about', function()
{
	return View::make('about')
		->with('active', 'about');
});


Route::controller('api', 'ApiController');
Route::resource('poll', 'PollController');