<?php

use Illuminate\Auth\AuthenticationException;
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

Route::group(['middleware' => ['auth', 'only.ajax']], function () {
// Authentication
    Route::post('/authenticate/logout', 'Auth\LoginController@logout');
    Route::get('/administracion/usuario/getListaUsuarios', 'Administracion\UsersController@getListaUsuarios');
    Route::get('/administracion/usuario/getRefrescarUsuarioAuth', function(){
        return Auth::user()->load('file');
    });
// Administracion Usuarios
    Route::post('/administracion/usuario/setRegistrarUsuario', 'Administracion\UsersController@setRegistrarUsuario');
    Route::post('/administracion/usuario/setEditarUsuario', 'Administracion\UsersController@setEditarUsuario');
    Route::post('/administracion/usuario/setCambiarEstadoUsuario', 'Administracion\UsersController@setCambiarEstadoUsuario');
    Route::post('/administracion/usuario/setEditarRolByUsuario', 'Administracion\UsersController@setEditarRolByUsuario');
    Route::get('/administracion/usuario/getRolByUsuario', 'Administracion\UsersController@getRolByUsuario');
    Route::get('/administracion/usuario/getListarPermisosByRol', 'Administracion\UsersController@getListarPermisosByRol');
    Route::get('/administracion/usuario/getListarPermisosByUsuario', 'Administracion\UsersController@getListarPermisosByUsuario');
    Route::post('/administracion/usuario/setRegistrarPermisosByUsuario', 'Administracion\UsersController@setRegistrarPermisosByUsuario');
    Route::get('/administracion/usuario/getListarRolPermisosbyUsuario', 'Administracion\UsersController@getListarRolPermisosbyUsuario');
// Administracion Roles
    Route::get('/administracion/rol/getListaRoles', 'Administracion\RolesController@getListaRoles');
    Route::get('/administracion/rol/getListarPermisosByRol', 'Administracion\RolesController@getListarPermisosByRol');
    Route::post('/administracion/rol/setRegistrarRolPermiso', 'Administracion\RolesController@setRegistrarRolPermiso');
    Route::post('/administracion/rol/setEditarRolPermiso', 'Administracion\RolesController@setEditarRol');
// Administracion Permisos
    Route::get('/administracion/permiso/getListarPermisos', 'Administracion\PermissionsController@getListarPermisos');
    Route::post('/administracion/permiso/setRegistrarPermiso', 'Administracion\PermissionsController@setRegistrarPermiso');
    Route::post('/administracion/permiso/setEditarPermiso', 'Administracion\PermissionsController@setEditarPermiso');
// Configuracion Categorias
    Route::get('/configuracion/categoria/getListaCategorias', 'Configuracion\CategoriesController@getListaCategorias');
    Route::post('/configuracion/categoria/setRegistrarCategoria', 'Configuracion\CategoriesController@setRegistrarCategoria');
    Route::post('/configuracion/categoria/setEditarCategoria', 'Configuracion\CategoriesController@setEditarCategoria');
// Configuracion Productos
    Route::get('/configuracion/producto/getListaProductos', 'Configuracion\ProductsController@getListaProductos');
    Route::post('/configuracion/producto/setRegistrarProducto', 'Configuracion\ProductsController@setRegistrarProducto');
    Route::post('/configuracion/producto/setEditarProducto', 'Configuracion\ProductsController@setEditarProducto');
// Operacion Pedidos
    Route::get('/operacion/pedidos/getListaPedidos', 'Operacion\OrdersController@getListaPedidos');
// Operacion Clientes
    Route::get('/operacion/cliente/getListarClientes', 'Operacion\CustomersController@getListarClientes');
    Route::post('/operacion/cliente/setRegistrarCliente', 'Operacion\CustomersController@setRegistrarCliente');

    Route::post('/archivo/setRegistrarArchivo', 'FilesController@setRegistrarArchivo');
});

Route::get('/{opcional?}', function () {
    return view('app');
})->name('basepath')
    ->where('opcional', '.*');



//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
