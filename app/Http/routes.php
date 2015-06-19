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

// Display all SQL executed in Eloquent
// Event::listen('illuminate.query', function ($query) {
//     var_dump($query);
// });

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tasks', 'TaskController', ['except' => ['create', 'edit']]);
Route::resource('events', 'EventController', ['except' => ['create', 'edit']]);
Route::resource('colors', 'ColorController', ['except' => ['create', 'edit']]);
Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
Route::resource('statuses', 'StatusController', ['except' => ['create', 'edit']]);

Route::resource('search', 'SearchController', ['only' => ['index']]);
