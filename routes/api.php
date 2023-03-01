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
Route::get('intersecciones/listado/search/{search?}','InterseccionController@searchInterseccion')->name('intersecciones.listado.search');

Route::post('mqtt/publish','MqttController@publish')->name('mqtt.publish');

Route::apiResources(['mensajes' => 'MensajesController']);

Route::apiResources(['incidencias' => 'IncidenciaController']);
Route::get('incidencias-tipos','IncidenciaController@getTipos')->name('incidencia.tipos');
Route::get('incidencias/search/{filtro}','IncidenciaController@search')->name('incidencia.search');
Route::apiResources(['guardias' => 'GuardiaController']);
Route::get('guardias-all','GuardiaController@getGuardias')->name('guardias.listado');
Route::get('guardias/search/{filtro}','GuardiaController@search')->name('guardias.search');
Route::apiResources(['auditoria' => 'AuditoriaController']);
Route::get('auditorias','AuditoriaController@getAuditoria')->name('auditoria.listado');
Route::get('auditorias/search/{filtro}','AuditoriaController@search')->name('auditoria.search');





