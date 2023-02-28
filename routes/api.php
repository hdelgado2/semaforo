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
//Route::get('listroles','RolesController@index')->name('index');
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

//

Route::post('editmensaje','MensajesController@editmensaje')->name('editmensaje');

Route::post('cargarmensaje/{id}','MensajesController@cargarmensajeedit')->name('cargarmensajeedit');
Route::post('botoneditar','MensajesController@botoneditar')->name('botoneditar');
Route::post('deletemensaje/{id}','MensajesController@deletemensaje')->name('deletemensaje');

Route::post('loadDisplays/listado','LocalizacionDisplayController@index')->name('loadDisplays.listado.index');

Route::post('guardarlacalizacionesdisplays','LocalizacionDisplayController@guardarlacalizacionesdisplays')->name('guardarlacalizacionesdisplays');

Route::post('cargardisplay/{id}','LocalizacionDisplayController@cargardisplayedit')->name('cargardisplayedit');

Route::post('botoneditardisplay','LocalizacionDisplayController@botoneditardisplay')->name('botoneditardisplay');

Route::post('deletedisplay','LocalizacionDisplayController@deletedisplay')->name('deletedisplay');

//search mensaje
Route::get('mensajesearch','MensajesController@search')->name('mensajesearch');
Route::get('displaysearch','LocalizacionDisplayController@search')->name('displaysearch');


//displayselect
//Route::apiResources(['displayselect' => 'InterseccionController']);
Route::apiResources(['displaysonline' => 'CentroMandoController']);
Route::apiResources(['mensajeselect' => 'CentroMandoController@selectmensajes']);
//route to turn back the information of the vselect of the modal mensaje
Route::get('mensajeselect','CentroMandoController@selectmensajes')->name('mensajeselect');
//route to save the information of a new message assigned to the display.
Route::post('LocationDisplay','CentroMandoController@LocationDisplay')->name('LocationDisplay');

Route::post('saveMassageDisplay','CentroMandoController@saveMassageDisplay')->name('saveMassageDisplay');

Route::post('loadtabla','CentroMandoController@loadtabla')->name('loadtabla');


//ELIMINAR MENSAJES ASOCIADOS A UN DISPLAY

Route::post('deletedisplay','LocalizacionDisplayController@deletedisplay')->name('deletedisplay');
//here we send the message to  the display-

Route::post('mqtt/publish','MqttController@publish')->name('mqtt.publish');

