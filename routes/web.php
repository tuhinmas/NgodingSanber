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



Route::resource('pertanyaan', 'PertanyaanController');

Route::get('/myquestion', 'HomeController@index')->name('myhome');
Route::get('/', function () {
    return redirect('/pertanyaan');
})->name('home');
Auth::routes();

Route::resource('/profile', 'ProfileController');