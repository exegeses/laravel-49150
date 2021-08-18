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

Route::get('/', function () {
    return view('welcome');
});
##############################################
####### CRUD de marcas
use App\Http\Controllers\MarcaController;
Route::get('/adminMarcas', [ MarcaController::class, 'index' ] );
Route::get('/agregarMarca', [ MarcaController::class, 'create' ] );
Route::post('/agregarMarca', [ MarcaController::class, 'store' ] );

##############################################
####### CRUD de categorias

##############################################
####### CRUD de productos


