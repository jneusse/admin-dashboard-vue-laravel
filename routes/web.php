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

Route::post('/authenticate/login', 'Auth\LoginController@login');
Route::post('/authenticate/logout', 'Auth\LoginController@logout');

Route::get('/administracion/usuario/getListaUsuarios', 'Administracion\UsersController@getListaUsuarios');
Route::get('/administracion/usuario/getRefrescarUsuarioAuth', function(){
    return Auth::user()->load('file');
});
Route::post('/administracion/usuario/setRegistrarUsuario', 'Administracion\UsersController@setRegistrarUsuario');
Route::post('/administracion/usuario/setEditarUsuario', 'Administracion\UsersController@setEditarUsuario');
Route::post('/administracion/usuario/setCambiarEstadoUsuario', 'Administracion\UsersController@setCambiarEstadoUsuario');
Route::post('/administracion/usuario/setEditarRolByUsuario', 'Administracion\UsersController@setEditarRolByUsuario');
Route::get('/administracion/usuario/getRolByUsuario', 'Administracion\UsersController@getRolByUsuario');
Route::get('/administracion/usuario/getListarPermisosByRol', 'Administracion\UsersController@getListarPermisosByRol');
Route::get('/administracion/usuario/getListarPermisosByUsuario', 'Administracion\UsersController@getListarPermisosByUsuario');
Route::post('/administracion/usuario/setRegistrarPermisosByUsuario', 'Administracion\UsersController@setRegistrarPermisosByUsuario');

Route::post('/archivo/setRegistrarArchivo', 'FilesController@setRegistrarArchivo');

Route::get('/administracion/rol/getListaRoles', 'Administracion\RolesController@getListaRoles');
Route::get('/administracion/rol/getListarPermisosByRol', 'Administracion\RolesController@getListarPermisosByRol');
Route::post('/administracion/rol/setRegistrarRolPermiso', 'Administracion\RolesController@setRegistrarRolPermiso');
Route::post('/administracion/rol/setEditarRolPermiso', 'Administracion\RolesController@setEditarRol');

Route::get('/administracion/permiso/getListarPermisos', 'Administracion\PermissionsController@getListarPermisos');
Route::post('/administracion/permiso/setRegistrarPermiso', 'Administracion\PermissionsController@setRegistrarPermiso');
Route::post('/administracion/permiso/setEditarPermiso', 'Administracion\PermissionsController@setEditarPermiso');


Route::get('/{opcional?}', function () {
    return view('app');
})->name('basepath')
    ->where('opcional', '.*');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
