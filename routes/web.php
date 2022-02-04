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

Route::get('register',[RestauranteController::class,'register']);
Route::post('/registerPost',[RestauranteController::class,'registerPost']);
Route::get('login',[RestauranteController::class,'login']);
Route::get('ayuda',[RestauranteController::class,'ayuda']);
