<?php

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

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/add-yourself', 'ParticipantController@index')->name('add-yourself');
Route::post('/add-yourself', 'ParticipantController@store')->name('create-participant');

Route::post('/vote/{participant}', 'VoteController@store')->name('cast-vote');
