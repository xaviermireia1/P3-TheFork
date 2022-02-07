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
//Si el login ha sido exitoso y el rol del usuario es administrador
Route::get('home-adm',[RestauranteController::class,'indexAdm']);

//Redirección a la vista del formulario
Route::get('crear',[RestauranteController::class,'create']);

//Proceso de creación de nuevos items(Restaurantes) en la DB
Route::post('crear-proc',[RestauranteController::class,'crearProc']);

//Filtro home admin en AJAX
Route::post('home-adm/show',[RestauranteController::class,'showAdm']);

//Proceso eliminar restaurante
Route::get('home-adm/delete/{id}',[RestauranteController::class,'destroy']);

//Ruta vista update
Route::get('home-adm/update/{id}',[RestauranteController::class,'edit']);

//Proceso update
Route::put('home-adm/update-proc',[RestauranteController::class,'update']);

//----------------------------Rutas Clientes-------------------------------

//Login
Route::get('',[RestauranteController::class,'login']);
//Proceso de login
Route::post('login-proc',[RestauranteController::class,'loginProc']);

//Si el login ha sido exitoso con el rol del usuario es cliente
Route::get('home',[RestauranteController::class,'index']);

//Filtro home en AJAX
Route::post('home/show',[RestauranteController::class,'show']);

//Registro de usuario
Route::get('register',[RestauranteController::class,'register']);

//Proceso registro
Route::post('registerPost',[RestauranteController::class,'registerPost']);

//Redirigir a pagina de ayuda
Route::get('ayuda',[RestauranteController::class,'ayuda']);
