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
Auth::routes();
//Rutas de users
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/moviles', 'movilesController@catalogo')->name('moviles');
Route::get('/registrado', 'RedireccionController@redireccion')->name('redireccion');

//Rutas de admin
Route::get('/admin', 'adminController@index')->name('admin');

//Productos
Route::get('/admin/add/Productos', 'productoController@add');
Route::get('/admin/update/Productos', 'productoController@update');
Route::get('/admin/delete/Productos', 'productoController@delete');
Route::get('/admin/list/Productos', 'productoController@show');

//Categorias
Route::get('/admin/add/Categorias', 'categoriaController@add');
Route::get('/admin/update/Categorias', 'categoriaController@update');
Route::get('/admin/delete/Categorias', 'categoriaController@delete');
Route::get('/admin/list/Categorias', 'categoriaController@show');

//Fabricantes
Route::get('/admin/add/Fabricantes', 'fabricanteController@add');
Route::get('/admin/update/Fabricantes', 'fabricanteController@update');
Route::get('/admin/delete/Fabricantes', 'fabricanteController@delete');
Route::get('/admin/list/Fabricantes', 'fabricanteController@show');


