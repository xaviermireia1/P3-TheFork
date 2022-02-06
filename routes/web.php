<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;
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

//------------------------------Rutas Adm----------------------------------
//Route::get('',[RestauranteController::class,'register']);
//
Route::get('home-adm',[RestauranteController::class,'indexAdm']);
//Redirección a la vista del formulario
Route::get('crear',[RestauranteController::class,'create']);
//Proceso de creación de nuevos items(Restaurantes) en la DB
Route::post('crear-proc',[RestauranteController::class,'createProc']);
//----------------------------Rutas Clientes-------------------------------
//Login
Route::get('login',[RestauranteController::class,'login']);
//Proceso de login
Route::post('login-proc',[RestauranteController::class,'loginProc']);
//Al obtener un login exitoso se nos redigirá a
Route::get('home',[RestauranteController::class,'index']);
//Registro de usuario
Route::get('register',[RestauranteController::class,'register']);
//Proceso registro
Route::post('registerPost',[RestauranteController::class,'registerPost']);

