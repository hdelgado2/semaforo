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
Route::get('deleteUser/{id}','UsuarioController@deleteUser')->name('deleteUser');
Route::get('edituser/{id}','UsuarioController@editUser')->name('editUser');
Route::post('editusers','UsuarioController@editUserRegistro')->name('editUserRegistro');
Route::get('listroles','RolesController@index')->name('index');
Route::post('createroles','RolesController@createRoles')->name('createroles');
Route::get('searchroles/{role}','RolesController@searchRoles')->name('searchRoles');
Route::get('deleteroles/{role}','RolesController@deleteroles')->name('deleteroles');
Route::get('editarroles/{role}','RolesController@editarRoles')->name('editarRoles');
Route::post('editroles/{role}','RolesController@editrolesP')->name('editrolesP');
Route::get('permisosLista','PermisosController@index')->name('permisosLista');
Route::get('menu','PermisosController@menu')->name('menu');
Route::post('addpermisos','PermisosController@addpermisos')->name('addpermisos');

Route::apiResources(['intersecciones' => 'InterseccionController']);
Route::post('intersecciones/setPatrones','InterseccionController@setPatrones')->name('intersecciones.patrones.guardar');
Route::get('intersecciones/listado','InterseccionController@getIntersecciones')->name('intersecciones.listado.index');
Route::get('intersecciones/listado/search/{search}','InterseccionController@searchInterseccion')->name('intersecciones.listado.search');





