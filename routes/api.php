<?php

use App\Http\Controllers\SystemControllers\DocumentosController;
use App\Http\Controllers\SystemControllers\ReunioesController;
use App\Http\Controllers\SystemControllers\VereadorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('vereador',[VereadorController::class,'index']);
Route::post('vereador',[VereadorController::class,'store']);
Route::put('vereador/{id}',[VereadorController::class,'update']);
Route::delete('vereador/{id}',[VereadorController::class,'destroy']);

Route::get('reuniao',[ReunioesController::class,'index']);
Route::post('reuniao',[ReunioesController::class,'store']);
Route::put('reuniao/{id}',[ReunioesController::class,'update']);
Route::delete('reuniao/{id}',[ReunioesController::class,'destroy']);

Route::get('documento',[DocumentosController::class,'index']);
Route::post('documento',[DocumentosController::class,'store']);
Route::put('documento/{id}',[DocumentosController::class,'update']);
Route::delete('documento/{id}',[DocumentosController::class,'destroy']);
