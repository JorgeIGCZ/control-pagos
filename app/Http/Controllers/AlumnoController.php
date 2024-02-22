<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnos;
use App\Models\Alumno_relaciones;
use App\Http\Controllers\OrdenController;
use App\Models\Ordenes;
use Illuminate\Support\Facades\DB;
use URL;


class AlumnoController extends Controller 
{
    function indexAction(){
        if ((@session()->get('user_roles')['Alumnos']->Ver != 'Y') || (!is_array(@session()->get('user_roles')))){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        $whereQuery = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        
        $plantel        = DB::select('SELECT * FROM planteles WHERE Id = '.@$_GET['Id'].' ');
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas L WHERE Plantel_id = '.@$_GET['Id'].' ');
        $niveles        = DB::select('SELECT * FROM niveles N WHERE Plantel_id = '.@$_GET['Id'].' ');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos ');
        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Tipo IN ("colegiatura","inscripcion") ORDER BY Nombre ASC ');
        $titulacion     = DB::select('SELECT * FROM conceptos WHERE Tipo = "titulacion"   AND Plantel_id = '.@$_GET['Id'].' AND Estatus = 1');
        $prontoPago     = DB::select('SELECT * FROM conceptos WHERE Tipo = "pronto-pago"  AND Plantel_id = '.@$_GET['Id'].' AND Estatus = 1');
        $recargoPagos   = DB::select('SELECT * FROM conceptos WHERE Tipo = "recargo-pago" AND Plantel_id = '.@$_GET['Id'].' AND Estatus = 1');
        $generaciones   = DB::select('SELECT G.Id,G.Nombre,G.Fecha_inicio,G.Fecha_finalizacion,G.Periodo,G.Plantel_id FROM generaciones G LEFT JOIN alumno_relaciones AR ON AR.Generacion_id = G.Id LEFT JOIN alumnos A ON A.Id = AR.Alumno_id WHERE A.Estatus = 1 AND G.Plantel_id = '.@$_GET['Id'].' GROUP BY G.Id,G.Nombre,G.Fecha_inicio,G.Fecha_finalizacion,G.Periodo,G.Plantel_id HAVING COUNT(AR.Id) > 0');

        
        return view('alumnos.index',['plantel' => $plantel[0]->Nombre,'planteles' => $plantel,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'conceptos' => $conceptos,'titulacion' => $titulacion,'prontoPago' => $prontoPago,'recargoPagos' => $recargoPagos,'generaciones' => $generaciones]);
    }
    function newAction(){
        if (session()->get('user_roles')['Alumnos']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        $estatusQuery = " Estatus = 1 ";
        if (session()->get('user_roles')['role'] === 'Administrador'){
            $estatusQuery = " Estatus IN (1,10) ";
        }

        $plantel        = DB::select('SELECT * FROM planteles WHERE Id = '.@$_GET['Id'].' ');
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas WHERE Plantel_id = '.@$_GET['Id'].' ');
        $niveles        = DB::select('SELECT * FROM niveles WHERE Plantel_id = '.@$_GET['Id'].' AND Estatus = 1');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos WHERE Estatus = 1 ORDER BY Nombre ASC ');


        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Tipo ="colegiatura" AND '.$estatusQuery.' AND Plantel_id = '.@$_GET['Id'].' AND Estatus = 1 ORDER BY Nombre ASC ');
        $titulaciones   = DB::select('SELECT * FROM conceptos WHERE Tipo ="titulacion" AND '.$estatusQuery.' AND Plantel_id = '.@$_GET['Id'].'  AND Estatus = 1');
        $cuotas         = DB::select('SELECT * FROM conceptos WHERE Tipo ="cuota-personalizada-anual" AND '.$estatusQuery.' AND Plantel_id = '.@$_GET['Id'].' AND Estatus = 1 ORDER BY Nombre ASC');
        $inscripciones  = DB::select('SELECT * FROM conceptos WHERE Tipo ="inscripcion" AND '.$estatusQuery.' AND Plantel_id = '.@$_GET['Id'].' AND Estatus = 1 ORDER BY Nombre ASC');
        


        $generaciones   = DB::select('SELECT * FROM generaciones WHERE Plantel_id = '.@$_GET['Id'].' AND Estatus = 1 ORDER BY Nombre DESC ');
        
        return view('alumnos.new',['planteles' => $plantel,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'conceptos' => $conceptos,'generaciones' => $generaciones,'titulaciones' => $titulaciones,'cuotas' => $cuotas,'inscripciones' => $inscripciones]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Alumnos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $alumnoId = $_GET['alumno'];
        

        $alumno   = DB::select('SELECT Id,Nombre,Apellido_materno,Apellido_paterno,Email,Telefono,Estatus,Nombre_tutor,Telefono_tutor,DATE_FORMAT(Fecha_inicio, "%Y-%m") AS Fecha_inicio FROM alumnos WHERE Id = :Id', ['Id' => $alumnoId]);
        $alumnoRelaciones   = DB::select('SELECT Plantel_id FROM alumno_relaciones WHERE Alumno_id = :Id', ['Id' => $alumnoId]);
        
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas ');
        $niveles        = DB::select('SELECT * FROM niveles  ');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos ');
        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Tipo ="colegiatura" AND Estatus = 1 ORDER BY Nombre ASC ');
        $titulaciones   = DB::select('SELECT * FROM conceptos WHERE Tipo ="titulacion" AND Estatus = 1 ');
        $inscripciones  = DB::select('SELECT * FROM conceptos WHERE Tipo ="inscripcion" AND Estatus = 1 ORDER BY Nombre ASC ');
        $cuotas         = DB::select('SELECT * FROM conceptos WHERE Tipo ="cuota-personalizada-anual" AND Estatus = 1 ');
        $generaciones   = DB::select('SELECT * FROM generaciones WHERE Estatus = 1 ORDER BY Nombre DESC ');
        $informacion    = DB::select('SELECT * FROM alumno_relaciones WHERE Alumno_Id = :Id', ['Id' => $alumnoId]);
        $prontoPago     = DB::select('SELECT * FROM conceptos WHERE Tipo = "pronto-pago" AND Plantel_id = '.@$alumnoRelaciones[0]->Plantel_id);

        $precioTitulacion = DB::select('SELECT IF(C.Precio > 0,C.Precio,0) AS precio FROM alumno_relaciones AR LEFT JOIN conceptos C ON C.id = AR.Concepto_titulacion_id WHERE AR.Alumno_Id = :Id', ['Id' => $alumnoId]);
        
        return view('alumnos.view',['informacion' => $informacion,'precioTitulacion' => $precioTitulacion,'alumno' => $alumno,'planteles' => $planteles,'licenciaturas' => $licenciaturas,'titulaciones' => $titulaciones,'cuotas' => $cuotas,'inscripciones' => $inscripciones,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'conceptos' => $conceptos,'generaciones' => $generaciones,'prontoPago' => $prontoPago]);
    }
    function updateGrupoAction(){
        //if (session()->get('user_roles')['role'] === 'Administrador'){
        //    header("Location: " . URL::to('/login'), true, 302);
        //    exit();
        //}

        $whereQuery = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        
        $plantel        = DB::select('SELECT * FROM planteles WHERE Id = '.@$_GET['Id'].' ');
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas L WHERE Plantel_id = '.@$_GET['Id'].' ');
        $niveles        = DB::select('SELECT * FROM niveles N WHERE Plantel_id = '.@$_GET['Id'].'  ');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos WHERE Plantel_id = '.@$_GET['Id'].' ');
        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Tipo IN ("colegiatura","inscripcion") ');
        $titulacion     = DB::select('SELECT * FROM conceptos WHERE Tipo ="titulacion"    AND Plantel_id = '.@$_GET['Id']);
        $prontoPago     = DB::select('SELECT * FROM conceptos WHERE Tipo = "pronto-pago"  AND Plantel_id = '.@$_GET['Id']);
        $recargoPagos   = DB::select('SELECT * FROM conceptos WHERE Tipo = "recargo-pago" AND Plantel_id = '.@$_GET['Id']);

        $generaciones   = DB::select('SELECT * FROM generaciones WHERE Plantel_id = '.@$_GET['Id'].' ');
        
        return view('alumnos.updateGrupo',['plantel' => $plantel[0]->Nombre,'planteles' => $plantel,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'conceptos' => $conceptos,'titulacion' => $titulacion,'prontoPago' => $prontoPago,'recargoPagos' => $recargoPagos,'generaciones' => $generaciones]);
    }
    function suspAlumno($alumno){
        $alumnoId  = $alumno['id'];
        $fechaBaja = $alumno['fechaBaja'];
        $estatus   = ($alumno['estatus'] == 0 ? 1 : 0);
        $result = '';
        try{
            $becas = alumnos::where('Id', $alumnoId)->update(['Estatus' => $estatus,'Fecha_baja' => $fechaBaja]);
            $result = ['success','¡Alumno dado de baja exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e);
            $result = ['error','¡Error al dar de baja al alumno!'];
        }
        return $result;
    }
    function getAllAlumnos(){
        $alumnosQuery = 'SELECT A.Id,@total := @total + 1 AS provId,CONCAT(A.Nombre," ",A.Apellido_paterno," ",A.Apellido_materno) AS Nombre,A.Email,A.Telefono,Estatus,Nombre_tutor,Telefono_tutor '.
                        'FROM alumnos A                                        '.
                        'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id ';
        DB::statement( DB::raw( 'SET @total := 0'));
        $alumnos = DB::select($alumnosQuery);
        
        return ['data'=>$alumnos];
    }
    function getAlumnoAll($alumno){
        $alumnoId = $alumno['id'];
        $alumno   = DB::select('SELECT * FROM alumnos WHERE Id ='.$alumnoId);
        $concepto = DB::select('select * FROM alumno_relaciones AR LEFT JOIN conceptos C ON C.Id = AR.Concepto_id WHERE AR.Alumno_id = '.$alumnoId);
        

        $periodos = DB::select('select CP.Periodo_numero,CP.Generacion_id,CP.Id,CONCAT(CP.Fecha_inicio," - ",CP.Fecha_finalizacion) AS fecha FROM alumno_relaciones AR LEFT JOIN generacion_periodos CP ON CP.Generacion_id = AR.Generacion_id WHERE AR.Alumno_id = '.$alumnoId);
        
        return ['alumno'=>$alumno,'concepto'=>$concepto,'periodos'=>$periodos];
    }
    function descuentoIsValid($alumno,$mensualidad){

        $monthDay = date_create_from_format('j',date('j'));
        $monthDay->setTimezone(new \DateTimeZone('America/Mexico_City'));
        $monthDay = $monthDay->format('j');

        $alumnoId = $alumno['id'];
        $ordenId  = $mensualidad['id'];
        $result   = false;
        $oldDiscountsQuery = ''.
                            'SELECT COUNT(P.Id) AS descuentos '.
                            'FROM pagos P                '.
                            'LEFT JOIN conceptos C ON C.Id = P.Descripcion '.
                            'WHERE P.Alumno_id = '.$alumnoId.' AND P.Orden_id = '.$ordenId.' AND C.Tipo = "pronto-pago" ';
        
        $oldDiscounts = DB::select($oldDiscountsQuery);
        if($oldDiscounts[0]->descuentos < 1){
            $isCurrentOrderQuery = ''.
                            'SELECT COUNT(O.Id) AS isCurrent '.
                            'FROM ordenes O                '.
                            'WHERE O.Id = '.$ordenId.' AND MONTH(O.Fecha_creacion) = MONTH(CURDATE()) AND YEAR(O.Fecha_creacion) = YEAR(CURDATE())';
            
            $isFutureOrderQuery = ''.
                            'SELECT COUNT(O.Id) AS isFuture '.
                            'FROM ordenes O                '.
                            'WHERE O.Id = '.$ordenId.' AND O.Fecha_creacion >= CURDATE()';

            $isCurrentOrder = DB::select($isCurrentOrderQuery);
            if($isCurrentOrder[0]->isCurrent){
                if($monthDay < 6){
                    $result = true;
                }
            }else{
                $isFutureOrder = DB::select($isFutureOrderQuery);
                if($isFutureOrder[0]->isFuture){
                    $result = true;
                }
            }
        }
        return ['result'=>$result];
    }

    function getValidDescuentos($alumno, $concepto, $orden, $plantel){
        $monthDay = date_create_from_format('j',date('j'));
        $monthDay->setTimezone(new \DateTimeZone('America/Mexico_City'));
        $monthDay = $monthDay->format('j');

        $alumnoId  = $alumno['id'];
        $conceptoId= $concepto['id'];
        $ordenId   = $orden['id'];
        $plantelId = $plantel['id'];
        $result   = false;

        $allDescuentos = [];

        // Descuentos Pronto Pago
        if(!$this->isDiscountAlreadyApplied($alumnoId, $ordenId)){
            // Descuentos Pronto Pago Colegiatura - Inscripcion
            if($this->canShowDescuentosProntoPago('colegiatura-inscripcion', $conceptoId)){
                $allDescuentos = $this->getProntoPagoDescuentos($monthDay, $ordenId, $plantelId);
            }

            // Descuentos Pronto Pago Titulacion
            if($this->canShowDescuentosProntoPago('titulacion', $conceptoId)){
                $allDescuentos = $this->getProntoPagoTitulacionDescuentos($monthDay, $plantelId);
            }
        }

        // Descuentos generales
        $descuentosGenerales = $this->getDescuentosGenerales($plantelId);
        if(count($descuentosGenerales) > 0){
            $allDescuentos = array_merge($allDescuentos, $descuentosGenerales);
        }

        return ['result'=>$allDescuentos];
    }

    function getProntoPagoDescuentos($monthDay, $ordenId, $plantelId){
        $descuentos = [];

        if($ordenId == 0){
            return $descuentos;
        }

        $prontoPagoDescuentos = DB::select('SELECT * FROM conceptos WHERE Tipo = "pronto-pago"  AND Plantel_id = '.@$plantelId.' AND Estatus = 1');


        $isCurrentOrderQuery = ''.
                            'SELECT COUNT(O.Id) AS isCurrent '.
                            'FROM ordenes O                '.
                            'WHERE O.Id = '.$ordenId.' AND MONTH(O.Fecha_creacion) = MONTH(CURDATE()) AND YEAR(O.Fecha_creacion) = YEAR(CURDATE())';
            
        $isFutureOrderQuery = ''.
                        'SELECT COUNT(O.Id) AS isFuture '.
                        'FROM ordenes O                '.
                        'WHERE O.Id = '.$ordenId.' AND O.Fecha_creacion >= CURDATE()';

        $isCurrentOrder = DB::select($isCurrentOrderQuery)[0]->isCurrent;
        $isFutureOrder = DB::select($isFutureOrderQuery)[0]->isFuture;

        foreach($prontoPagoDescuentos as $prontoPagoDescuento){

            if($isFutureOrder){
                $descuentos[] = $prontoPagoDescuento;
                continue;
            }

            if($isCurrentOrder){
                if($monthDay < $prontoPagoDescuento->Dias || session()->get('user_roles')['role'] === 'Administrador'){
                    $descuentos[] = $prontoPagoDescuento;
                }
            }
        }

        return $descuentos;
    }

    function getRecargos($monthDay, $ordenId, $plantelId){
        $recargos = [];

        if($ordenId == 0){
            return $recargos;
        }

        $allRecargos = DB::select('SELECT * FROM conceptos WHERE Tipo = "recargo-pago"  AND Plantel_id = '.@$plantelId.' AND Estatus = 1');


        $isCurrentOrderQuery = ''.
                            'SELECT COUNT(O.Id) AS isCurrent '.
                            'FROM ordenes O                '.
                            'WHERE O.Id = '.$ordenId.' AND MONTH(O.Fecha_creacion) = MONTH(CURDATE()) AND YEAR(O.Fecha_creacion) = YEAR(CURDATE())';
            
        $isFutureOrderQuery = ''.
                        'SELECT COUNT(O.Id) AS isFuture '.
                        'FROM ordenes O                '.
                        'WHERE O.Id = '.$ordenId.' AND O.Fecha_creacion >= CURDATE()';

        $isCurrentOrder = DB::select($isCurrentOrderQuery)[0]->isCurrent;
        $isFutureOrder = DB::select($isFutureOrderQuery)[0]->isFuture;

        foreach($allRecargos as $recargo){

            if($isFutureOrder){
                continue;
            }

            if($isCurrentOrder){
                if($monthDay > $recargo->Dias){
                    $recargos[] = $recargo;
                }
            }
        }

        return $recargos;
    }

    function getProntoPagoTitulacionDescuentos($monthDay, $plantelId){
        $descuentos = [];
        $prontoPagoDescuentos = DB::select('SELECT * FROM conceptos WHERE Tipo = "pronto-pago-titulacion"  AND Plantel_id = '.@$plantelId.' AND Estatus = 1');

        foreach($prontoPagoDescuentos as $prontoPagoDescuento){
            if($monthDay < $prontoPagoDescuento->Dias || session()->get('user_roles')['role'] === 'Administrador'){
                $descuentos[] = $prontoPagoDescuento;
            }
        }

        return $descuentos;
    }

    function getDescuentosGenerales($plantelId){
        return DB::select('SELECT * FROM conceptos WHERE Tipo = "descuentos"  AND Plantel_id = '.@$plantelId.' AND Estatus = 1');
    }

    function canShowDescuentosProntoPago($tipo, $conceptoId){
        $result = false;
        $tiposToEvaluate = [];

        if (session()->get('user_roles')['role'] === 'Administrador'){
            return true;
        }

        switch ($tipo) {
            case 'colegiatura-inscripcion':
                $tiposToEvaluate = ['colegiatura', 'inscripcion'];
                break;

            case 'titulacion':
                $tiposToEvaluate = ['titulacion'];
                break;
        }
        

        $ordenConceptoTipo = DB::select('SELECT C.Tipo FROM conceptos C LEFT JOIN ordenes O ON O.Concepto_id = C.Id WHERE O.Concepto_id = '.$conceptoId);
        
        if(!in_array($ordenConceptoTipo[0]->Tipo, $tiposToEvaluate)){
            return false;
        }

        return true;    
    }

    function isDiscountAlreadyApplied($alumnoId, $ordenId){
        $currentDiscountsQuery = ''.
                            'SELECT COUNT(P.Id) AS descuentos '.
                            'FROM pagos P                '.
                            'LEFT JOIN conceptos C ON C.Id = P.Descripcion '.
                            'WHERE P.Alumno_id = '.$alumnoId.' AND P.Orden_id = '.$ordenId.' AND C.Tipo IN ("pronto-pago", "pronto-pago-titulacion") ';
        
        $currentDiscounts = DB::select($currentDiscountsQuery);
        
        return ($currentDiscounts[0]->descuentos > 0);
    }

    function isRecargoAlreadyApplied($alumnoId, $ordenId){
        $currentRecargosQuery = ''.
                            'SELECT COUNT(P.Id) AS recargos '.
                            'FROM pagos P                   '.
                            'LEFT JOIN conceptos C ON C.Id = P.Descripcion '.
                            'WHERE P.Alumno_id = '.$alumnoId.' AND P.Orden_id = '.$ordenId.' AND C.Tipo = "recargo-pago" ';
        

        $currentRecargos = DB::select($currentRecargosQuery);
        
        return ($currentRecargos[0]->recargos > 0);
    }


    function getAllDescuentos($alumno,$mensualidad){
        $alumnoId = $alumno['id'];
        $ordenId  = $mensualidad['id'];
        $descuentosQuery = ''.
                            'SELECT P.Cantidad_pago '.
                            'FROM pagos P                '.
                            'LEFT JOIN conceptos C ON C.Id = P.Descripcion '.
                            'WHERE P.Alumno_id = '.$alumnoId.' AND P.Orden_id = '.$ordenId.' AND C.Tipo = "descuentos" ';
        

        $descuentos        = DB::select($descuentosQuery);
        $cantidadDescuento = 0;
        foreach ($descuentos as $descuento) {
            $cantidadDescuento += $descuento->Cantidad_pago;
        }

        return ['descuento'=>$cantidadDescuento];
    }
    function recargoIsValid($alumno,$mensualidad){

        $currentDate     = date_create_from_format('Y-m-d',date('Y-m-d'));
        $currentDate->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        $currentDay   = $currentDate->format('d');
        $currentMonth = $currentDate->format('m');
        $currentYear  = $currentDate->format('Y');
    
        $currentMonthYear = date_create_from_format('Y-m-d',date($currentYear.'-'.$currentMonth.'-01'));
        $currentMonthYear->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        $alumnoId = $alumno['id'];
        $ordenId  = $mensualidad['id'];
        $result   = true;

        $orderQuery = ''.
                            'SELECT Fecha_creacion   '.
                            'FROM ordenes            '.
                            'WHERE Id = '.$ordenId.' ';
                            
        $order     = DB::select($orderQuery);
        $orderDate = $order[0]->Fecha_creacion; 
        
        $orderDate = date_create_from_format('Y-m-d',$orderDate);
        $orderDate->setTimezone(new \DateTimeZone('America/Mexico_City'));
        
        
        if($currentMonthYear == $orderDate){
            if($currentDay < 6){
                $result = false;
            }
        }else if($orderDate > $currentMonthYear){
            $result = true;
        }
        
        return ['result'=>$result];
    }

    function getValidRecargos($alumno, $orden, $plantel){
        $monthDay = date_create_from_format('j',date('j'));
        $monthDay->setTimezone(new \DateTimeZone('America/Mexico_City'));
        $monthDay = $monthDay->format('j');

        $alumnoId  = $alumno['id'];
        $ordenId   = $orden['id'];
        $plantelId = $plantel['id'];

        $allRecargos = [];

        //Evaluacion para validar si es el Colegio
        if($plantelId != 2){
            return ['result'=>$allRecargos];
        }
        // Recargos
        if(!$this->isRecargoAlreadyApplied($alumnoId, $ordenId)){
            $allRecargos = $this->getRecargos($monthDay, $ordenId, $plantelId);
        }

        return ['result'=>$allRecargos];
    }
    
    function getAllRecargos($alumno,$mensualidad){
        $alumnoId = $alumno['id'];
        $ordenId  = $mensualidad['id'];
        $recargosQuery = ''.
                            'SELECT P.Cantidad_pago '.
                            'FROM pagos P                '.
                            'LEFT JOIN conceptos C ON C.Id = P.Descripcion '.
                            'WHERE P.Alumno_id = '.$alumnoId.' AND P.Orden_id = '.$ordenId.' AND C.Tipo = "recargos" ';
        

        $recargos        = DB::select($recargosQuery);
        $cantidadRecargo = 0;
        foreach ($recargos as $recargo) {
            $cantidadRecargo += $recargo->Cantidad_pago;
        }

        return ['recargo'=>$cantidadRecargo];
    }
    function getBecaAlumno($alumno,$orden){
        $ordenQuery = ''.
                        'SELECT GP.Id FROM ordenes O '.
                        'LEFT JOIN generacion_periodos GP ON GP.Generacion_id = O.Generacion_id AND GP.Periodo_numero = O.Periodo_numero '.
                        'where O.Id = '.$orden['id'];
        $ordenPeriodo = DB::select($ordenQuery);

        $alumnosQuery = ''.
                        'SELECT BA.Estatus,B.Id,B.Nombre,BA.Cantidad_beca,CONCAT(CP.Fecha_inicio," - ",CP.Fecha_finalizacion) AS Periodo '.
                        'FROM beca_alumnos BA                                             '.
                        'LEFT JOIN alumnos  A ON A.Id = BA.Alumno_id                      '.
                        'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id            '.
                        'LEFT JOIN generacion_periodos CP ON CP.Id = BA.Periodo_id         '.
                        'LEFT JOIN becas           B ON B.Id = BA.Beca_id                 '.
                        'WHERE A.Id = '.$alumno['id'].' and BA.Periodo_id = '.$ordenPeriodo[0]->Id;
        
        $alumnos = DB::select($alumnosQuery);
        return ['data'=>$alumnos];
    }
    function getBecasAlumno($alumno){
        $alumnosQuery = ''.
                        'SELECT BA.Estatus,B.Id,B.Nombre,BA.Cantidad_beca,CONCAT(CP.Fecha_inicio," - ",CP.Fecha_finalizacion) AS Periodo '.
                        'FROM beca_alumnos BA                                             '.
                        'LEFT JOIN alumnos  A ON A.Id = BA.Alumno_id                      '.
                        'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id            '.
                        'LEFT JOIN generacion_periodos CP ON CP.Id = BA.Periodo_id         '.
                        'LEFT JOIN becas           B ON B.Id = BA.Beca_id                 '.
                        'WHERE A.Id = '.$alumno['id'];
        
        $alumnos = DB::select($alumnosQuery);
        return ['data'=>$alumnos];
    }
    function getAlumnos($datos){
        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value <> 0){
                    switch ($key) {
                        case 'plantel':
                            $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                            break;
                        case 'nivel':
                            $queryWhere .= ' AND AR.Nivel_id = '.$value.' ';
                            break;
                        case 'licenciatura':
                            $queryWhere .= ' AND AR.Licenciatura_id = '.$value.' ';
                            break;
                        case 'sistema':
                            $queryWhere .= ' AND AR.Sistema_id = '.$value.' ';
                            break;
                        case 'grupo':
                            $queryWhere .= ' AND AR.Grupo_id = '.$value.' ';
                            break;
                        case 'generacion':
                            $queryWhere .= ' AND AR.Generacion_id = '.$value.' ';
                            break;
                        case 'estatusAlumno':
                            $queryWhere .= ' AND A.Estatus =  '.$value.' ';
                            break;
                    }
                }
            }
        }

        if($queryWhere == ''){
            return ['data'=>[]];
        }

        //if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
        //    $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
        //}

        // $alumnosQuery = 'SELECT A.Id,@total := @total + 1 AS provId,CONCAT(A.Nombre," ",A.Apellido_paterno," ",A.Apellido_materno) AS Nombre,A.Email,A.Telefono,A.Estatus,G.Nombre AS Grupo,Nombre_tutor,Telefono_tutor,'.
        //                 // '( SELECT O.Estatus FROM ordenes O LEFT JOIN conceptos C ON C.Id = O.Concepto_id WHERE O.Alumno_id = A.Id AND MONTH(O.Fecha_creacion) = "'.date("m").'" AND YEAR(O.Fecha_creacion) = "'.date("Y").'" AND C.Tipo = "colegiatura")  AS Estatus_pago '.
        //                 ' "1" AS Estatus_pago '.
        //                 'FROM alumnos A                                        '.
        //                 'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id '.
        //                 'LEFT JOIN grupos             G ON G.Id         = AR.Grupo_id '.
        //                 'LEFT JOIN generaciones      GR ON GR.Id        = AR.Generacion_id '.
                        
        //                 //'WHERE 1 = 1 AND GR.Fecha_finalizacion >=  "'.date("Y-m-d").'"  '.$queryWhere;
        //                 'WHERE 1 = 1 '.$queryWhere;


        $alumnosQuery = 'SELECT                                                                                                                                                                         '.
                        'A.Id,                                                                                                                                                                          '.
                        // '@total := @total + 1 AS provId,                                                                                                                                                '.
                        'CONCAT(A.Nombre, " ", A.Apellido_paterno, " ", A.Apellido_materno) AS Nombre,                                                                                                  '.
                        'A.Email,                                                                                                                                                                       '.
                        'A.Telefono,                                                                                                                                                                    '.
                        'A.Estatus,                                                                                                                                                                     '.
                        'G.Nombre AS Grupo,                                                                                                                                                             '.
                        'Nombre_tutor,                                                                                                                                                                  '.
                        'Telefono_tutor,                                                                                                                                                                '.
                        'MAX(CASE WHEN MONTH(O.Fecha_creacion) = MONTH(CURRENT_DATE()) AND YEAR(O.Fecha_creacion) = YEAR(CURRENT_DATE()) AND C.Tipo = "colegiatura" THEN O.Estatus END) AS Estatus_pago '.
                        'FROM                                                                                                                                                                           '.
                        '    alumnos A                                                                                                                                                                  '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    alumno_relaciones AR ON AR.Alumno_id = A.Id                                                                                                                                '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    grupos G ON G.Id = AR.Grupo_id                                                                                                                                             '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    generaciones GR ON GR.Id = AR.Generacion_id                                                                                                                                '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    ordenes O ON O.Alumno_id = A.Id                                                                                                                                            '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    conceptos C ON C.Id = O.Concepto_id                                                                                                                                        '.
                        'WHERE 1 = 1 '.$queryWhere.'                                                                                                                                                    '.
                        'GROUP BY                                                                                                                                                                       '.
                        '    A.Id,                                                                                                                                                                      '.
                        '    A.Nombre,                                                                                                                                                                  '.
                        '    A.Apellido_paterno,                                                                                                                                                        '.
                        '    A.Apellido_materno,                                                                                                                                                        '.
                        '    A.Email,                                                                                                                                                                   '.
                        '    A.Telefono,                                                                                                                                                                '.
                        '    A.Estatus,                                                                                                                                                                 '.
                        '    G.Nombre,                                                                                                                                                                  '.
                        '    Nombre_tutor,                                                                                                                                                              '.
                        '    Telefono_tutor                                                                                                                                                             ';

        // DB::statement( DB::raw( 'SET @total := 0'));
        //print_r($alumnosQuery);
        $alumnos = DB::select($alumnosQuery);
        
        return ['data'=>$alumnos];
    }
    function getBajaAlumnos($datos){
        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value <> 0){
                    switch ($key) {
                        case 'plantel':
                            $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                            break;
                        case 'nivel':
                            $queryWhere .= ' AND AR.Nivel_id = '.$value.' ';
                            break;
                        case 'licenciatura':
                            $queryWhere .= ' AND AR.Licenciatura_id = '.$value.' ';
                            break;
                        case 'sistema':
                            $queryWhere .= ' AND AR.Sistema_id = '.$value.' ';
                            break;
                        case 'grupo':
                            $queryWhere .= ' AND AR.Grupo_id = '.$value.' ';
                            break;
                        case 'generacion':
                            $queryWhere .= ' AND AR.Generacion_id = '.$value.' ';
                            break;
                    }
                }
            }
        }

        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
        }

        $alumnosQuery = 'SELECT A.Id,@total := @total + 1 AS provId,A.Fecha_baja,CONCAT(A.Nombre," ",A.Apellido_paterno," ",A.Apellido_materno) AS Nombre,A.Email,A.Telefono,A.Estatus,Nombre_tutor,Telefono_tutor,'.
                        'MAX(CASE WHEN MONTH(O.Fecha_creacion) = MONTH(CURRENT_DATE()) AND YEAR(O.Fecha_creacion) = YEAR(CURRENT_DATE()) AND C.Tipo = "colegiatura" THEN O.Estatus END) AS Estatus_pago,'.
                        // '(SELECT COUNT(O.Id) FROM ordenes O WHERE O.Estatus <> 2 AND O.Alumno_id = A.Id AND O.Fecha_creacion <= A.Fecha_baja) AS Adeudo '.
                        'COUNT(CASE WHEN O.Estatus <> 2 AND O.Fecha_creacion <= A.Fecha_baja THEN O.Id END) AS Adeudo '.
                        'FROM alumnos A                                        '.
                        'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id '.
                        'LEFT JOIN ordenes O ON O.Alumno_id = A.Id             '.
                        'LEFT JOIN conceptos C ON C.Id = O.Concepto_id         '.
                        'WHERE 1 = 1 AND A.Estatus = 0 '.$queryWhere.'         '.
                        'GROUP BY                                                                                                                                                                       '.
                        '    A.Id,                                                                                                                                                                      '.
                        '    A.Nombre,                                                                                                                                                                  '.
                        '    A.Apellido_paterno,                                                                                                                                                        '.
                        '    A.Apellido_materno,                                                                                                                                                        '.
                        '    A.Email,                                                                                                                                                                   '.
                        '    A.Telefono,                                                                                                                                                                '.
                        '    A.Estatus,                                                                                                                                                                 '.
                        '    Nombre_tutor,                                                                                                                                                              '.
                        '    Telefono_tutor                                                                                                                                                             ';



        DB::statement( DB::raw( 'SET @total := 0'));
        $alumnos = DB::select($alumnosQuery);
        
        return ['data'=>$alumnos];
    }
    function createAlumno($alumno,$numeroAlumnos){
        $result = '';
        $OrdenController = new OrdenController;

        
        for ($i=0; $i < $numeroAlumnos; $i++) { 
            try{
                $id = DB::table('alumnos')->insertGetId(
                        [
                            'Nombre'            => @$alumno['nombre'][$i],
                            'Apellido_materno'  => @$alumno['apellidoMaterno'][$i],
                            'Apellido_paterno'  => @$alumno['apellidoPaterno'][$i],
                            'Email'             => @$alumno['email'][$i],
                            'Telefono'          => @$alumno['telefono'][$i],
                            'Nombre_tutor'      => @$alumno['nombreTutor'][$i],
                            'Telefono_tutor'    => @$alumno['telefonoTutor'][$i],
                            'Estatus'           => 1,
                            'Fecha_inicio'      => $alumno['fechaInicio'].'-01'
                        ]
                    );
                DB::table('alumno_relaciones')->insert(
                        [
                            'Alumno_id'         => $id,
                            'Plantel_id'        => $alumno['plantel'],
                            'Nivel_id'          => $alumno['nivel'],
                            'Licenciatura_id'   => @$alumno['licenciatura'],
                            'Sistema_id'        => $alumno['sistema'],
                            'Grupo_id'          => @$alumno['grupo'],
                            'Generacion_id'     => $alumno['generacion'],
                            'Concepto_id'       => $alumno['concepto'],
                            'Concepto_titulacion_id' => @$alumno['titulacion'],
                            'Concepto_inscripcion_id'=> $alumno['inscripcion'],
                            'Concepto_cuota_id'  => @$alumno['cuota']
                        ]
                    );
                $OrdenController->createOrdenAlumno($id,$alumno['fechaInicio'].'-01');

                $result = ['success','¡Alumnos creados exitosamente!'];
            }catch(\Illuminate\Database\QueryException $e){
                print_r($e->errorInfo);
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    $result = ['warning','¡El alumno ya ha sido previamente agregado!'];
                }else{
                    $result = ['error','¡Error al guardar Alumnos! '];
                }
            }
        }
        return $result;
    }
    function updateDPAlumno($datos,$actualizarColegiatura){
        $result = '';
        $OrdenController = new OrdenController;

        try{
            alumnos::where('Id', $datos['id'])->update(['Nombre' => $datos['nombre'],
                                                                  'Apellido_materno' => $datos['apellidoMaterno'],
                                                                  'Apellido_paterno' => $datos['apellidoPaterno'],
                                                                  'Email'            => $datos['email'],
                                                                  'Telefono'         => $datos['telefono'],
                                                                  'Nombre_tutor'     => $datos['nombreTutor'],
                                                                  'Telefono_tutor'   => $datos['telefonoTutor'],
                                                                  'Fecha_inicio'     => $datos['fechaInicio'].'-01'
                                                                 ]);
            alumno_relaciones::where('alumno_Id', $datos['id'])->update(['Plantel_id' => $datos['plantel'],
                                                                  'Nivel_id'          => $datos['nivel'],
                                                                  'Licenciatura_id'   => $datos['licenciatura'],
                                                                  'Sistema_id'        => $datos['sistema'],
                                                                  'Grupo_id'          => $datos['grupo'],
                                                                  'Generacion_id'     => $datos['generacion'],
                                                                  'Concepto_id'       => $datos['concepto'],
                                                                  'Concepto_titulacion_id' => $datos['conceptoTitulacion'],
                                                                  'Concepto_inscripcion_id'=> $datos['conceptoInscripcion'],
                                                                  'Concepto_cuota_id'=> $datos['conceptoCuota']
                                                                 ]);

            if($actualizarColegiatura == 'true'){
                $OrdenController->removeColegiaturasPeriodoActual($datos['id']);
                $OrdenController->createOrdenAlumno($datos['id'],date('Y-m-d'));
            }
            $result = ['success','¡Alumno editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar alumno!'];
        }
        return $result;
    }
    function updateGrupoAlumnos($datos,$newGrupo){
        $result = '';


        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value <> 0){
                    switch ($key) {
                        case 'plantel':
                            $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                            break;
                        case 'nivel':
                            $queryWhere .= ' AND AR.Nivel_id = '.$value.' ';
                            break;
                        case 'licenciatura':
                            $queryWhere .= ' AND AR.Licenciatura_id = '.$value.' ';
                            break;
                        case 'sistema':
                            $queryWhere .= ' AND AR.Sistema_id = '.$value.' ';
                            break;
                        case 'grupo':
                            $queryWhere .= ' AND AR.Grupo_id = '.$value.' ';
                            break;
                        case 'generacion':
                            $queryWhere .= ' AND AR.Generacion_id = '.$value.' ';
                            break;
                        case 'estatusAlumno':
                            $queryWhere .= ' AND A.Estatus =  '.$value.' ';
                            break;
                    }
                }
            }
        }
        // $alumnosQuery = 'SELECT A.Id,@total := @total + 1 AS provId,CONCAT(A.Nombre," ",A.Apellido_paterno," ",A.Apellido_materno) AS Nombre,A.Email,A.Telefono,A.Estatus,Nombre_tutor,Telefono_tutor,'.
        //                 '( SELECT O.Estatus FROM ordenes O LEFT JOIN conceptos C ON C.Id = O.Concepto_id WHERE O.Alumno_id = A.Id AND MONTH(O.Fecha_creacion) = "'.date("m").'" AND YEAR(O.Fecha_creacion) = "'.date("Y").'" AND C.Tipo = "colegiatura")  AS Estatus_pago '.
        //                 'FROM alumnos A                                        '.
        //                 'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id '.
        //                 'LEFT JOIN generaciones      GR ON GR.Id       = AR.Generacion_id '.
        
        //                 'WHERE 1 = 1 '.$queryWhere;

        $alumnosQuery = 'SELECT                                                                                                                                                                         '.
                        'A.Id,                                                                                                                                                                          '.
                        // '@total := @total + 1 AS provId,                                                                                                                                                '.
                        'CONCAT(A.Nombre, " ", A.Apellido_paterno, " ", A.Apellido_materno) AS Nombre,                                                                                                  '.
                        'A.Email,                                                                                                                                                                       '.
                        'A.Telefono,                                                                                                                                                                    '.
                        'A.Estatus,                                                                                                                                                                     '.
                        'G.Nombre AS Grupo,                                                                                                                                                             '.
                        'Nombre_tutor,                                                                                                                                                                  '.
                        'Telefono_tutor,                                                                                                                                                                '.
                        'MAX(CASE WHEN MONTH(O.Fecha_creacion) = MONTH(CURRENT_DATE()) AND YEAR(O.Fecha_creacion) = YEAR(CURRENT_DATE()) AND C.Tipo = "colegiatura" THEN O.Estatus END) AS Estatus_pago '.
                        'FROM                                                                                                                                                                           '.
                        '    alumnos A                                                                                                                                                                  '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    alumno_relaciones AR ON AR.Alumno_id = A.Id                                                                                                                                '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    grupos G ON G.Id = AR.Grupo_id                                                                                                                                             '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    generaciones GR ON GR.Id = AR.Generacion_id                                                                                                                                '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    ordenes O ON O.Alumno_id = A.Id                                                                                                                                            '.
                        'LEFT JOIN                                                                                                                                                                      '.
                        '    conceptos C ON C.Id = O.Concepto_id                                                                                                                                        '.
                        'WHERE 1 = 1 '.$queryWhere.'                                                                                                                                                    '.
                        'GROUP BY                                                                                                                                                                       '.
                        '    A.Id,                                                                                                                                                                      '.
                        '    A.Nombre,                                                                                                                                                                  '.
                        '    A.Apellido_paterno,                                                                                                                                                        '.
                        '    A.Apellido_materno,                                                                                                                                                        '.
                        '    A.Email,                                                                                                                                                                   '.
                        '    A.Telefono,                                                                                                                                                                '.
                        '    A.Estatus,                                                                                                                                                                 '.
                        '    G.Nombre,                                                                                                                                                                  '.
                        '    Nombre_tutor,                                                                                                                                                              '.
                        '    Telefono_tutor                                                                                                                                                             ';

        // DB::statement( DB::raw( 'SET @total := 0'));
        $alumnos = DB::select($alumnosQuery);



        try{
            foreach($alumnos as $alumno){
                alumno_relaciones::where('alumno_Id', $alumno->Id)->update(['Grupo_id' => $newGrupo]);   
            }                                                            
            $result = ['success','Grupo actualizado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar grupo!'];
        }
        return $result;
    }
    function verifyFinalizados(){
        /*
            UPDATE alumnos A
                       
            LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id                   
            LEFT JOIN generaciones G ON G.Id = AR.Generacion_id           

            SET A.Estatus = 1 WHERE G.Fecha_finalizacion < now() AND G.Fecha_finalizacion = "2021-07-01" AND A.Estatus = 3
        */


                    // 'SELECT A.Id, (                                                                 '.
                    // '   SELECT COUNT(O.Id) FROM ordenes O WHERE Alumno_id = A.Id and O.Estatus <> 2 '.
                    // '    ) as Pendientes_pago                                                       '.
                    // 'FROM alumnos A                                                                 '.
                    // 'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id                          '.
                    // 'LEFT JOIN generaciones G ON G.Id = AR.Generacion_id                            '.
                    // 'WHERE G.Fecha_finalizacion < now() AND A.Estatus <> 3                          ';

        $alumnosQuery = ''.
                    'SELECT                                          '.
                    '    A.Id,                                       '.
                    '    COUNT(O.Id) AS Pendientes_pago              '.
                    'FROM                                            '.
                    '    alumnos A                                   '.
                    'LEFT JOIN                                       '.
                    '    alumno_relaciones AR ON AR.Alumno_id = A.Id '.
                    'LEFT JOIN                                       '.
                    '    generaciones G ON G.Id = AR.Generacion_id   '.
                    'LEFT JOIN                                       '.
                    '    ordenes O ON O.Alumno_id = A.Id             '.
                    'WHERE                                           '.
                    '    G.Fecha_finalizacion < NOW()                '.
                    '    AND A.Estatus <> 3                          '.
                    '    AND O.Estatus <> 2                          '.
                    'GROUP BY                                        '.
                    '    A.Id                                        ';
                        
        
        $alumnos = DB::select($alumnosQuery);

        foreach($alumnos as $alumno){
            if($alumno->Pendientes_pago === 0){
                alumnos::where('Id', $alumno->Id)->update(['Estatus' => 3]);
            }
        }
    }
}