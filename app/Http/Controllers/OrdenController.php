<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ordenes;
use App\Models\Alumnos;
use App\Http\Controllers\OrdenController;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;


class OrdenController extends Controller
{
    //Runs automatically by a cron to verify and create
    function createOrdenes(){
        //$now           = $this->getToday();
        $now           = date('Y-m-d', strtotime("+ 5 months"));
        $periodosQuery = ''.
                         'SELECT CP.Fecha_inicio,CP.Fecha_finalizacion,C.Id,CP.Periodo_numero,CP.Periodo_numero '.
                         'FROM generacion_periodos CP '.
                         'LEFT JOIN generaciones     C ON C.Id = CP.Generacion_id '.
                         //'WHERE C.Estatus = 1 AND C.Fecha_inicio <= "2020-07-01" AND C.Fecha_finalizacion > "2020-07-01" AND CP.Fecha_inicio <= "2020-07-01" AND CP.Fecha_finalizacion > "2020-07-01" ';
                       //INICIO DESDE ENTRADA 'WHERE C.Estatus = 1 AND C.Fecha_inicio <= "'.$now.'" AND C.Fecha_finalizacion > "'.$now.'"  AND CP.Fecha_inicio <= "'.$now.'" AND CP.Fecha_finalizacion > "'.$now.'" ';
                         //'WHERE C.Estatus = 1 AND C.Fecha_inicio <="'.$now.'"   AND CP.Fecha_inicio <= "'.$now.'"  AND C.Id = 23 ORDER BY Periodo_numero ASC';
                         'WHERE C.Estatus = 1 AND C.Fecha_inicio <="'.$now.'"   AND CP.Fecha_inicio <= "'.$now.'" ORDER BY Periodo_numero ASC ';
                         
        $periodos = DB::select($periodosQuery);

        //echo('<pre> periodos-');
        //print_r($periodos);
        /*
        INICIO DESDE ENTRADA
        foreach($periodos as $periodo){

            $alumnosQuery = ''.
                        'SELECT AR.Alumno_id,AR.Concepto_id,CO.Precio,C.Id AS GeneracionId       '.
                        'FROM      alumno_relaciones    AR                                  '.
                        'INNER JOIN generaciones                C ON C.Id = AR.Generacion_id           '.
                        'INNER JOIN conceptos            CO ON CO.Id       = AR.Concepto_id '.
                        'WHERE C.Id = "'.$periodo->Id.'" ';
   
            $alumnos = DB::select($alumnosQuery);
            foreach($alumnos as $alumno){
                $fechaInicioDate       = date_create($now);
                $fechaFinalizacionDate = date_create($periodo->Fecha_finalizacion);
                $interval              = date_diff($fechaInicioDate, $fechaFinalizacionDate);
                $months                = $interval->format('%m');
                $months                = ($months == 0 ? 1 : $months);

                for($i = 0;$i < $months; $i++){
            
                    $newDate = date('Y-m-d', strtotime("+".$i." months", strtotime($now)));
                    $newDate = date_create($newDate);
                    setlocale(LC_ALL, 'es_ES');
                    $descripcion = strftime("Colegiatura - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));
                    print_r($descripcion);
                    echo("<br>");
                    //if($this->creationOrdenValidation($descripcion,$alumno->Alumno_id)){
                    //    $this->createOrden($alumno->Alumno_id,$alumno->Concepto_id,$descripcion,$newDate,$alumno->Precio,$alumno->GeneracionId,$periodo->Periodo_numero);
                    //}
                }
            }
        }
        */



        
        foreach($periodos as $periodo){

            $alumnosQuery = ''.
                        'SELECT C.Periodo AS TipoPeriodo,AR.Alumno_id,AR.Concepto_id,AR.Concepto_cuota_id,CO.Precio,C.Id AS GeneracionId   '.
                        'FROM      alumno_relaciones    AR                                   '.
                        'INNER JOIN generaciones                C ON C.Id = AR.Generacion_id '.
                        'INNER JOIN conceptos            CO ON CO.Id      = AR.Concepto_id   '.
                        'WHERE C.Id = "'.$periodo->Id.'" ';
                        //'WHERE  AR.Alumno_id = 61 AND C.Id = "'.$periodo->Id.'" ';
   
            $alumnos = DB::select($alumnosQuery);
            foreach($alumnos as $alumno){
                $fechaInicio           = $periodo->Fecha_inicio;
                $maxFechaOrden         = $this->getMaxFechaOrden($alumno->Alumno_id);
                //$fechaInicio           = ($maxFechaOrden != "") ? $maxFechaOrden : $fechaInicio;
                
                $maxFechaOrden         = new DateTime($maxFechaOrden);
                $fechaInicioDate       = new DateTime($fechaInicio);
                $fechaFinalizacionDate = new DateTime($periodo->Fecha_finalizacion);

                //only attempts creating new order
                if($fechaFinalizacionDate > $maxFechaOrden){

                    //print_r($periodo);
                    //echo("<br>");
                    //echo($maxFechaOrden);
                    //echo("<br>");
                    //echo($fechaInicio);
                    //echo("<br>");
                    //echo("<br>");
                    
                    $interval              = $fechaInicioDate->diff($fechaFinalizacionDate);
                    $months                = $interval->format('%y') * 12 + $interval->format('%m');
                    $months                = ($months == 0 ? 1 : $months);

                    $this->createInscripcion((object)
                    [
                        'Fecha_inicio'   => $fechaInicio,
                        'Alumno_id'      => $alumno->Alumno_id,
                        'Concepto_id'    => $alumno->Concepto_id,
                        'Periodo_numero' => $periodo->Periodo_numero,
                        'GeneracionId'   => $alumno->GeneracionId
                    ]);

                    if($alumno->Concepto_cuota_id > 0){
                        $this->createCuota((object)
                        [
                            'Fecha_inicio'   => $fechaInicio,
                            'Alumno_id'      => $alumno->Alumno_id,
                            'Concepto_id'    => $alumno->Concepto_id,
                            'Periodo_numero' => $periodo->Periodo_numero,
                            'GeneracionId'   => $alumno->GeneracionId,
                            'Concepto_cuota_id' => $alumno->Concepto_cuota_id
                        ]);
                    }
                    
                    for($i = 0;$i < $months; $i++){
                        $newDate = date('Y-m-d', strtotime("+".$i." months", strtotime($fechaInicio)));
                        $newDate = date_create($newDate);
                        setlocale(LC_ALL, 'es_ES');

                        //Special validation for 11 months model
                        $isOrderValid = true;
                        if(($alumno->TipoPeriodo == 7) && ($newDate->format("m") == "08" || $newDate->format("m") == "07")){
                            $isOrderValid = false;
                        }
                        
                        if($isOrderValid){
                            $descripcion = strftime("Colegiatura - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));
                            
                            if($this->creationOrdenValidation($descripcion,$alumno->Alumno_id)){
                                $this->createOrden($alumno->Alumno_id,$alumno->Concepto_id,$descripcion,$newDate,$alumno->Precio,$alumno->GeneracionId,$periodo->Periodo_numero);
                            }
                        }
                    }
                }
            }
        }
    }
    //Runs at student creation time
    function createOrdenAlumno($alummoId,$fechaInicio){
        $now           = date('Y-m-d', strtotime($fechaInicio));
        $fechaInicio  = new DateTime($fechaInicio);

        $periodosQuery = ''.
                 'SELECT G.Id,G.Periodo AS TipoPeriodo,CP.Periodo_numero,AR.Concepto_cuota_id,AR.Alumno_id,AR.Concepto_id,CP.Fecha_inicio,CP.Fecha_finalizacion,CO.Precio,G.Id AS GeneracionId '.
                 'FROM alumno_relaciones   AR                                 '.
                 'LEFT JOIN conceptos      CO ON CO.Id       = AR.Concepto_id '.
                 'LEFT JOIN generaciones          G ON G.Id        = AR.Generacion_id    '.
                 'LEFT JOIN generacion_periodos CP ON CP.Generacion_id = G.Id           '.
                 'WHERE G.Estatus = 1 AND G.Fecha_inicio <="'.$now.'" AND CP.Fecha_inicio <= "'.$now.'" AND AR.Alumno_id    = '.$alummoId.' ORDER BY Periodo_numero ASC '; 

        $periodos = DB::select($periodosQuery);
        echo($now);
        dd($alummoId);

        foreach($periodos as $periodo){
            $fechaInicioDate       = new DateTime($periodo->Fecha_inicio);
            $fechaFinalizacionDate = new DateTime($periodo->Fecha_finalizacion);
            $interval              = $fechaInicioDate->diff($fechaFinalizacionDate);
            $months                = $interval->format('%y') * 12 + $interval->format('%m');
            $months                = ($months == 0 ? 1 : $months);

            $isLastPeriodo         = (($periodo->Fecha_inicio < $now) && ($periodo->Fecha_inicio == $periodos[count($periodos)-1]->Fecha_inicio)) ? true : false;
            $this->createInscripcion($periodo,$fechaInicioDate,$isLastPeriodo);

            if($periodo->Concepto_cuota_id > 0){
                $this->createCuota($periodo,$fechaInicioDate,$isLastPeriodo);
            }

            for($i = 0;$i < $months; $i++){
                $newDate = date('Y-m-d', strtotime("+".$i." months", strtotime($periodo->Fecha_inicio)));
                $newDate = date_create($newDate);
                setlocale(LC_ALL, 'es_ES');

                //Special validation for 11 months model
                $isOrderValid = true;
                if(($periodo->TipoPeriodo == 7) && ($newDate->format("m") == "08" || $newDate->format("m") == "07")){
                    $isOrderValid = false;
                }
                
                if($isOrderValid){
                    $descripcion = strftime("Colegiatura - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));

                    $colegiatura = $periodo->Precio;
                    $estatus     = 0;
                    if($fechaInicio > $newDate){
                        $estatus     = 2;
                        $colegiatura = 0;
                    }
                    
                    if($this->creationOrdenValidation($descripcion,$periodo->Alumno_id)){
                        $this->createOrden($periodo->Alumno_id,$periodo->Concepto_id,$descripcion,$newDate,$colegiatura,$periodo->GeneracionId,$periodo->Periodo_numero,$estatus);
                    }
                }
            }
        }
    }

    //Runs for a certain student when it makes an action and create orders for the upcoming period 
    function createOrdenPeriodo($alummoId){
        $now = date('Y-m-d');

        $getNextPeriodoQuery = ''.
                'SELECT GP.Id,G.Periodo AS TipoPeriodo,GP.Generacion_id AS GeneracionId,GP.Periodo_numero,GP.Fecha_inicio,GP.Fecha_finalizacion,AR.Alumno_id,AR.Concepto_id,AR.Concepto_cuota_id,CO.Precio '. 
                'FROM generacion_periodos GP                                '.
                'LEFT JOIN generaciones        G ON G.Id = GP.Generacion_id '.
                'LEFT JOIN alumno_relaciones  AR ON AR.Generacion_id = G.Id '.
                'INNER JOIN conceptos         CO ON CO.Id = AR.Concepto_id  '.
                'WHERE  GP.Fecha_inicio > "'.$now.'" AND AR.Alumno_id = '.$alummoId.' ORDER BY Fecha_inicio ASC'; 

        $nextPeriodo = DB::select($getNextPeriodoQuery);

        try{
            if(count($nextPeriodo) > 0){
                $nextPeriodo           = $nextPeriodo[0];

                $fechaInicioDate       = new DateTime($nextPeriodo->Fecha_inicio);
                $fechaFinalizacionDate = new DateTime($nextPeriodo->Fecha_finalizacion);
                $interval              = $fechaInicioDate->diff($fechaFinalizacionDate);
                $months                = $interval->format('%y') * 12 + $interval->format('%m');
                $months                = ($months == 0 ? 1 : $months);

                $this->createInscripcion((object)
                            [
                                'Fecha_inicio'      => $nextPeriodo->Fecha_inicio,
                                'Alumno_id'         => $nextPeriodo->Alumno_id,
                                'Concepto_id'       => $nextPeriodo->Concepto_id,
                                'Periodo_numero'    => $nextPeriodo->Periodo_numero,
                                'GeneracionId'      => $nextPeriodo->GeneracionId,
                                'Concepto_cuota_id' => $nextPeriodo->Concepto_cuota_id
                            ]);

                if($nextPeriodo->Concepto_cuota_id > 0){
                    $this->createCuota((object)
                            [
                                'Fecha_inicio'      => $nextPeriodo->Fecha_inicio,
                                'Alumno_id'         => $nextPeriodo->Alumno_id,
                                'Concepto_id'       => $nextPeriodo->Concepto_id,
                                'Periodo_numero'    => $nextPeriodo->Periodo_numero,
                                'GeneracionId'      => $nextPeriodo->GeneracionId,
                                'Concepto_cuota_id' => $nextPeriodo->Concepto_cuota_id
                            ]);
                }

                for($i = 0;$i < $months; $i++){
                    $newDate = date('Y-m-d', strtotime("+".$i." months", strtotime($nextPeriodo->Fecha_inicio)));
                    $newDate = date_create($newDate);
                    setlocale(LC_ALL, 'es_ES');
                    //Special validation for 11 months model
                    $isOrderValid = true;
                    if(($nextPeriodo->TipoPeriodo == 7) && ($newDate->format("m") == "08" || $newDate->format("m") == "07")){
                        $isOrderValid = false;
                    }
                        
                    if($isOrderValid){
                        $descripcion = strftime("Colegiatura - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));
                        $colegiatura = $nextPeriodo->Precio;
                        $estatus     = 0;
                        
                        if($this->creationOrdenValidation($descripcion,$nextPeriodo->Alumno_id)){
                            $this->createOrden($nextPeriodo->Alumno_id,$nextPeriodo->Concepto_id,$descripcion,$newDate,$colegiatura,$nextPeriodo->GeneracionId,$nextPeriodo->Periodo_numero,$estatus);
                        }
                    }
                }
            }
            $result = json_encode(['success','¡Mensualidades creadas exitosamente!']);
        }catch(\Illuminate\Database\QueryException $e){
            $result = json_encode(['error','¡Error al crear mensualidaded! ']);
        }
        return $result;
    }
    function getMaxFechaOrden($alumnoId){
        $orders = DB::select('SELECT MAX(Fecha_creacion) AS MaxFechaOrden FROM ordenes WHERE Alumno_id = '.$alumnoId);

        $result = $orders[0]->MaxFechaOrden;

        return $result;
    }

    function createInscripcion($periodo,$fechaInicio = "now",$isLastPeriodo = false){
        //$newDate = date('Y-m-d', strtotime($periodo->Fecha_inicio));
        $newDate = date('Y-m-d', strtotime($periodo->Fecha_inicio));
        $newDate = date_create($newDate);
        setlocale(LC_ALL, 'es_ES');
        $descripcion = strftime("Inscripcion - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));

        if($this->creationOrdenValidation($descripcion,$periodo->Alumno_id)){
            $inscripcionQuery = 
                'SELECT C.Precio,AR.Concepto_inscripcion_id                         '.
                'FROM      alumno_relaciones AR                                     '.
                'LEFT JOIN conceptos          C ON C.id= AR.Concepto_inscripcion_id '.
                'WHERE AR.Alumno_id = '.$periodo->Alumno_id;
            $inscripcion = DB::select($inscripcionQuery);

            if($inscripcion[0]->Precio == ''){
                return false;
            }

            $colegiatura = $inscripcion[0]->Precio;
            $estatus     = 0;
            
            //validation to avoid creating last cuota before user startdate, instead of that, create the last cuota in fecha inicio.
            if($isLastPeriodo){
                if(count($inscripcion) > 0){
                    $descripcion = strftime("Inscripcion - %B %Y",mktime(0,0,0,$fechaInicio->format("m"),$fechaInicio->format("d"),$fechaInicio->format("y")));
                    $this->createOrden($periodo->Alumno_id,$inscripcion[0]->Concepto_inscripcion_id,$descripcion,$fechaInicio,$colegiatura,$periodo->GeneracionId,$periodo->Periodo_numero,$estatus);
                }
            }else{
                if(($fechaInicio != "now") && ($fechaInicio > $newDate)){
                    $estatus     = 2;
                    $colegiatura = 0;
                }
                
                if(count($inscripcion) > 0){
                    $this->createOrden($periodo->Alumno_id,$inscripcion[0]->Concepto_inscripcion_id,$descripcion,$newDate,$colegiatura,$periodo->GeneracionId,$periodo->Periodo_numero,$estatus);
                } 
            }
        }      
    }

    function createCuota($periodo,$fechaInicio = "now",$isLastPeriodo = false){
        //$newDate = date('Y-m-d', strtotime($periodo->Fecha_inicio));
        $newDate = date('Y-m-d', strtotime($periodo->Fecha_inicio));
        $newDate = date_create($newDate);
        setlocale(LC_ALL, 'es_ES');

        $conceptoQuery = 'SELECT C.Nombre FROM conceptos C WHERE C.Id = '.$periodo->Concepto_cuota_id;
        $concepto      = DB::select($conceptoQuery);

        $descripcion = strftime($concepto[0]->Nombre." - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));

        if($this->creationOrdenValidation($descripcion,$periodo->Alumno_id)){
            $inscripcionQuery = 
                'SELECT C.Precio,AR.Concepto_cuota_id                         '.
                'FROM      alumno_relaciones AR                               '.
                'LEFT JOIN conceptos          C ON C.id= AR.Concepto_cuota_id '.
                'WHERE AR.Alumno_id = '.$periodo->Alumno_id;
            $cuota = DB::select($inscripcionQuery);

            if($cuota[0]->Precio == ''){
                return false;
            }

            $colegiatura = $cuota[0]->Precio;
            $estatus     = 0;

            //validation to avoid creating last cuota, instead of that, create the last cuota in fecha inicio.
            if($isLastPeriodo){
                if(count($cuota) > 0){
                    $descripcion = strftime($concepto[0]->Nombre." - %B %Y",mktime(0,0,0,$fechaInicio->format("m"),$fechaInicio->format("d"),$fechaInicio->format("y")));

                    $this->createOrden($periodo->Alumno_id,$cuota[0]->Concepto_cuota_id,$descripcion,$fechaInicio,$colegiatura,$periodo->GeneracionId,$periodo->Periodo_numero,$estatus);
                }
            }else{
                if(($fechaInicio != "now") && ($fechaInicio > $newDate)){
                    $estatus     = 2;
                    $colegiatura = 0;
                }
                
                if(count($cuota) > 0){
                    $this->createOrden($periodo->Alumno_id,$cuota[0]->Concepto_cuota_id,$descripcion,$newDate,$colegiatura,$periodo->GeneracionId,$periodo->Periodo_numero,$estatus);
                } 
            }
        }      
    }

    function createCustomOders($periodo,$fechaInicio = "now"){
        //$newDate = date('Y-m-d', strtotime($periodo->Fecha_inicio));
        $newDate = date('Y-m-d', strtotime($periodo->Fecha_inicio));
        $newDate = date_create($newDate);
        setlocale(LC_ALL, 'es_ES');
        $descripcion = strftime("Paquete Libros - %B %Y",mktime(0,0,0,$newDate->format("m"),$newDate->format("d"),$newDate->format("y")));

        if($this->creationOrdenValidation($descripcion,$periodo->Alumno_id)){
            $inscripcionQuery = 
                'SELECT C.Precio,AR.Concepto_inscripcion_id                         '.
                'FROM      alumno_relaciones AR                                     '.
                'LEFT JOIN conceptos          C ON C.id= AR.Concepto_inscripcion_id '.
                'WHERE AR.Alumno_id = '.$periodo->Alumno_id;
            $inscripcion = DB::select($inscripcionQuery);

            if($inscripcion[0]->Precio == ''){
                return false;
            }

            $colegiatura = $inscripcion[0]->Precio;
            $estatus     = 0;
            if(($fechaInicio != "now") && ($fechaInicio > $newDate)){
                $estatus     = 2;
                $colegiatura = 0;
            }
            
            if(count($inscripcion) > 0){
                $this->createOrden($periodo->Alumno_id,$inscripcion[0]->Concepto_inscripcion_id,$descripcion,$newDate,$colegiatura,$periodo->GeneracionId,$periodo->Periodo_numero,$estatus);
            } 
        }      
    }

    public function removeColegiaturasPeriodoActual($alumnoId){
        // DB::enableQueryLog();
        $result = ordenes::where('Alumno_id', $alumnoId)->where('Fecha_creacion','>=','NOW()')->where('Estatus', 0)->delete();
        // dd(DB::getQueryLog());
        return $result;
    }

    function creationOrdenValidation($descripcion,$alumnoId)
    {
        $result = false;
        $orders = DB::select('SELECT * FROM ordenes WHERE Descripcion = "'.$descripcion.'" AND  Alumno_id = '.$alumnoId);
     
        if(count($orders) > 0){
            $result = false;
        }else{
            $result = true;
        }

        return $result;
    }
    function getToday()
    {
        $now = date_create_from_format('Y-m-d',date('Y-m-d'));
        $now->setTimezone(new \DateTimeZone('America/Mexico_City'));
        $now = $now->format('Y-m').'-01';
        return $now;
    }
    function createOrden($alumnoId,$conceptoId,$descripcion,$fechaCreacion,$colegiatura,$generacionId,$periodoNumero,$estatus = 0)
    {
        $Id = DB::table('ordenes')->insertGetId(
            [
                'Alumno_id'     => $alumnoId,
                'Concepto_id'   => $conceptoId,
                'Descripcion'   => $descripcion,
                'Fecha_creacion'=> $fechaCreacion,
                'Precio'        => $colegiatura,
                'Generacion_id' => $generacionId,
                'Periodo_numero'=> $periodoNumero,
                'Estatus'       => $estatus
            ]
        );
        return $Id;
    }
    
    function getAlumnoAllColegiaturas($alumnoId){
        /*$colegiaturasQuery = ''.
                        'SELECT O.Id,O.Descripcion,O.Estatus,O.precio,O.Fecha_creacion      '.
                        'FROM ordenes O                                            '.
                        'LEFT JOIN concepto_relaciones CR ON CR.Concepto_id = O.Concepto_id    '.
                        'LEFT JOIN conceptos            C ON C.Id = CR.Concepto_id '.
                        'WHERE O.Alumno_id = :Id AND C.Tipo = "colegiatura" ORDER BY O.Id DESC    ';*/
        $colegiaturasQuery = ''.
                        'SELECT O.Id,O.Descripcion,O.Estatus,O.precio,O.Fecha_creacion,'.
                        '(SELECT sum(P.Cantidad_pago) FROM pagos P WHERE P.Orden_id = O.Id) AS Pagado '.
                        'FROM ordenes O                                            '.
                        'LEFT JOIN conceptos            C ON C.Id = O.Concepto_id '.
                        'WHERE O.Alumno_id = :Id AND C.Tipo IN ("colegiatura","inscripcion","cuota-personalizada-anual") ORDER BY     '.
                        '   O.Fecha_creacion DESC ';
                        //'   DATE(O.Fecha_creacion)=DATE(NOW()) DESC, '. 
                        //'   DATE(O.Fecha_creacion)<DATE(NOW()) DESC, '.
                        //'   DATE(O.Fecha_creacion)>DATE(NOW()) ASC  ';
        $colegiaturas  = DB::select($colegiaturasQuery, ['Id' => $alumnoId]);
        
        return ['data'=>$colegiaturas];
    }
    function getalumnoAllMesesAdeudo($alumnoId){
        $adeudosQuery = ''.
                        'SELECT O.Id,O.Descripcion,O.Estatus,O.precio,O.Fecha_creacion      '. 
                        'FROM ordenes O                                                     '.
                        'LEFT JOIN alumnos A ON A.Id = O.Alumno_id                            '.
                        'WHERE O.Estatus <> 2 AND O.Alumno_id = :Id AND O.Fecha_creacion <= A.Fecha_baja ';
        $adeudos  = DB::select($adeudosQuery, ['Id' => $alumnoId]);

        return ['data'=>$adeudos];
    }

    function getOrden($ordenId){
        try{
            $colegiaturas  = DB::select('SELECT * FROM ordenes WHERE Id = :Id', ['Id' => $ordenId])[0];
            $result = ['success',$colegiaturas];
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al cargar la colegiatura!'];
        }
        return $result;
    }

    function updateOrden($ordenId,$datos){
        $result = '';
        try{
            ordenes::where('Id', $ordenId)->update([
                'Precio' => $datos['precio'],
                'Estatus' => $datos['estatus']
            ]);                                       

            $result = ['success','¡Colegiatura actualizada correctamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error actualizar colegiatura!'];
        }
        return $result;
    }
}
/*
UPDATE ordenes O LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = O.Alumno_id SET O.Concepto_id = AR.Concepto_id WHERE AR.Plantel_id = 3 AND O.`Descripcion` LIKE "%Colegiatura%" AND O.`Concepto_id` <> AR.Concepto_id

SELECT O.Id,AR.Alumno_id,O.`Concepto_id`,O.Descripcion,AR.Concepto_id,AR.Plantel_id  
FROM alumno_relaciones AR 
LEFT JOIN ordenes O ON AR.Alumno_id = O.Alumno_id 
WHERE O.`Descripcion` LIKE "%Colegiatura%"  AND O.`Concepto_id` <> AR.Concepto_id  
ORDER BY `AR`.`Plantel_id`  DESC



UPDATE ordenes O 
LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = O.Alumno_id 
SET O.Concepto_id = AR.Concepto_inscripcion_id 
WHERE AR.Plantel_id = 3 AND O.`Descripcion` LIKE "%Inscripcion%" AND O.`Concepto_id` <> AR.Concepto_inscripcion_id

SELECT O.Id,AR.Alumno_id,O.`Concepto_id`,O.Descripcion,AR.Concepto_inscripcion_id,AR.Plantel_id  
FROM alumno_relaciones AR 
LEFT JOIN ordenes O ON AR.Alumno_id = O.Alumno_id 
WHERE O.`Descripcion` LIKE "%Inscripcion%"  AND O.`Concepto_id` <> AR.Concepto_inscripcion_id  
ORDER BY `AR`.`Plantel_id`  DESC
*/
/*


Colegiatura - abril 2019


DELETE FROM `ordenes` WHERE Descripcion = "Inscripcion - diciembre 2018" AND `Estatus` = 0

UPDATE ordenes SET Descripcion = "Inscripcion - diciembre 2018" WHERE Descripcion = "Inscripcion - 2018-12-01"

*/











