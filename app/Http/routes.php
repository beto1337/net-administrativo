<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

Route::get('/registrarproducto', 'ProductosController@registrarproducto');
Route::post('registrarproducto', 'ProductosController@crearproducto');
Route::get('/editproducts', 'ViewController@editarproducto');
Route::post('/editproducts', 'StorageController@editarproducto');
Route::get('registrarmovimiento', 'ViewController@entradaproducto');
Route::get('movimiento', 'ViewController@movimientoid');
Route::post('registrarmovimiento', 'StorageController@registromovimiento');
Route::get('buscarmovimiento', 'ViewController@movimientos');
Route::get('buscarproductos', 'ViewController@productos');
Route::get('producto', 'ViewController@productoid');


Route::get('inventario', 'ViewController@inventarioform');
Route::post('buscarinventario', 'StorageController@inventario');
Route::post('verinventario', 'StorageController@inventario');


Route::post('/registraritem', 'StorageController@saveitem');
Route::get('/buscarvaloritem', 'ViewController@buscarvaloritem');

Route::post('/registerstorage', 'StorageController@registrarbodega');
Route::get('/registarbodega', 'ViewController@registrarbodega');
Route::get('/editarbodega', 'ViewController@editarbodega');
Route::post('/editarstorage', 'StorageController@editarbodega');

Route::get('/registrarcliente', 'ViewController@registrarcliente');
Route::post('registrarcliente', 'StorageController@registrarcliente');
Route::get('/editarcliente', 'ViewController@editarcliente');
Route::post('/editarcliente', 'StorageController@editarcliente');


Route::get('/registrarreserva', 'ViewController@registrarreserva');
Route::post('registrarreserva', 'StorageController@registrarreserva');
Route::get('/confirmar', 'ViewController@confirmar');
Route::get('confirmar1', 'ViewController@confirmar1');
Route::get('/verdireccion', 'ViewController@direccioncliente');


Route::post('registrarcliente', 'StorageController@registrarcliente');
Route::get('/editarcliente', 'ViewController@editarcliente');
Route::post('/editarcliente', 'StorageController@editarcliente');


Route::get('registarcategoria', 'CategoriasController@registrarcategoria');
Route::post('registrarcategoria', 'CategoriasController@crear');
Route::get('editarcategoria/{id}', 'CategoriasController@editar');
Route::post('editarcategoria', 'CategoriasController@editarcategoria');
Route::get('categoria/{id}', 'CategoriasController@categoria');
Route::get('categorias', 'CategoriasController@buscar');



Route::get('usuarios', 'AdminController@usuarios');
Route::get('registrarusuario', 'AdminController@registrarusuario');
Route::post('registrarusuario', 'AdminController@registrarusuariof');
