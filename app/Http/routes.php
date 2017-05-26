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

Route::get('registrarproducto', 'ProductosController@registrarproducto');
Route::post('registrarproducto', 'ProductosController@crearproducto');
Route::get('codigo/producto/{categoria}', 'ProductosController@codigodisponible');
Route::get('buscarproductos', 'ProductosController@productos');
Route::get('producto/{id}', 'ProductosController@productoid');
Route::get('/editarproductos', 'ProductosController@editarvista');
Route::get('editarproducto/{id}', 'ProductosController@editarproducto');
Route::post('editarproducto', 'ProductosController@editarproductointerno');

Route::get('registarcategoria', 'CategoriasController@registrarcategoria');
Route::post('registrarcategoria', 'CategoriasController@crear');
Route::get('editarcategoria/{id}', 'CategoriasController@editar');
Route::get('editarcategoria', 'CategoriasController@editarc');
Route::post('editarcategoria', 'CategoriasController@editarcategoria');
Route::get('categoria/{id}', 'CategoriasController@categoria');
Route::get('categorias', 'CategoriasController@buscar');


Route::get('/registrarcliente', 'ClientesController@registrarcliente');
Route::post('registrarcliente', 'ClientesController@crearcliente');
route::get('clientes','ClientesController@buscarcliente');
Route::get('editarcliente/{id}', 'ClientesController@editarcliente');
Route::post('/editarcliente', 'ClientesController@actualizarcliente');


Route::post('/registerstorage', 'BodegasController@registrarbodega');
Route::get('/registarbodega', 'BodegasController@registrar');
Route::get('/editarbodega', 'BodegasController@editarbodega');
Route::get('/editarbodega/{id}', 'BodegasController@actualizarbodega');
Route::post('/editarstorage', 'BodegasController@editar');

Route::get('inventario', 'InventariosController@inventarioform');
Route::post('buscarinventario', 'InventariosController@inventario');
Route::post('verinventario', 'InventarioController@inventario');




Route::get('registrarmovimiento', 'ViewController@entradaproducto');
Route::get('movimiento', 'ViewController@movimientoid');
Route::post('registrarmovimiento', 'StorageController@registromovimiento');
Route::get('buscarmovimiento', 'ViewController@movimientos');



Route::post('/registraritem', 'StorageController@saveitem');
Route::get('/buscarvaloritem', 'ViewController@buscarvaloritem');





Route::get('/registrarreserva', 'ViewController@registrarreserva');
Route::post('registrarreserva', 'StorageController@registrarreserva');
Route::get('/confirmar', 'ViewController@confirmar');
Route::get('confirmar1', 'ViewController@confirmar1');
Route::get('/verdireccion', 'ViewController@direccioncliente');






Route::get('usuarios', 'AdminController@usuarios');
Route::get('registrarusuario', 'AdminController@registrarusuario');
Route::post('registrarusuario', 'AdminController@registrarusuariof');
