<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('search','UsuarioController@index')->name('index');
Route::get('searchUser/{search}','UsuarioController@searchUser')->name('searchUser');
Route::post('createUser','UsuarioController@createUser')->name('createUser');
Route::get('getRoles','UsuarioController@getRoles')->name('getRoles');


