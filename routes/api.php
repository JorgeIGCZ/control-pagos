<?php

use App\Http\Controllers\API\AlumnoapiController;
use App\Http\Controllers\API\GeneracionapiController;
use App\Http\Controllers\API\GrupoapiController;
use App\Http\Controllers\API\LicenciaturaapiController;
use App\Http\Controllers\API\NivelapiController;
use App\Http\Controllers\API\PlantelapiController;
use App\Http\Controllers\API\SistemaapiController;
use App\Http\Resources\GeneracionResource;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('plantel',[PlantelapiController::class,'show']);

// -plantel
Route::get('nivel',[NivelapiController::class,'show']);

Route::get('sistema',[SistemaapiController::class,'show']);

// -plantel, -nivel
Route::get('licenciatura',[LicenciaturaapiController::class,'show']);

// -plantel
Route::get('generacion',[GeneracionapiController::class,'show']);

// -plantel, -nivel, -licenciatura, -sistema
Route::get('grupo',[GrupoapiController::class,'show']);

// -plantel, -nivel, -licenciatura, -sistema, -grupo, -generacion
Route::get('alumno',[AlumnoapiController::class,'show']);