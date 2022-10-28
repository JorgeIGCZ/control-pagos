<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\TitulacionController;
use App\Http\Controllers\PlantelController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\LicenciaturaController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\GeneracionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\ReestructuraController;
use App\Http\Controllers\GeneralFilterController;

class AjaxController extends Controller
{
    protected $AlumnoController;
    public function __construct(AlumnoController $AlumnoController,TitulacionController $TitulacionController,PlantelController $PlantelController,NivelController $NivelController, LicenciaturaController $LicenciaturaController,SistemaController $SistemaController, GrupoController $GrupoController, ConceptoController $ConceptoController,GeneracionController $GeneracionController,PagoController $PagoController,OrdenController $OrdenController,MatriculaController $MatriculaController,BecaController $BecaController,RoleController $RoleController,UsuarioController $UsuarioController,DescuentoController $DescuentoController,ReestructuraController $ReestructuraController,GeneralFilterController $GeneralFilterController)
    {
        $this->AlumnoController  = $AlumnoController;
        $this->TitulacionController  = $TitulacionController;
        $this->PlantelController = $PlantelController;
        $this->NivelController   = $NivelController;
        $this->LicenciaturaController = $LicenciaturaController;
        $this->SistemaController = $SistemaController;
        $this->GrupoController   = $GrupoController;
        $this->ConceptoController= $ConceptoController;
        $this->GeneracionController   = $GeneracionController;
        $this->PagoController    = $PagoController;
        $this->OrdenController   = $OrdenController;
        $this->MatriculaController = $MatriculaController;
        $this->BecaController      = $BecaController;
        $this->RoleController      = $RoleController;
        $this->UsuarioController   = $UsuarioController;
        $this->DescuentoController = $DescuentoController;
        $this->ReestructuraController = $ReestructuraController;
        $this->GeneralFilterController = $GeneralFilterController;
    }

    function getPago(Request $request){
        $pagoId = $_POST['pagoId'];
        $result = $this->PagoController->getPago($pagoId);
        return $result;
    }
    function updatePago(Request $request){
        $pagoId = $_POST['pagoId'];
        $datos   = $_POST['datos'];
        $result  = $this->PagoController->updatePago($pagoId,$datos);
        return $result;
    }

    function getOrden(Request $request){
        $ordenId = $_POST['ordenId'];
        $result = $this->OrdenController->getOrden($ordenId);
        return $result;
    }
    function updateOrden(Request $request){
        $ordenId = $_POST['ordenId'];
        $datos   = $_POST['datos'];
        $result  = $this->OrdenController->updateOrden($ordenId,$datos);
        return $result;
    }
    
    function createAlumno(Request $request){
        $alumno = $_POST['alumno'];
        $numeroAlumnos = $_POST['numeroAlumnos'];
        
        $result = $this->AlumnoController->createAlumno($alumno,$numeroAlumnos);
        return $result;
    }
    
    function updateDPAlumno(Request $request){
        $datos = $_POST['datos'];
        $actualizarColegiatura = $_POST['actualizarColegiatura'];
        $result = $this->AlumnoController->updateDPAlumno($datos,$actualizarColegiatura);
        return $result;
    }
    function updateGrupoAlumnos(Request $request){
        $datos    = $_POST['datos'];
        $newGrupo = $_POST['newGrupo'];
        $result = $this->AlumnoController->updateGrupoAlumnos($datos,$newGrupo);
        return $result;
    }
    
    function getAlumnos(Request $request){
        $datos  = $_POST['datos'];
        $result = $this->AlumnoController->getAlumnos($datos);
        return $result;
    }
    function getBajaAlumnos(Request $request){
        $datos  = $_POST['datos'];
        $result = $this->AlumnoController->getBajaAlumnos($datos);
        return $result;
    }
    function getAlumnosTitulaciones(Request $request){
        $datos  = $_POST['datos'];
        $result = $this->TitulacionController->getAlumnosTitulaciones($datos);
        return $result;
    }

    function getAllAlumnos(Request $request){
        $result = $this->AlumnoController->getAllAlumnos();
        return $result;
    }
    
    function suspAlumno(Request $request){
        $alumno = $_POST['alumno'];
        $result = $this->AlumnoController->suspAlumno($alumno);
        return $result;
    }
    
    function reestructurarAlumno(Request $request){
        $alumnoId = $_POST['alumnoId'];
        $detalles = $_POST['detalles'];

        $result = $this->ReestructuraController->reestructurarAlumno($alumnoId,$detalles);
        return $result;
    }
    
    function getAlumnoAll(Request $request){
        $alumno = $_POST['alumno'];
        $result = $this->AlumnoController->getAlumnoAll($alumno);
        return $result;
    }
    function descuentoIsValid(Request $request){
        $alumno      = $_POST['alumno'];
        $mensualidad = $_POST['mensualidad'];
        $result = $this->AlumnoController->descuentoIsValid($alumno,$mensualidad);
        return $result;
    }
    function getAllDescuentos(Request $request){
        $alumno      = $_POST['alumno'];
        $mensualidad = $_POST['mensualidad'];
        $result = $this->AlumnoController->getAllDescuentos($alumno,$mensualidad);
        return $result;
    }

    function recargoIsValid(Request $request){
        $alumno      = $_POST['alumno'];
        $mensualidad = $_POST['mensualidad'];
        $result = $this->AlumnoController->recargoIsValid($alumno,$mensualidad);
        return $result;
    }
    function getallrecargos(Request $request){
        $alumno      = $_POST['alumno'];
        $mensualidad = $_POST['mensualidad'];
        $result = $this->AlumnoController->getallrecargos($alumno,$mensualidad);
        return $result;
    }



    function getdescuento(Request $request){
        $alumno      = $_POST['alumno'];
        $result = $this->DescuentoController->getDescuento($alumno);
        return $result;
    }
    function createDescuento(Request $request){
        $descuento = $_POST['descuento'];
        $alumno    = $_POST['alumno'];
        $result = $this->DescuentoController->createDescuento($alumno,$descuento);
        return $result;
    }
    function getBecaAlumno(Request $request){
        $alumno      = $_POST['alumno'];
        $result = $this->AlumnoController->getBecaAlumno($alumno);
        return $result;
    }

    function getAlumnoConceptos(Request $request){
        $alumno = $_POST['alumno'];
        $result = $this->ReestructuraController->getAlumnoConceptos($alumno);
        return $result;
    }

    function getAlumnoAllBe(Request $request){
        $alumno       = $_POST['alumno'];
        $becaAlumnoId = $_POST['becaAlumnoId'];
        $result = $this->BecaController->getAlumnoAllBe($alumno,$becaAlumnoId);
        return $result;
    }
    function suspBecaAlumno(){
        $becaAlumno = $_POST['becaAlumno'];
        $result = $this->BecaController->suspBecaAlumno($becaAlumno);
        return $result;
    }
    function deleteBecaAlumno(){
        $becaAlumnoId = $_POST['becaAlumnoId'];
        $result = $this->BecaController->deleteBecaAlumno($becaAlumnoId);
        return $result;
    }
    
    function newBecaAlumno(Request $request){
        $datos  = $_POST['datos'];
        $result = $this->BecaController->newBecaAlumno($datos);
        return $result;
    }
    function updateBecaAlumno(Request $request){
        $becaAlumno  = $_POST['becaAlumno'];
        $result = $this->BecaController->updateBecaAlumno($becaAlumno);
        return $result;
    }
    function getBecaAlumnos(Request $request){
        $becaId = $_POST['becaId'];
        $datos = $_POST['datos'];
        $result = $this->BecaController->getBecaAlumnos($becaId,$datos);
        return $result;
    }
    
    function getAlumnosMatricula(Request $request){
        $datos  = $_POST['datos'];
        $result = $this->MatriculaController->getAlumnos($datos);
        return $result;
    }
    function createMatriculaPDF(Request $request){
        $datos  = $_POST['datos'];
        $result = $this->MatriculaController->createMatriculaPDF($datos);
        return $result;
    }
    function createCorteExcel(Request $request){
        $datos  = $_POST['datos'];
        $filename = $_POST['filename'];
        $result = $this->PagoController->createCorteExcel($datos,$filename);
        return $result;
    }
    
    function getAlumnoPago(Request $request){
        $alumnoId  = $_POST['alumnoId'];
        $plantelId  = @$_POST['plantelId'];
        $result    = $this->PagoController->getAlumnoPago($alumnoId,$plantelId);
        return $result;
    }
    function getAllPagos(Request $request){
        $datos  = @$_POST['datos'];
        $result = $this->PagoController->getAllPagos($datos);
        return $result;
    }
    function getAllPagosControl(Request $request){
        $datos  = @$_POST['datos'];
        $result = $this->PagoController->getAllPagosControl($datos);
        return $result;
    }
    function getPagosReportes(Request $request){
        $datos          = @$_POST['datos'];
        $datosBusqueda  = @$_POST['datosBusqueda'];
        $result = $this->PagoController->getPagosReportes($datos,$datosBusqueda);
        return $result;
    }
    function getAlumnoAllPagos(Request $request){
        $alumnoId  = $_POST['alumnoId'];
        $result    = $this->PagoController->getAlumnoAllPagos($alumnoId);
        return $result;
    }
    function getalumnopagostitulacion(Request $request){
        $alumnoId  = $_POST['alumnoId'];
        $result    = $this->PagoController->getAlumnoPagosTitulacion($alumnoId);
        return $result;
    }
    function getAlumnoAllColegiaturas(Request $request){
        $alumnoId  = $_POST['alumnoId'];
        $result    = $this->OrdenController->getAlumnoAllColegiaturas($alumnoId);
        return $result;
    }
    function getalumnoallmesesadeudo(Request $request){
        $alumnoId  = $_POST['alumnoId'];
        $result    = $this->OrdenController->getalumnoAllMesesAdeudo($alumnoId);
        return $result;
    }
    
    function createAlumnoPago(Request $request){
        $pago    = $_POST['pago'];
        $recargo = @$_POST['recargo'];
        $result  = $this->PagoController->createAlumnoPago($pago,$recargo);
        return $result;
    }

    function createAlumnoDescuento(Request $request){
        $descuentoDetalles    = $_POST['descuentoDetalles'];
        $result  = $this->PagoController->createAlumnoDescuento($descuentoDetalles);
        return $result;
    }
    
    function createPlantel(Request $request){
        $plantel= $_POST['plantel'];
        $result = $this->PlantelController->createPlantel($plantel);
        return $result;
    }
    function updatePlantel(Request $request){
        $plantel= $_POST['plantel'];
        $result = $this->PlantelController->updatePlantel($plantel);
        return $result;
    }
    function getPlanteles(Request $request){
        $result = $this->PlantelController->getPlanteles();
        return $result;
    }
    
    function createNivel(Request $request){
        $nivel= $_POST['nivel'];
        $result = $this->NivelController->createNivel($nivel);
        return $result;
    }
    function updateNivel(Request $request){
        $nivel= $_POST['nivel'];
        $result = $this->NivelController->updateNivel($nivel);
        return $result;
    }
    function getNiveles(Request $request){
        $result = $this->NivelController->getNiveles();
        return $result;
    }
    
    function createLicenciatura(Request $request){
        $licenciatura= $_POST['licenciatura'];
        $result = $this->LicenciaturaController->createLicenciatura($licenciatura);
        return $result;
    }
    function updateLicenciatura(Request $request){
        $licenciatura= $_POST['licenciatura'];
        $result = $this->LicenciaturaController->updateLicenciatura($licenciatura);
        return $result;
    }
    function getLicenciaturas(Request $request){
        $result = $this->LicenciaturaController->getLicenciaturas();
        return $result;
    }
    
    function createSistema(Request $request){
        $sistema= $_POST['sistema'];
        $result = $this->SistemaController->createSistema($sistema);
        return $result;
    }
    function updateSistema(Request $request){
        $sistema= $_POST['sistema'];
        $result = $this->SistemaController->updateSistema($sistema);
        return $result;
    }
    function getSistemas(Request $request){
        $result = $this->SistemaController->getSistemas();
        return $result;
    }
    
    function createGrupo(Request $request){
        $grupo= $_POST['grupo'];
        $result = $this->GrupoController->createGrupo($grupo);
        return $result;
    }
    function updateGrupo(Request $request){
        $grupo= $_POST['grupo'];
        $result = $this->GrupoController->updateGrupo($grupo);
        return $result;
    }
    function getGrupos(Request $request){
        $result = $this->GrupoController->getGrupos();
        return $result;
    }
    
    function createOrdenPeriodo(Request $request){
        $alumnoId = $_POST['alumnoId'];

        $result = $this->OrdenController->createOrdenPeriodo($alumnoId);
        return $result;
    }

    function createConcepto(Request $request){
        $concepto= $_POST['concepto'];
        $result = $this->ConceptoController->createConcepto($concepto);
        return $result;
    }
    function updateConcepto(Request $request){
        $concepto= $_POST['concepto'];
        $result = $this->ConceptoController->updateConcepto($concepto);
        return $result;
    }
    function updateConceptoRelaciones(Request $request){
        $relaciones= $_POST['relaciones'];
        $result = $this->ConceptoController->updateConceptoRelaciones($relaciones);
        return $result;
    }
    function getConceptos(Request $request){
        $result = $this->ConceptoController->getConceptos();
        return $result;
    }
    
    function createGeneracion(Request $request){
        $generacion        = $_POST['generacion'];
        $generacionPeriodos= $_POST['generacionPeriodos'];
        $result = $this->GeneracionController->createGeneracion($generacion,$generacionPeriodos);
        return $result;
    }
    function updateGeneracion(Request $request){
        $generacion        = $_POST['generacion'];
        $result = $this->GeneracionController->updateGeneracion($generacion);
        return $result;
    }
    function updateGeneracionPeriodos(Request $request){
        $generacionPeriodos= $_POST['generacionPeriodos'];
        $generacionId      = $_POST['generacionId'];
        $result = $this->GeneracionController->updateGeneracionPeriodos($generacionId,$generacionPeriodos);
        return $result;
    }
    function getGeneraciones(Request $request){
        $result = $this->GeneracionController->getGeneraciones();
        return $result;
    }
    
    function createBeca(Request $request){
        $beca   = $_POST['beca'];
        $result = $this->BecaController->createBeca($beca);
        return $result;
    }
    function updateBeca(Request $request){
        $beca   = $_POST['beca'];
        $result = $this->BecaController->updateBeca($beca);
        return $result;
    }
    function getBecas(Request $request){
        $result = $this->BecaController->getBecas();
        return $result;
    }
    
    function updateRole(Request $request){
        $data   = $_POST['data'];
        $roleId = $_POST['roleId'];
        $result = $this->RoleController->updateRole($data,$roleId);
        return $result;
    }


    function getUsuarios(Request $request){
        $result = $this->UsuarioController->getUsuarios();
        return $result;
    }
    function updateUsuario(Request $request){
        $datos   = $_POST['datos'];
        $result  = $this->UsuarioController->updateUsuario($datos);
        return $result;
    }
    function createUsuario(Request $request){
        $datos   = $_POST['datos'];
        $result  = $this->UsuarioController->createUsuario($datos);
        return $result;
    }


    function getDinamicFilterOptions(Request $request){
        $item      = $_POST['item'];
        $selection = $_POST['selection'];
        $result    = $this->GeneralFilterController->getDinamicFilterOptions($item,$selection);
        return $result;
    }
}
