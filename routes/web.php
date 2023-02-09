<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['register' => true, 'verify' => true, 'login' => false]);

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::group(['prefix' => '', 'middleware' => 'verified'], function () {
    Route::group(['prefix' => 'event'], function () {
        Route::get('/', 'EventController@index')->name('event.list');
        Route::get('/create', 'EventController@create')->name('event.create');
        Route::get('/{event}/edit', 'EventController@edit')->name('event.edit')->where('id', '[0-9]+');
        Route::post('/', 'EventController@store')->name('event.store');  
        Route::put('/update/{event}', 'EventController@update')->name('event.update')->where('id', '[0-9]+');
        Route::delete('/delete/{event}', 'EventController@destroy')->name('event.destroy')->where('id', '[0-9]+');
        Route::get('/show/{event}', 'EventController@show')->name('event.show')->where('id', '[0-9]+');

    });

});