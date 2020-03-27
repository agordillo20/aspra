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
Route::get('/moviles', 'movilesController@catalogo')->name('moviles');
Route::get('/registrado', 'RedireccionController@redireccion')->name('redireccion');
Route::post('/show', 'productoController@showUser')->name('ConsultaProducto');

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
Route::get('/admin/list/Categorias', 'categoriaController@show');

//Fabricantes
Route::get('/admin/add/Fabricantes', 'fabricanteController@add');
Route::get('/admin/list/Fabricantes', 'fabricanteController@show');

Auth::routes(['verify' => true]);


