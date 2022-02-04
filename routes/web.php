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

//Registro de usuario
Route::get('register',[RestauranteController::class,'register']);
Route::post('registerPost',[RestauranteController::class,'registerPost']);

//Redirigir a home
Route::get('home',[RestauranteController::class,'index']);

//Redirigir a login
Route::get('login',[RestauranteController::class,'login']);

//Redirigir a ayuda
Route::get('ayuda',[RestauranteController::class,'ayuda']);

//Redirigir a register
Route::get('register',[RestauranteController::class,'register']);