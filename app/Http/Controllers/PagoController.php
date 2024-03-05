<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ordenes;
use App\Models\Conceptos;
use App\Models\Pagos;
use App\Http\Controllers\OrdenController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use URL;

class PagoController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Pagos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit(); 
        }

        $plantel        = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas WHERE Plantel_id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');
        $niveles        = DB::select('SELECT * FROM niveles WHERE Plantel_id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');
        $generaciones   = DB::select('SELECT * FROM generaciones WHERE Plantel_id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');

        if(isset($_GET['Id'])){
            $plantel        = DB::select('SELECT * FROM planteles WHERE Id = '.@$_GET['Id'].' ');
            $planteles      = DB::select('SELECT * FROM planteles WHERE Id = '.$_GET['Id'].' ');
            $licenciaturas  = DB::select('SELECT * FROM licenciaturas WHERE Plantel_id = '.@$_GET['Id'].' ');
            $niveles        = DB::select('SELECT * FROM niveles WHERE Plantel_id = '.@$_GET['Id'].' ');
            $generaciones   = DB::select('SELECT * FROM generaciones WHERE Plantel_id = '.@$_GET['Id'].'  ');
        }

        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos ');

        
        
        return view('pagos.index',['plantel' => $plantel[0]->Nombre,'planteles' => $planteles,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'generaciones' => $generaciones]);
    } 
    function createCorteExcel($datos,$filename){
        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value <> 0){
                    switch ($key) {
                        // case 'plantel':
                        //     $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                        //     break;
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
                        case 'tipoPago':
                            if($value){
                                $queryWhere .= ' AND C.Tipo IN ("colegiatura","inscripcion","pagos","titulacion","cuota-personalizada-anual") ';
                            }
                            break;
                        case 'fuente':
                            if($value == 1){
                                $queryWhere .= ' AND P.Tipo_pago = "Cuenta bancaria" ';
                            }elseif($value == 2){
                                $queryWhere .= ' AND P.Tipo_pago = "Efectivo" ';
                            }
                            break;
                        case 'fecha':
                            if($value == 1){
                                $queryWhere .= ' AND MONTH(P.created_at) = MONTH(CURDATE()) AND YEAR(P.created_at) = YEAR(CURDATE()) AND DAY(P.created_at) = DAY(CURDATE()) ';
                            }elseif($value == 2){
                                $queryWhere .= ' AND MONTH(P.created_at) = MONTH(CURDATE()) AND YEAR(P.created_at) = YEAR(CURDATE())';
                            }else{
                                $startDate   = date_create_from_format('d/m/Y h:i:s',$datos->start_date." 00:00:00");
                                $startDate   = $startDate->format('Y-m-d H:i:s');
                                $endDate     = date_create_from_format('d/m/Y h:i:s',$datos->end_date." 00:00:00");
                                date_add($endDate, date_interval_create_from_date_string('1 days'));
                                $endDate     = $endDate->format('Y-m-d H:i:s');
                                $queryWhere .= ' AND P.created_at BETWEEN "'.$startDate.'" AND  "'.$endDate.'"';
                            }
                            break;
                    }
                }
            }
        }
        
        if($datos->plantel > 0){
            $queryWhere .= ' AND AR.Plantel_id = '.$datos->plantel.' ';   
        }else{
            if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
                $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
            }
        }

        if($datos->tipo_corte_usuario > 0){
            $queryWhere .= ' AND P.User_Id = '.$datos->tipo_corte_usuario.' ';   
        }
        
        $pagosQuery = ''.
                      'SELECT P.Id,A.Id AS Alumno_id,CONCAT(YEAR(G.Fecha_inicio),"-",YEAR(G.Fecha_finalizacion)) AS Generacion,CONCAT(A.Nombre," ",A.Apellido_materno," ",A.Apellido_paterno) AS Nombre,N.Nombre AS Nivel,C.Nombre AS Descripcion_pago,A.Email,O.Descripcion,P.Cantidad_pago,P.Tipo_pago,P.Notas,DATE_FORMAT(P.updated_at, "%d-%m-%Y") AS updated_at '.
                      'FROM pagos                   P                            '.
                      'LEFT JOIN conceptos          C ON C.Id = P.Descripcion    '.
                      'LEFT JOIN alumnos            A ON A.Id = P.Alumno_id      '.
                      'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id     '.
                      'LEFT JOIN niveles            N ON N.Id = AR.Nivel_id      '.
                      'LEFT JOIN generaciones       G ON G.Id = AR.Generacion_id '.
                      'LEFT JOIN ordenes            O ON O.Id = P.Orden_id       '.
                      'WHERE 1 = 1 '.$queryWhere;   
        $pagos  = DB::select($pagosQuery);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /*
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('SecEdu');
        $drawing->setDescription('SecEdu');
        $drawing->setPath('assets/images/seceduLogo.jpg'); // put your path and image here
        $drawing->setCoordinates('A1');
        $drawing->setWidth(300);
        $drawing->getShadow()->setVisible(false);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        */

        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $sheet->getStyle('A:I')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        /*
        $spreadsheet->getActiveSheet()->mergeCells('A3:AD3');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        $spreadsheet->getActiveSheet()->mergeCells('A4:AD4');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        $spreadsheet->getActiveSheet()->mergeCells('A5:AD5');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        $spreadsheet->getActiveSheet()->mergeCells('A6:AD6');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        $spreadsheet->getActiveSheet()->mergeCells('A7:AD7');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 


        $spreadsheet->getActiveSheet()->mergeCells('A10:A12');
        $spreadsheet->getActiveSheet()->mergeCells('B10:B12');
        $sheet->getStyle('B')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 


        $spreadsheet->getActiveSheet()->mergeCells('C10:T10');
        $sheet->getStyle('C:T')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        
        $spreadsheet->getActiveSheet()->mergeCells('C11:T11');
        $sheet->getStyle('C:T')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        
        $spreadsheet->getActiveSheet()->mergeCells('U10:U12');

        $spreadsheet->getActiveSheet()->getStyle('U10:U'.$spreadsheet->getActiveSheet()
            ->getHighestRow())
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true);
        
        $spreadsheet->getActiveSheet()->mergeCells('V10:AD10');
        $sheet->getStyle('V:AD')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        $spreadsheet->getActiveSheet()->mergeCells('V11:Y11');
        $sheet->getStyle('V:Y')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        $spreadsheet->getActiveSheet()->mergeCells('Z11:AB11');
        $sheet->getStyle('Z:AB')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 



        */


        $sheet->getRowDimension('1')->setRowHeight(30);

        $spreadsheet->getActiveSheet()->getStyle('A1:I1')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A1:I1')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A1:I1')
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A3:I3')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A3:I3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A3:I3')
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('B3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('C3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('E3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('F3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('H3')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A4:I4')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        
        
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(45);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);

        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);/*
        $spreadsheet->getActiveSheet()->getStyle('AD11')->getFont()->setBold(true);*/


        $sheet->setCellValue('A1', 'INGRESOS CUENTA BANCARIA');


        $sheet->setCellValue('A3', 'NÚM');
        $sheet->setCellValue('B3', 'FECHA');
        $sheet->setCellValue('C3', 'NOMBRE');
        $sheet->setCellValue('D3', 'NIVEL');
        $sheet->setCellValue('E3', 'GENERACIÓN');
        $sheet->setCellValue('F3', 'MONTO');
        $sheet->setCellValue('G3', 'CONCEPTO');
        $sheet->setCellValue('H3', 'TIPO DE PAGO');
        $sheet->setCellValue('I3', 'NOTAS');
        $spreadsheet->getActiveSheet()->getStyle('A5'.':I5')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $startCell = 5;
        $indice    = 1;
        $subtotalCBAncaria  = 0;
        foreach ($pagos as $pago) {
            if($pago->Tipo_pago == 'Cuenta bancaria'){
                $sheet->setCellValue('A'.$startCell,$indice);
                $sheet->setCellValue('B'.$startCell,$pago->updated_at);
                $sheet->setCellValue('C'.$startCell,$pago->Nombre);
                $sheet->setCellValue('D'.$startCell,$pago->Nivel);
                $sheet->setCellValue('E'.$startCell,$pago->Generacion);
                $sheet->setCellValue('F'.$startCell,"$".number_format($pago->Cantidad_pago, 2));
                $sheet->setCellValue('G'.$startCell,$pago->Descripcion_pago);
                $sheet->setCellValue('H'.$startCell,$pago->Tipo_pago);
                $sheet->setCellValue('I'.$startCell,$pago->Notas);
                $subtotalCBAncaria += $pago->Cantidad_pago;
                $spreadsheet->getActiveSheet()->getStyle('A'.$startCell)
                    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                $spreadsheet->getActiveSheet()->getStyle('I'.$startCell)
                    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                $indice++;
                $startCell++;
            }
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->mergeCells('D'.$startCell.':E'.$startCell);
        $sheet->getRowDimension($startCell)->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)->getFont()->setBold(true);

        $sheet->getStyle('D'.$startCell)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true);

        $sheet->setCellValue('D'.$startCell,'SUBTOTAL');
        $sheet->setCellValue('F'.$startCell,"$".number_format($subtotalCBAncaria, 2));

        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $startCell++;
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);


        

        $startCell++;
        $startCell++;
        $startCell++;

        $sheet->getRowDimension($startCell)->setRowHeight(30);

        $spreadsheet->getActiveSheet()->mergeCells('A'.$startCell.':I'.$startCell);
        $sheet->getStyle('A'.$startCell.':I'.$startCell)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A'.($startCell+1).':I'.($startCell+1))
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell)->getFont()->setBold(true);
        $sheet->setCellValue('A'.$startCell, 'INGRESOS EFECTIVO');

        $startCell++;
        $startCell++;

        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A'.($startCell+1).':I'.($startCell+1))
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);


        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('B'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('C'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('E'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('H'.$startCell)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('E'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('H'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('I'.$startCell)->getFont()->setBold(true);

        $sheet->setCellValue('A'.$startCell, 'NÚM');
        $sheet->setCellValue('B'.$startCell, 'FECHA');
        $sheet->setCellValue('C'.$startCell, 'NOMBRE');
        $sheet->setCellValue('D'.$startCell, 'NIVEL');
        $sheet->setCellValue('E'.$startCell, 'GENERACIÓN');
        $sheet->setCellValue('F'.$startCell, 'MONTO');
        $sheet->setCellValue('G'.$startCell, 'CONCEPTO');
        $sheet->setCellValue('H'.$startCell, 'TIPO DE PAGO');
        $sheet->setCellValue('I'.$startCell, 'NOTAS');

        $startCell++;
        $startCell++;
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $indice    = 1;
        $subtotalEfectivo  = 0;
        foreach ($pagos as $pago) {
            if($pago->Tipo_pago == 'Efectivo'){
                $sheet->setCellValue('A'.$startCell,$indice);
                $sheet->setCellValue('B'.$startCell,$pago->updated_at);
                $sheet->setCellValue('C'.$startCell,$pago->Nombre);
                $sheet->setCellValue('D'.$startCell,$pago->Nivel);
                $sheet->setCellValue('E'.$startCell,$pago->Generacion);
                $sheet->setCellValue('F'.$startCell,"$".number_format($pago->Cantidad_pago, 2));
                $sheet->setCellValue('G'.$startCell,$pago->Descripcion_pago);
                $sheet->setCellValue('H'.$startCell,$pago->Tipo_pago);
                $sheet->setCellValue('I'.$startCell,$pago->Notas);
                $subtotalEfectivo += $pago->Cantidad_pago;

                $spreadsheet->getActiveSheet()->getStyle('A'.$startCell)
                    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                $spreadsheet->getActiveSheet()->getStyle('I'.$startCell)
                    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

                $indice++;
                $startCell++;
            }
        }
        
        $spreadsheet->getActiveSheet()->getStyle('A'.$startCell.':I'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $spreadsheet->getActiveSheet()->mergeCells('D'.$startCell.':E'.$startCell);
        $sheet->getRowDimension($startCell)->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)->getFont()->setBold(true);

        $sheet->getStyle('D'.$startCell)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        
        $sheet->setCellValue('D'.$startCell,'SUBTOTAL');
        $sheet->setCellValue('F'.$startCell,"$".number_format($subtotalEfectivo, 2));

        
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        
        $startCell++;
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        
        $startCell++;
        $startCell++;




        $sheet->getRowDimension($startCell)->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell.':'.'F'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.($startCell+1).':'.'F'.($startCell+1))
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('D'.$startCell)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        $spreadsheet->getActiveSheet()->mergeCells('D'.$startCell.':E'.$startCell);
        $sheet->setCellValue('D'.$startCell,"CUENTA BANCARIA");
        $sheet->setCellValue('F'.$startCell,"$".number_format(($subtotalCBAncaria), 2));

        $startCell++;

        $sheet->getRowDimension($startCell)->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell.':'.'F'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.($startCell+1).':'.'F'.($startCell+1))
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('D'.$startCell)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        $spreadsheet->getActiveSheet()->mergeCells('D'.$startCell.':E'.$startCell);
        $sheet->setCellValue('D'.$startCell,"EFECTIVO");
        $sheet->setCellValue('F'.$startCell,"$".number_format(($subtotalEfectivo), 2));

        $startCell++;
        
        $sheet->getRowDimension($startCell)->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell.':'.'F'.$startCell)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.($startCell+1).':'.'F'.($startCell+1))
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startCell)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('D'.$startCell)->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 

        $spreadsheet->getActiveSheet()->mergeCells('D'.$startCell.':E'.$startCell);
        $sheet->setCellValue('D'.$startCell,"TOTAL");
        $sheet->setCellValue('F'.$startCell,"$".number_format(($subtotalCBAncaria+$subtotalEfectivo), 2));



        $writer = new Xlsx($spreadsheet);
        $writer->save($filename.'.xlsx');
        return ['data'=>true];
    }
    function controlPagosAction(){
        if (session()->get('user_roles')['Pagos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        $plantel        = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas WHERE Plantel_id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');
        $niveles        = DB::select('SELECT * FROM niveles WHERE Plantel_id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.')  ');

        if(isset($_GET['Id'])){
            $plantel        = DB::select('SELECT * FROM planteles WHERE Id = '.@$_GET['Id'].' ');
            $planteles      = DB::select('SELECT * FROM planteles WHERE Id = '.$_GET['Id'].' ');
            $licenciaturas  = DB::select('SELECT * FROM licenciaturas WHERE Plantel_id = '.@$_GET['Id'].' ');
            $niveles        = DB::select('SELECT * FROM niveles WHERE Plantel_id = '.@$_GET['Id'].' ');
        }

        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos ');
        $ciclosEscolares   = DB::select('SELECT YEAR(O.Fecha_creacion) AS year FROM ordenes O GROUP BY YEAR(O.Fecha_creacion) ');

        $whereQuery = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $generaciones   = DB::select('SELECT * FROM generaciones '.$whereQuery);
        
        return view('controlpagos.index',['plantel' => $plantel[0]->Nombre,'planteles' => $planteles,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'generaciones' => $generaciones,'ciclosEscolares' => $ciclosEscolares]);
    } 
    function createAlumnoDescuento($descuentoDetalles){
        
        $alumnoRelaciones = DB::select('SELECT * FROM alumno_relaciones WHERE Alumno_id = '.$descuentoDetalles['alumnoId'])[0];
        try{
            DB::table('pagos')->insert(
                [
                    'Alumno_id'       => $descuentoDetalles['alumnoId'],
                    'Concepto_id'     => $alumnoRelaciones->Concepto_id,
                    'Orden_id'        => $descuentoDetalles['ordenId'],
                    'Tipo_pago'       => 'Efectivo',
                    'Cantidad_pago'   => $descuentoDetalles['cantidadDescuento'],
                    'Descripcion'     => $descuentoDetalles['subConceptoId'],
                    'Notas'           => '',
                    'User_Id'         => Auth::user()->id
                ]
            );
            ordenes::where('Id', $descuentoDetalles['ordenId'])->update(
                    [
                        'Estatus' => 1
                    ]
                );
            
            $result = ['success','¡Descuento agregado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $errorCode = $e->errorInfo[1];
            $result = ['error','¡Error al guardar descuento! '.$errorCode];
        }
        return $result;
    }
    function createAlumnoPago($pagos,$recargos){
        $OrdenController = new OrdenController();
        $isValidPago = $this->isValidPago($pagos);
        if($isValidPago){
            try{
                $cantidadTotal = 0;
                foreach($pagos['cantidad'] as $pago){
                    $cantidadTotal += $pago['cantidadPago'];
                }
                $totalRecargos = 0;
                if(is_array($recargos)){
                    foreach($recargos['cantidad'] as $recargo){
                        $totalRecargos += $recargo['cantidadRecargo'];
                    }
                }
                if($pagos['detalles']['tipo'] == "colegiatura" || $pagos['detalles']['tipo'] == "inscripcion" || $pagos['detalles']['tipo'] == "cuota-personalizada-anual"){
                    $orden           = DB::select('SELECT * FROM ordenes WHERE Id = '.$pagos['detalles']['ordenId'])[0];
                    $pagosRealizados = DB::select('SELECT * FROM pagos WHERE Concepto_id = '.$pagos['detalles']['conceptoId'].' AND Orden_id = '.$pagos['detalles']['ordenId']);
                    $totalPagado     = 0;
                    foreach($pagosRealizados as $pagoRealizado){
                        $totalPagado += $pagoRealizado->Cantidad_pago;
                    }

                    $adeudo = (($orden->Precio + $totalRecargos) - $totalPagado);

                    if($cantidadTotal <= $adeudo){
                        if($orden->Estatus <> 2){
                            $result = $this->createPago($pagos['detalles'],$pagos['cantidad'],$totalRecargos);
                        }else{
                            $result = ['warning','¡El pago total ya ha sido realizado!'];
                        }
                    }else{
                        $result = ['warning','¡El pago excede el adeudo actual $'.number_format($adeudo,2).' !'];
                    }
                }else if($pagos['detalles']['tipo'] == "titulacion"){

                    $order    = DB::select('SELECT O.Id,O.Precio,O.Estatus FROM ordenes O LEFT JOIN conceptos C ON C.Id = O.Concepto_id WHERE O.Alumno_id = '.$pagos['detalles']['alumnoId'].' AND C.Tipo = "titulacion"');
                    $orderId  = 0;
                    if(count($order) > 0){
                        $order   = $order[0];
                        $orderId = $order->Id;
                        $pagos['detalles']['ordenId'] = $orderId;
                    }else{
                        $now = date_create_from_format('Y-m-d',date('Y-m-d'));
                        $now->setTimezone(new \DateTimeZone('America/Mexico_City'));
                        $now = $now->format('Y-m-d');
                        $concepto = DB::select('SELECT * FROM conceptos WHERE Id = '.$pagos['detalles']['conceptoId'])[0];
                        $orderId  = $OrdenController->createOrden($pagos['detalles']['alumnoId'],$concepto->Id,$concepto->Nombre,$now,$concepto->Precio,0,0);

                        $pagos['detalles']['ordenId'] = $orderId;
                        $order    = DB::select('SELECT O.Id,O.Precio,O.Estatus FROM ordenes O LEFT JOIN conceptos C ON C.Id = O.Concepto_id WHERE O.Alumno_id = '.$pagos['detalles']['alumnoId'].' AND C.Tipo = "titulacion"')[0];
                    }
                    $pagosRealizados = DB::select('SELECT * FROM pagos WHERE Concepto_id = '.$pagos['detalles']['conceptoId'].' AND Orden_id = '.$pagos['detalles']['ordenId']);
                    $totalPagado     = 0;

                    foreach($pagosRealizados as $pagoRealizado){
                        $totalPagado += $pagoRealizado->Cantidad_pago;
                    }
                    $adeudo = ($order->Precio - $totalPagado);
                    if($cantidadTotal <= $adeudo){
                        if($order->Estatus <> 2){
                            $result = $this->createPago($pagos['detalles'],$pagos['cantidad'],$totalRecargos);
                        }else{
                            $result = ['warning','¡El pago total ya ha sido realizado!'];
                        }
                    }else{
                        $result = ['warning','¡El pago excede el adeudo actual $'.number_format($adeudo,2).' !'];
                    }
                }else{
                    $now = date_create_from_format('Y-m-d',date('Y-m-d'));
                    $now->setTimezone(new \DateTimeZone('America/Mexico_City'));
                    $now = $now->format('Y-m-d');
                    
                    $concepto = DB::select('SELECT * FROM conceptos WHERE Id = '.$pagos['detalles']['conceptoId'])[0];
                    $orderId  = $OrdenController->createOrden($pagos['detalles']['alumnoId'],$concepto->Id,$concepto->Nombre,$now,$concepto->Precio,0,0);
                    
                    $pagos['detalles']['ordenId'] = $orderId;
                    $result = $this->createPago($pagos['detalles'],$pagos['cantidad'],$totalRecargos);
                }
            }catch(\Illuminate\Database\QueryException $e){
                print_r($e->errorInfo);
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    $result = ['warning','¡El pago ya ha sido previamente agregado!'];
                }else{
                    $result = ['error','¡Error al guardar Pago! '];
                }
            }
        }else{
            $result = ['warning','¡El pago debe ser una cantidad mayor a $100.00!'];
        }
        return $result;
    }
    function isValidPago($pagos){
        return ($pagos['cantidad'][0]['cantidadPago'] >= 100);
    }
    function createPago($pagoDetalles,$pagoCantidades,$totalRecargos){
        foreach($pagoCantidades as $pagoCantidad){
            DB::table('pagos')->insert(
                [
                    'Alumno_id'       => $pagoDetalles['alumnoId'],
                    'Concepto_id'     => $pagoDetalles['conceptoId'],
                    'Orden_id'        => $pagoDetalles['ordenId'],
                    'Tipo_pago'       => $pagoDetalles['tipoPago'],
                    'Cantidad_pago'   => $pagoCantidad['cantidadPago'],
                    'Descripcion'     => $pagoCantidad['subConceptoId'],
                    'Notas'           => $pagoDetalles['notas'] ,
                    'User_Id'         => Auth::user()->id
                ]
            );
        }
        $totalPagado = 0;
        $orden           = DB::select('SELECT * FROM ordenes WHERE Id = '.$pagoDetalles['ordenId'])[0];
        $pagosRealizados = DB::select('SELECT * FROM pagos WHERE Concepto_id = '.$pagoDetalles['conceptoId'].' AND Orden_id = '.$pagoDetalles['ordenId']);
        foreach($pagosRealizados as $pagoRealizado){
            $totalPagado += $pagoRealizado->Cantidad_pago;
        }
        if($totalPagado > 0){
            if($totalPagado == ($orden->Precio + $totalRecargos)){
                ordenes::where('Id', $pagoDetalles['ordenId'])->update(
                    [
                        'Estatus' => 2
                    ]
                );
                $result = ['success','¡Pago total agregado exitosamente!'];
            }else{
                ordenes::where('Id', $pagoDetalles['ordenId'])->update(
                    [
                        'Estatus' => 1
                    ]
                );
                $result = ['success','¡Pago parcial agregado exitosamente!'];
            }
        }else{
            $result = ['error','¡Error en pago!'];
        }
        return $result;
    }
    function getAllPagos($datos){
        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value <> 0){
                    switch ($key) {
                        // case 'plantel':
                        //     $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                        //     break;
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
                        case 'tipoPago': 
                            if($value){
                                $queryWhere .= ' AND C.Tipo IN ("colegiatura","inscripcion","pagos","titulacion","cuota-personalizada-anual") ';
                            }
                            break;
                        case 'fuente':
                            if($value == 1){
                                $queryWhere .= ' AND P.Tipo_pago = "Cuenta bancaria" ';
                            }elseif($value == 2){
                                $queryWhere .= ' AND P.Tipo_pago = "Efectivo" ';
                            }
                            break;
                        case 'fecha':
                            if($value == 1){
                                $queryWhere .= ' AND MONTH(P.created_at) = MONTH(CURDATE()) AND YEAR(P.created_at) = YEAR(CURDATE()) AND DAY(P.created_at) = DAY(CURDATE()) ';
                            }elseif($value == 2){
                                $queryWhere .= ' AND MONTH(P.created_at) = MONTH(CURDATE()) AND YEAR(P.created_at) = YEAR(CURDATE())';
                            }else{
                                $startDate   = date_create_from_format('d/m/Y h:i:s',$datos->start_date." 00:00:00");
                                $startDate   = $startDate->format('Y-m-d H:i:s');
                                $endDate     = date_create_from_format('d/m/Y h:i:s',$datos->end_date." 00:00:00");
                                date_add($endDate, date_interval_create_from_date_string('1 days'));
                                $endDate     = $endDate->format('Y-m-d H:i:s');
                                $queryWhere .= ' AND P.created_at BETWEEN "'.$startDate.'" AND  "'.$endDate.'"';
                            }
                            break;
                    }
                }
            }
        }

        if($datos->plantel > 0){
            $queryWhere .= ' AND AR.Plantel_id = '.$datos->plantel.' ';   
        }else{
            if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
                $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
            }
        }

        if($datos->tipo_corte_usuario > 0){
            $queryWhere .= ' AND P.User_Id = '.$datos->tipo_corte_usuario.' ';   
        }
        
        $pagosQuery = ''.
                      'SELECT P.Id,U.name AS Usuario,A.Id AS Alumno_id,CONCAT(A.Nombre," ",A.Apellido_materno," ",A.Apellido_paterno) AS Nombre,C.Nombre AS Descripcion_pago,A.Email,O.Descripcion,P.Cantidad_pago,P.Tipo_pago,P.Notas,DATE_FORMAT(P.updated_at, "%d-%m-%Y @ %r") AS updated_at '.
                      'FROM pagos P                                          '.
                      'LEFT JOIN conceptos C ON C.Id = P.Descripcion         '.
                      'LEFT JOIN users U ON U.id = P.User_Id                  '.
                      'LEFT JOIN alumnos A ON A.Id = P.Alumno_id             '.
                      'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id '.
                      'LEFT JOIN ordenes O ON O.Id = P.Orden_id              '.
                      'WHERE 1 = 1 '.$queryWhere;   
        
        $pagos  = DB::select($pagosQuery);
        
        return ['data'=>$pagos];
    }
    function getPagosReportes($datos,$datosBusqueda){
        $datos         = json_decode($datos);
        $datosBusqueda = json_decode($datosBusqueda);
        $queryWhere    = '';


        if(is_object($datosBusqueda)){
            foreach($datosBusqueda as $key => $value){
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
                        case 'mes':
                            $queryWhere .= ' AND MONTH(P.created_at) = MONTH("'.$value.'-00 00:00:00") AND YEAR(P.created_at) = YEAR("'.$value.'-00 00:00:00") ';
                            break;
                    }
                }
            }
        }


        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
        }
        $queryWhere .= ' AND MONTH(P.created_at) = MONTH(CURRENT_DATE()) AND YEAR(P.created_at) = YEAR(CURRENT_DATE())';

        

        $recaudacionBancariaQuery = ''.
                                          'SELECT SUM(P.Cantidad_pago) AS result      '.
                                          'FROM pagos                   P                                 '.
                                          'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = P.Alumno_id   '.
                                          'LEFT JOIN conceptos          C ON C.Id         = P.Descripcion '.
                                          'WHERE P.Tipo_pago = "Cuenta bancaria" AND C.Tipo IN ("colegiatura","inscripcion","pagos","titulacion","cuota-personalizada-anual") '.$queryWhere;

        $recaudacionEfectivoQuery = ''.
                                          'SELECT SUM(P.Cantidad_pago) AS result    '.
                                          'FROM pagos                   P                                 '.
                                          'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = P.Alumno_id   '.
                                          'LEFT JOIN conceptos          C ON C.Id         = P.Descripcion '.
                                          'WHERE P.Tipo_pago = "Efectivo" AND C.Tipo IN ("colegiatura","inscripcion","pagos","titulacion","cuota-personalizada-anual") '.$queryWhere;
        
        $recaudacionBecaQuery = ''.
                                          'SELECT SUM(P.Cantidad_pago) AS result    '.
                                          'FROM pagos                   P                                 '.
                                          'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = P.Alumno_id   '.
                                          'LEFT JOIN conceptos          C ON C.Id         = P.Descripcion '.
                                          'WHERE P.Tipo_pago = "Efectivo" AND C.Tipo IN ("becas") '.$queryWhere;

        $recaudacionDescuentosQuery = ''.
                                          'SELECT SUM(P.Cantidad_pago) AS result    '.
                                          'FROM pagos                   P                                 '.
                                          'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = P.Alumno_id   '.
                                          'LEFT JOIN conceptos          C ON C.Id         = P.Descripcion '.
                                          'WHERE P.Tipo_pago = "Efectivo" AND C.Tipo IN ("descuentos") '.$queryWhere;
        

        $recaudacionBancaria   = DB::select($recaudacionBancariaQuery);
        $recaudacionEfectivo   = DB::select($recaudacionEfectivoQuery);
        $recaudacionBecas      = DB::select($recaudacionBecaQuery);
        $recaudacionDescuentos = DB::select($recaudacionDescuentosQuery);

        $recaudacionBancaria   = (count($recaudacionBancaria)   > 0 ? $recaudacionBancaria[0]->result   : 0 );
        $recaudacionEfectivo   = (count($recaudacionEfectivo) > 0 ? $recaudacionEfectivo[0]->result : 0 );
        $recaudacionBecas      = (count($recaudacionBecas)      > 0 ? $recaudacionBecas[0]->result      : 0 );
        $recaudacionDescuentos = (count($recaudacionDescuentos) > 0 ? $recaudacionDescuentos[0]->result : 0 );

        $recaudacionTotal = ($recaudacionBancaria + $recaudacionEfectivo);

        $total            = ($recaudacionTotal + $recaudacionBecas + $recaudacionDescuentos);

        $result = ['success',
            'recaudacionTotal'      => $recaudacionTotal,
            'recaudacionBancaria'   => $recaudacionBancaria,
            'recaudacionEfectivo'   => $recaudacionEfectivo,
            'recaudacionBecas'      => $recaudacionBecas,
            'recaudacionDescuentos' => $recaudacionDescuentos,
            'total'                 => $total
        ];

        return $result;
    }
    function getAllPagosControl($datos){
        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value !== "0" && $value !== "" ){
                    switch ($key) {
                        // case 'plantel':
                        //     $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                        //     break;
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
                        case 'mes':
                            $queryWhere .= ' AND MONTH(P.created_at) = MONTH("'.$value.'-00 00:00:00") AND YEAR(P.created_at) = YEAR("'.$value.'-00 00:00:00") ';
                            break;
                    }
                }
            }
        }

        if($datos->plantel > 0){
            $queryWhere .= ' AND AR.Plantel_id = '.$datos->plantel.' ';   
        }else{
            if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
                $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
            }
        }
        
        // $pagosQuery = ''.
        //               'SELECT A.Id,@total := @total + 1 AS provId,A.Id AS Alumno_id,CONCAT(A.Nombre," ",A.Apellido_materno," ",A.Apellido_paterno) AS Nombre,A.Email,    '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 1  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoEnero,      '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 2  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoFebrero,    '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 3  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoMarzo,      '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 4  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoAbril,      '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 5  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoMayo,       '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 6  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoJunio,      '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 7  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoJulio,      '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 8  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoAgosto,     '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 9  THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoSeptiembre, '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 10 THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoOctubre,    '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 11 THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoNoviembre,  '.
        //               'MAX( CASE WHEN MONTH(O.Fecha_creacion) = 12 THEN (SELECT SUM(P.Cantidad_pago) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Descripcion WHERE P.Orden_id = O.Id AND C.Tipo IN ("colegiatura","inscripcion","pagos","cuota-personalizada-anual") ) ELSE 0 END) AS CantidadPagoDiciembre,  '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 1, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Enero,      '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 2, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Febrero,    '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 3, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Marzo,      '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 4, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Abril,      '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 5, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Mayo,       '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 6, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Junio,      '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 7, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Julio,      '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 8, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Agosto,     '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 9, IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Septimebre, '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 10,IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Octubre,    '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 11,IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Novienbre,  '.
        //               'MAX(IF(MONTH(O.Fecha_creacion) = 12,IF(O.Estatus = 2,2,IF(O.Estatus = 1,3,1)),0)) AS Diciembre   '.
        //               'FROM ordenes O                                        '.
        //               'LEFT JOIN generaciones  G ON G.Id = O.Generacion_id              '.

        //               'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = O.Alumno_id '.
        //               'LEFT JOIN alumnos A ON A.Id = AR.Alumno_id            '.
        //               'WHERE 1 = 1 '.$queryWhere.' AND A.Estatus = 1 AND YEAR(O.Fecha_creacion) = '.$datos->generacionEscolar.' GROUP BY A.Id,A.Nombre,A.Apellido_materno,A.Apellido_paterno,A.Email ORDER BY provId';//.$queryWhere;   
        //  DB::statement( DB::raw( 'SET @total := 0'));

         $pagosQuery = '
                        SELECT 
                        A.Id AS Alumno_id,
                        @total := @total + 1 AS provId,
                        CONCAT(A.Nombre, " ", A.Apellido_materno, " ", A.Apellido_paterno) AS Nombre,
                        A.Email,
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 1 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoEnero,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 1 THEN P.Id ELSE 0 END) AS IdOrdenEnero,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 1 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Enero,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 2 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoFebrero,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 2 THEN P.Id ELSE 0 END) AS IdOrdenFebrero,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 2 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Febrero,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 3 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoMarzo,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 3 THEN P.Id ELSE 0 END) AS IdOrdenMarzo,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 3 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Marzo,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 4 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoAbril,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 4 THEN P.Id ELSE 0 END) AS IdOrdenAbril,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 4 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Abril,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 5 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoMayo,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 5 THEN P.Id ELSE 0 END) AS IdOrdenMayo,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 5 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Mayo,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 6 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoJunio,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 6 THEN P.Id ELSE 0 END) AS IdOrdenJunio,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 6 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Junio,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 7 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoJulio,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 7 THEN P.Id ELSE 0 END) AS IdOrdenJulio,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 7 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Julio,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 8 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoAgosto,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 8 THEN P.Id ELSE 0 END) AS IdOrdenAgosto,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 8 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Agosto,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 9 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoSeptiembre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 9 THEN P.Id ELSE 0 END) AS IdOrdenSeptiembre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 9 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Septiembre,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 10 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoOctubre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 10 THEN P.Id ELSE 0 END) AS IdOrdenOctubre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 10 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Octubre,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 11 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoNoviembre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 11 THEN P.Id ELSE 0 END) AS IdOrdenNoviembre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 11 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Noviembre,
                        
                        SUM(CASE WHEN MONTH(O.Fecha_creacion) = 12 THEN P.Cantidad_pago ELSE 0 END) AS CantidadPagoDiciembre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 12 THEN P.Id ELSE 0 END) AS IdOrdenDiciembre,
                        MAX(CASE WHEN MONTH(O.Fecha_creacion) = 12 THEN IF(O.Estatus = 2, 2, IF(O.Estatus = 1, 3, 1)) ELSE 0 END) AS Diciembre
                        
                    FROM 
                        alumnos A
                        LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id
                        LEFT JOIN ordenes O ON O.Alumno_id = A.Id AND YEAR(O.Fecha_creacion) = 2024
                        LEFT JOIN pagos P ON P.Orden_id = O.Id
                        LEFT JOIN conceptos C ON C.Id = P.Descripcion AND C.Tipo IN ("colegiatura", "inscripcion", "pagos", "cuota-personalizada-anual")
                    WHERE 1 = 1 '.$queryWhere.' 
                        AND A.Estatus = 1 
                        AND YEAR(O.Fecha_creacion) = '.$datos->generacionEscolar.' 
                    GROUP BY 
                        A.Id,
                        Nombre,
                        A.Apellido_materno,
                        A.Apellido_paterno,
                        A.Email
                        ORDER BY provId;
         ';
         DB::statement( DB::raw( 'SET @total := 0'));
        $pagos  = DB::select($pagosQuery);
        return ['data'=>$pagos];
    }
    function getAlumnoAllPagos($alumnoId){ 
        $pagosQuery = ''.
                      'SELECT P.Id,U.name AS Usuario,O.Descripcion,P.Cantidad_pago,P.Tipo_pago,C.Nombre AS Descripcion_pago,P.Notas,DATE_FORMAT(P.updated_at, "%d-%m-%Y @ %r") AS updated_at '.
                      'FROM pagos P                             '.
                      'LEFT JOIN ordenes O ON O.Id = P.Orden_id '.
                      'LEFT JOIN conceptos C ON C.Id = P.Descripcion '.
                      'LEFT JOIN users U ON U.id = P.User_Id '.
                      'WHERE P.Alumno_id = :Id ORDER BY P.Id DESC';    
        
        $pagos  = DB::select($pagosQuery, ['Id' => $alumnoId]);
        
        return ['data'=>$pagos];
    }
    function getAlumnoPagosTitulacion($alumnoId){
        $pagosQuery = ''.
                      'SELECT P.Id,O.Descripcion,P.Cantidad_pago,P.Tipo_pago,C.Nombre AS Descripcion_pago,P.Notas,DATE_FORMAT(P.updated_at, "%d-%m-%Y @ %r") AS updated_at '.
                      'FROM pagos P                             '.
                      'LEFT JOIN ordenes            O ON O.Id = P.Orden_id '.
                      'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = O.Alumno_id '.
                      'LEFT JOIN conceptos          C ON C.Id = AR.Concepto_titulacion_id '.
                      'WHERE C.Tipo ="titulacion" AND P.Concepto_id = AR.Concepto_titulacion_id  AND P.Alumno_id = :Id';   
        
        $pagos  = DB::select($pagosQuery, ['Id' => $alumnoId]);
        
        return ['data'=>$pagos];
    }
    function getAlumnoPago($alumnoId,$plantelId){
        $plantelQuery = "";
        if($plantelId > 0){
            $plantelQuery = " Plantel_id = ".$plantelId." AND ";
        }
        $alumno = DB::select('SELECT * FROM alumnos WHERE Id = :Id', ['Id' => $alumnoId]);
        
        $conceptosQuery = ''.
                          'SELECT * '.
                          'FROM conceptos '.
                          'WHERE '.$plantelQuery.' (Tipo = "pagos" OR Tipo = "titulacion" OR Id IN '.
                          '(SELECT Concepto_id FROM alumno_relaciones WHERE Alumno_Id = '.$alumnoId.') OR Id IN '.
                          '(SELECT Concepto_cuota_id FROM alumno_relaciones WHERE Concepto_cuota_id > 0 AND Alumno_Id = '.$alumnoId.') )';
        //echo($conceptosQuery);
        $conceptos      = DB::select($conceptosQuery);
        
        /*$mensualidadesQuery = ''.
                          'SELECT O.Id,O.Descripcion,O.Fecha_creacion                                                         '.                             
                          'FROM      alumno_relaciones   AR                                                                   '.          
                          'LEFT JOIN concepto_relaciones CR ON CR.Concepto_id = AR.Concepto_id                                '.                                             
                          'LEFT JOIN ordenes              O ON O.Concepto_id  = CR.Concepto_id AND O.Alumno_id = AR.Alumno_id '.                                                                            
                          'WHERE AR.Alumno_Id = :Id ORDER BY ABS( DATEDIFF( O.Fecha_creacion, NOW() ) ) ';   
        */

        /*
        $mensualidadesQuery = ''.
                          'SELECT O.Id,O.Descripcion,O.Fecha_creacion                                               '.                             
                          'FROM      alumno_relaciones   AR                                                         '.          
                          'LEFT JOIN conceptos            C ON C.Id = AR.Concepto_id OR C.Id = AR.Concepto_inscripcion_id  OR C.Id = AR.Concepto_cuota_id '.                                             
                          'LEFT JOIN ordenes              O ON O.Concepto_id  = C.Id AND O.Alumno_id = AR.Alumno_id '.                                                                        
                          'WHERE AR.Alumno_Id = :Id AND O.Estatus <> 2 ORDER BY ABS( DATEDIFF( O.Fecha_creacion, NOW() ) ) ';   
        */
        $mensualidadesQuery = ''.
                          'SELECT O.Id,O.Descripcion,O.Fecha_creacion,C.Tipo                                       '.                                            
                          'FROM      alumnos              A                                                        '.                                      
                          'LEFT JOIN ordenes              O ON O.Alumno_id = A.Id                                  '.
                          'LEFT JOIN conceptos            C ON C.Id           = O.Concepto_id                      '.
                          'WHERE A.Id = :Id AND O.Estatus <> 2 ORDER BY ABS( DATEDIFF( O.Fecha_creacion, NOW() ) ) ';

        $mensualidades  = DB::select($mensualidadesQuery, ['Id' => $alumnoId]);
        
        $result = ['success','alumno'=>$alumno,'conceptos'=>$conceptos,'mensualidades'=>$mensualidades];
        return $result; 
    }

    function getPago($pagoId){
        try{
            $pagos  = DB::select('SELECT P.Id,P.Cantidad_pago,C.Nombre,P.Tipo_pago,P.Notas,P.created_at AS fecha FROM pagos P LEFT JOIN conceptos C On C.Id = P.Concepto_id WHERE P.Id = :Id', ['Id' => $pagoId])[0];
            $result = ['success',$pagos];
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al cargar el pago!'];
        }
        return $result;
    }
    function getPagos($ordenId){
        try{
            $pagos  = DB::select('SELECT P.Id,O.Descripcion,P.Cantidad_pago,C.Nombre,P.Tipo_pago,P.Notas,P.created_at AS fecha FROM pagos P LEFT JOIN conceptos C On C.Id = P.Concepto_id LEFT JOIN ordenes O On O.Id = P.Orden_id WHERE P.Orden_id = :Id', ['Id' => $ordenId]);
            $result = ['success',$pagos];
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al cargar el pago!'];
        }
        return $result;
    }
    function updatePago($pagoId,$datos){
        $result = '';
        try{
            pagos::where('Id', $pagoId)->update([
                'Cantidad_pago' => $datos['cantidadPago'],
                'Tipo_pago' => $datos['tipoPago'],
                'Notas' => $datos['notas']
            ]);                                       

            $result = ['success','¡Pago actualizado correctamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error actualizar pago!'];
        }
        return $result;
    }
}












