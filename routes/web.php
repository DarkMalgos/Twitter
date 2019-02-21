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

Route::middleware(['web'])->group(function () {
    Auth::routes();

    Route::get('/', function () {
        return redirect('/login');
    });
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/', 'TweetController@store')->name('tweet');
    Route::get('/users/{id}/edit', 'HomeController@editUser')->name('editUser');
    Route::get('/users/{id}', 'HomeController@user')->name('users');
    Route::delete('/tweets/{id}', 'TweetController@destroy')->name('removeTweet');
    Route::put('/users/{id}', 'HomeController@updateUser')->name('updateUser');
});

