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
Auth::routes();
//Rutas de users
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/catalogo', 'catalogoController@catalogo');
Route::get('/registrado', 'RedireccionController@redireccion')->name('redireccion');
Route::get('/show', 'catalogoController@showUser')->name('ConsultaProducto');

//Rutas relacionadas con el perfil del user
Route::get('/perfil', 'perfilController@perfil');
Route::post('/foto', 'perfilController@foto');
Route::post('/updateUser', 'perfilController@updateUser');
Route::post('/updatePassword', 'perfilController@updatePassword');
Route::post('/direccion/add', 'perfilController@addDireccion');
Route::post('/direccion/delete', 'perfilController@deleteDireccion');
Route::post('/direccion/search', 'perfilController@searchDireccion');
Route::post('/direccion/update', 'perfilController@updateDireccion');

//Rutas de admin
Route::get('/admin', 'adminController@index')->name('admin');

//Rutas ajax
Route::post('/admin/verCategoria', 'adminController@showCategoria');
Route::post('/admin/verFabricante', 'adminController@showFabricante');
Route::post('/admin/verDescripcion', 'adminController@showDescripcion');
Route::post('/admin/buscar', 'adminController@buscar');
Route::post('/admin/aplicar', 'adminController@aplicar');
Route::post('/admin/editar/comprobarCodigo', 'adminController@comprobarCodigo');
Route::post('/admin/editar/obtenerCampos', 'adminController@obtener');
Route::post('/admin/editar/obtenerValores', 'adminController@obtener1');
Route::post('/admin/editar/fabricante', 'adminController@editFabricante');
Route::post('/admin/editar/categoria', 'adminController@editCategoria');

//Productos
Route::get('/admin/add/Productos', 'productoController@add');
Route::post('/admin/add/producto', 'productoController@add1');
Route::post('/admin/add/descripcion', 'productoController@addDescripcion')->name('descripcion');
Route::post('/admin/update/descripcion', 'productoController@updateDescripcion');
Route::post('/admin/editar/producto', 'productoController@update');
Route::post('/admin/editar/producto2', 'productoController@update2')->name('actualizar');
Route::post('/admin/editar/producto1', 'productoController@update1')->name('editar');
Route::post('/admin/borrar/producto', 'productoController@delete')->name('borrar');
Route::get('/admin/list/Productos', 'productoController@show');
Route::get('/admin/ofertar/Productos', 'productoController@ofertar');

//Categorias
Route::get('/admin/add/Categorias', 'categoriaController@add');
Route::post('/admin/add/categoria', 'categoriaController@add1');
Route::get('/admin/list/Categorias', 'categoriaController@show');
Route::post('/admin/delete/categoria', 'categoriaController@delete');
Route::post('/admin/update/categoria', 'categoriaController@update');

//Fabricantes
Route::get('/admin/add/Fabricantes', 'fabricanteController@add');
Route::post('/admin/add/fabricantes', 'fabricanteController@add1');
Route::get('/admin/list/Fabricantes', 'fabricanteController@show');
Route::post('/admin/delete/fabricante', 'fabricanteController@delete');
Route::post('/admin/update/fabricante', 'fabricanteController@update');

//Catalogo
Route::post('/catalogo/filtrar/productos', 'catalogoController@filtrar');
Route::post('/catalogo/filtrar1/productos', 'catalogoController@filtrar1');

Auth::routes(['verify' => true]);


