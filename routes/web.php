<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\PlantelController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\LicenciaturaController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\GeneracionController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReestructuraController;
use App\Http\Controllers\TitulacionController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\AjaxController;

use App\Http\Controllers\GeneralFilterController;
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

Route::post('ajax/newalumno',[AjaxController::class,'createAlumno']);
Route::post('ajax/updatedpalumno',[AjaxController::class,'updateDPAlumno']);
Route::post('ajax/getalumnos',[AjaxController::class,'getAlumnos']);
Route::post('ajax/getbajaalumnos',[AjaxController::class,'getBajaAlumnos']);
Route::post('ajax/getalumnostitulaciones',[AjaxController::class,'getAlumnosTitulaciones']);
Route::post('ajax/getallalumnos',[AjaxController::class,'getAllAlumnos']);
Route::post('ajax/updateGrupoAlumnos',[AjaxController::class,'updateGrupoAlumnos']);

Route::post('ajax/suspalumno',[AjaxController::class,'suspAlumno']);

Route::post('ajax/getalumnosmatricula',[AjaxController::class,'getAlumnosMatricula']);

Route::post('ajax/getalumnoallcolegiaturas',[AjaxController::class,'getAlumnoAllColegiaturas']);
Route::post('ajax/getalumnoallmesesadeudo',[AjaxController::class,'getAlumnoAllMesesAdeudo']);
Route::post('ajax/getallpagos',[AjaxController::class,'getAllPagos']);
Route::post('ajax/getallpagoscontrol',[AjaxController::class,'getAllPagosControl']);

Route::post('ajax/getpagosreportes',[AjaxController::class,'getPagosReportes']);

Route::post('ajax/getalumnoallpagos',[AjaxController::class,'getAlumnoAllPagos']);
Route::post('ajax/getalumnopagostitulacion',[AjaxController::class,'getAlumnoPagosTitulacion']);
Route::post('ajax/getalumnopago',[AjaxController::class,'getAlumnoPago']);
Route::post('ajax/savealumnopago',[AjaxController::class,'saveAlumnoPago']);
Route::post('ajax/newalumnopago',[AjaxController::class,'createAlumnoPago']);
Route::post('ajax/newalumnodescuento',[AjaxController::class,'createAlumnoDescuento']);


Route::post('ajax/getpago',[AjaxController::class,'getPago']);
Route::post('ajax/updatepago',[AjaxController::class,'updatePago']);

Route::post('ajax/newdescuento',[AjaxController::class,'createDescuento']);
Route::post('ajax/getdescuento',[AjaxController::class,'getdescuento']);

Route::post('ajax/descuentoIsValid',[AjaxController::class,'descuentoIsValid']);
Route::post('ajax/getalldescuentos',[AjaxController::class,'getAllDescuentos']);


//Route::post('ajax/newrecargo',[AjaxController::class,'createRecargp']);
//Route::post('ajax/getrecargo',[AjaxController::class,'getrecargo']);

Route::post('ajax/recargoIsValid',[AjaxController::class,'recargoIsValid']);
Route::post('ajax/getallrecargos',[AjaxController::class,'getAllRecargos']);


Route::post('ajax/getalumnoall',[AjaxController::class,'getAlumnoAll']);
Route::post('ajax/getalumnoconceptos',[AjaxController::class,'getAlumnoConceptos']);
Route::post('ajax/getalumnoallbe',[AjaxController::class,'getAlumnoAllBe']);
Route::post('ajax/suspbecaalumno',[AjaxController::class,'suspBecaAlumno']);
Route::post('ajax/deletebecaalumno',[AjaxController::class,'deleteBecaAlumno']);
Route::post('ajax/updatebecaalumno',[AjaxController::class,'updateBecaAlumno']);

Route::post('ajax/getbecaalumno',[AjaxController::class,'getBecaAlumno']);

Route::post('ajax/suspalumnobe',[AjaxController::class,'suspalumno']);
Route::post('ajax/deletepalumnobe',[AjaxController::class,'deletepalumno']);

Route::post('ajax/getbecaalumnos',[AjaxController::class,'getBecaAlumnos']);
Route::post('ajax/newbecaalumno',[AjaxController::class,'newBecaAlumno']);

Route::post('ajax/newplantel',[AjaxController::class,'createPlantel']);
Route::post('ajax/updateplantel',[AjaxController::class,'updatePlantel']);
Route::get('ajax/getplanteles',[AjaxController::class,'getPlanteles']);

Route::post('ajax/newnivel',[AjaxController::class,'createNivel']);
Route::post('ajax/updatenivel',[AjaxController::class,'updateNivel']);
Route::get('ajax/getniveles',[AjaxController::class,'getNiveles']);

Route::post('ajax/newlicenciatura',[AjaxController::class,'createLicenciatura']);
Route::post('ajax/updatelicenciatura',[AjaxController::class,'updateLicenciatura']);
Route::get('ajax/getlicenciaturas',[AjaxController::class,'getLicenciaturas']);

Route::post('ajax/newsistema',[AjaxController::class,'createSistema']);
Route::post('ajax/updatesistema',[AjaxController::class,'updateSistema']);
Route::get('ajax/getsistemas',[AjaxController::class,'getSistemas']);

Route::post('ajax/newgrupo',[AjaxController::class,'createGrupo']);
Route::post('ajax/updategrupo',[AjaxController::class,'updateGrupo']);
Route::get('ajax/getgrupos',[AjaxController::class,'getGrupos']);

Route::post('ajax/newconcepto',[AjaxController::class,'createConcepto']);
Route::post('ajax/updateconcepto',[AjaxController::class,'updateConcepto']);
Route::post('ajax/updateconceptorelaciones',[AjaxController::class,'updateConceptoRelaciones']);
Route::get('ajax/getconceptos',[AjaxController::class,'getConceptos']);

Route::post('ajax/newgeneracion',[AjaxController::class,'createGeneracion']);
Route::post('ajax/updategeneracion',[AjaxController::class,'updateGeneracion']);
Route::post('ajax/updategeneracionperiodos',[AjaxController::class,'updateGeneracionPeriodos']);
Route::get('ajax/getgeneraciones',[AjaxController::class,'getGeneraciones']);

Route::post('ajax/newbeca',[AjaxController::class,'createBeca']);
Route::post('ajax/updatebeca',[AjaxController::class,'updateBeca']);
Route::get('ajax/getbecas',[AjaxController::class,'getBecas']);

Route::post('ajax/updaterole',[AjaxController::class,'updateRole']);

Route::get('ajax/getusuarios',[AjaxController::class,'getUsuarios']);
Route::post('ajax/updateusuario',[AjaxController::class,'updateUsuario']);
Route::post('ajax/createusuario',[AjaxController::class,'createUsuario']);


Route::post('ajax/createOrdenPeriodo',[AjaxController::class,'createOrdenPeriodo']);
Route::post('ajax/getorden',[AjaxController::class,'getOrden']);
Route::post('ajax/updateorden',[AjaxController::class,'updateOrden']);


Route::post('ajax/creatematriculapdf',[AjaxController::class,'createMatriculaPDF']);
Route::post('ajax/createCorteExcel',[AjaxController::class,'createCorteExcel']);


Route::post('ajax/reestructuraralumno',[AjaxController::class,'reestructurarAlumno']);


Route::post('ajax/getdinamicfilteroptions',[AjaxController::class,'getDinamicFilterOptions']);
/*
Route::get('/', function () {
    return view('welcome');
});*/



Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/',[DashboardController::class,'indexAction']);

    Route::get('matricula',[MatriculaController::class,'indexAction']);
    Route::get('alumnos',[AlumnoController::class,'indexAction']);
    Route::get('alumnos/new',[AlumnoController::class,'newAction']);
    Route::get('alumnos/view',[AlumnoController::class,'viewAction']);
    Route::get('alumnos/update-grupo',[AlumnoController::class,'updateGrupoAction']);

    Route::get('titulaciones',[TitulacionController::class,'indexAction']);

    Route::get('reestructura',[ReestructuraController::class,'indexAction']);
    
    Route::get('planteles',[PlantelController::class,'indexAction']);
    Route::get('planteles/new',[PlantelController::class,'newAction']);
    Route::get('planteles/view',[PlantelController::class,'viewAction']);
    
    Route::get('niveles',[NivelController::class,'indexAction']);
    Route::get('niveles/new',[NivelController::class,'newAction']);
    Route::get('niveles/view',[NivelController::class,'viewAction']);
    
    Route::get('licenciaturas',[LicenciaturaController::class,'indexAction']);
    Route::get('licenciaturas/new',[LicenciaturaController::class,'newAction']);
    Route::get('licenciaturas/view',[LicenciaturaController::class,'viewAction']);
    
    Route::get('sistemas',[SistemaController::class,'indexAction']);
    Route::get('sistemas/new',[SistemaController::class,'newAction']);
    Route::get('sistemas/view',[SistemaController::class,'viewAction']);
    
    Route::get('grupos',[GrupoController::class,'indexAction']);
    Route::get('grupos/new',[GrupoController::class,'newAction']);
    Route::get('grupos/view',[GrupoController::class,'viewAction']);
    
    Route::get('conceptos',[ConceptoController::class,'indexAction']);
    Route::get('conceptos/new',[ConceptoController::class,'newAction']);
    Route::get('conceptos/view',[ConceptoController::class,'viewAction']);
    
    Route::get('generaciones',[GeneracionController::class,'indexAction']);
    Route::get('generaciones/new',[GeneracionController::class,'newAction']);
    Route::get('generaciones/view',[GeneracionController::class,'viewAction']);
    
    Route::get('becas',[BecaController::class,'indexAction']);
    Route::get('becas/new',[BecaController::class,'newAction']);
    Route::get('becas/view',[BecaController::class,'viewAction']);
    
    Route::get('pagos',[pagoController::class,'indexAction']);
    
    Route::get('controlpagos',[pagoController::class,'controlPagosAction']);

    Route::get('usuarios',[UsuarioController::class,'indexAction']);
    Route::get('usuarios/view',[UsuarioController::class,'viewAction']);
    Route::get('roles',[roleController::class,'indexAction']);

    
});
Route::get('/logoutcontrol', function () {
    return view('logoutcontrol');
});

Route::get('createOrdenes',[OrdenController::class,'createOrdenes']);
Route::get('test',[OrdenController::class,'test']);
Route::get('clearDescuentos',[DescuentoController::class,'clearDescuentos']);

Route::get('verifyFinalizados',[AlumnoController::class,'verifyFinalizados']);
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
    //return view('dashboard.index');
})->name('dashboard');
*/
