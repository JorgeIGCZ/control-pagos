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

Route::apiResource('plantel', PlantelapiController::class);
//Route::get('disponibilidad/actividadDisponibilidad/{id}/{fecha}/{horario}',[DisponibilidadApiController::class,'actividadDisponibilidad']);

// -plantel
Route::apiResource('nivel', NivelapiController::class);
Route::get('nivel/busqueda/{plantel}/{estatus}',[NivelapiController::class,'busqueda']);

Route::apiResource('sistema', SistemaapiController::class);

// -plantel, -nivel
Route::apiResource('licenciatura', LicenciaturaapiController::class);
Route::get('licenciatura/busqueda/{plantel}/{nivel}/{estatus}',[LicenciaturaapiController::class,'busqueda']);

// -plantel
Route::apiResource('generacion', GeneracionapiController::class);
Route::get('generacion/busqueda/{plantel}/{estatus}',[GeneracionapiController::class,'busqueda']);

// -plantel, -nivel, -licenciatura, -sistema
Route::apiResource('grupo', GrupoapiController::class);
Route::get('grupo/busqueda/{plantel}/{nivel}/{licenciatura}/{sistema}/{estatus}',[GrupoapiController::class,'busqueda']);

// -plantel, -nivel, -licenciatura, -sistema, -grupo, -generacion
Route::apiResource('alumno', AlumnoapiController::class);
Route::get('alumno/busqueda/{plantel}/{nivel}/{licenciatura}/{sistema}/{grupo}/{generacion}/{estatus}',[AlumnoapiController::class,'busqueda']);