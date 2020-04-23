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
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/catalogo', 'catalogoController@catalogo');
Route::get('/registrado', 'RedireccionController@redireccion')->name('redireccion');
Route::post('/show', 'catalogoController@showUser')->name('ConsultaProducto');

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
Route::post('/admin/editar/Transportistas', 'adminController@editTransportistas');

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
Route::post('/admin/list/productos/baja', 'productoController@bajas');

//Categorias
Route::get('/admin/add/Categorias', 'categoriaController@add');
Route::post('/admin/add/categoria', 'categoriaController@add1');
Route::get('/admin/list/Categorias', 'categoriaController@show');
Route::post('/admin/delete/categoria', 'categoriaController@delete');
Route::post('/admin/update/categoria', 'categoriaController@update');

//Transportistas
Route::get('/admin/add/Transportistas', 'transportistaController@add');
Route::post('/admin/add/Tranportistas1', 'transportistaController@add1');
Route::get('/admin/list/Transportistas', 'transportistaController@show');
Route::post('/admin/delete/Transportistas', 'transportistaController@delete');
Route::post('/admin/update/Transportistas', 'transportistaController@update');

//Fabricantes
Route::get('/admin/add/Fabricantes', 'fabricanteController@add');
Route::post('/admin/add/fabricantes', 'fabricanteController@add1');
Route::get('/admin/list/Fabricantes', 'fabricanteController@show');
Route::post('/admin/delete/fabricante', 'fabricanteController@delete');
Route::post('/admin/update/fabricante', 'fabricanteController@update');

//Catalogo
Route::post('/catalogo/filtrar/productos', 'catalogoController@filtrar');
Route::post('/catalogo/filtrar1/productos', 'catalogoController@filtrar1');

//Carrito
Route::post('/carrito/add', 'carritoController@add');
Route::post('/carrito/delete', 'carritoController@delete');
Route::post('/carrito/finalizar/delete', 'carritoController@delete1');
Route::get('/carrito/terminarCompra', 'carritoController@comprar')->name('comprar');
Route::post('/carrito/user/comprobar', 'carritoController@comprobar');
Route::get('/pago', 'carritoController@pago');
Route::post('payment', array(
    'as' => 'payment',
    'uses' => 'PaypalController@postPayment',
));

Route::get('payment/status', array(
    'as' => 'payment.status',
    'uses' => 'PaypalController@getPaymentStatus',
));
Route::post('/pdf', 'perfilController@imprimirfactura');
Auth::routes(['verify' => true]);


