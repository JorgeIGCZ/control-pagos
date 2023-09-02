<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnos;
use Illuminate\Support\Facades\DB;
use URL;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MatriculaController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Matrícula']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $whereQuery = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }

        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas');
        $niveles        = DB::select('SELECT * FROM niveles');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos');
        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Tipo ="colegiatura" ');
        $generaciones   = DB::select('SELECT * FROM generaciones '.$whereQuery);
        
        return view('matricula.index',['planteles' => $planteles,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'conceptos' => $conceptos,'generaciones' => $generaciones]);
    }
    function createMatriculaPDF($datos){
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
                    }
                }
            }
        }
        $alumnos = DB::select('select A.Id,A.Nombre,A.Apellido_materno,A.Apellido_paterno,A.Email,A.Telefono,If(A.Estatus = 1,"Activo","Inactivo") AS Estatus FROM alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id WHERE A.Estatus = 1'.$queryWhere);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('SecEdu');
        $drawing->setDescription('SecEdu');
        $drawing->setPath('assets/images/seceduLogo.jpg'); // put your path and image here
        $drawing->setCoordinates('A1');
        $drawing->setWidth(300);
        $drawing->getShadow()->setVisible(false);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawingCeusjic = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawingCeusjic->setName('Ceusjic');
        $drawingCeusjic->setDescription('Ceusjic');
        $drawingCeusjic->setPath('assets/images/ceusjicLogo.png'); // put your path and image here
        $drawingCeusjic->setCoordinates('AB1');
        $drawingCeusjic->setWidth(100);
        $drawingCeusjic->getShadow()->setVisible(false);
        $drawingCeusjic->setWorksheet($spreadsheet->getActiveSheet());


        $spreadsheet->getActiveSheet()->mergeCells('A1:AD1');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
        $spreadsheet->getActiveSheet()->mergeCells('A2:AD2');
        $sheet->getStyle('A:D')->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER) //Set vertical center
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) //Set horizontal center
            ->setWrapText(true); 
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




        $spreadsheet->getActiveSheet()->getStyle('A10')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('B10')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('C10:T10')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('U10')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('V10:AD10')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('C11:T11')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('V11:AD11')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('V12:AB12')
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A10:A12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('A10:A12')
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('B10:B12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('C10')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('U10:U12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('U10:U12')
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('V12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('W12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('X12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('Y11:Y12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('Z12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('AA12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('AB11:AB12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('AC11:AC12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $spreadsheet->getActiveSheet()->getStyle('AD10:AD12')
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        

        
        $spreadsheet->getActiveSheet()->mergeCells('AC11:AC12');
        $spreadsheet->getActiveSheet()->mergeCells('AD11:AD12');

        $sheet->getRowDimension('12')->setRowHeight(70);

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(3.5);
        $sheet->getColumnDimension('D')->setWidth(3.5);
        $sheet->getColumnDimension('E')->setWidth(3.5);
        $sheet->getColumnDimension('F')->setWidth(3.5);
        $sheet->getColumnDimension('G')->setWidth(3.5);
        $sheet->getColumnDimension('H')->setWidth(3.5);
        $sheet->getColumnDimension('I')->setWidth(3.5);
        $sheet->getColumnDimension('J')->setWidth(3.5);
        $sheet->getColumnDimension('K')->setWidth(3.5);
        $sheet->getColumnDimension('L')->setWidth(3.5);
        $sheet->getColumnDimension('M')->setWidth(3.5);
        $sheet->getColumnDimension('N')->setWidth(3.5);
        $sheet->getColumnDimension('O')->setWidth(3.5);
        $sheet->getColumnDimension('P')->setWidth(3.5);
        $sheet->getColumnDimension('Q')->setWidth(3.5);
        $sheet->getColumnDimension('R')->setWidth(3.5);
        $sheet->getColumnDimension('S')->setWidth(3.5);
        $sheet->getColumnDimension('T')->setWidth(3.5);
        $sheet->getColumnDimension('U')->setWidth(4);
        $sheet->getColumnDimension('V')->setWidth(4);
        $sheet->getColumnDimension('W')->setWidth(4);
        $sheet->getColumnDimension('X')->setWidth(4);
        $sheet->getColumnDimension('Y')->setWidth(4);
        $sheet->getColumnDimension('Z')->setWidth(4);
        $sheet->getColumnDimension('AA')->setWidth(4);
        $sheet->getColumnDimension('AB')->setWidth(4);
        $sheet->getColumnDimension('AC')->setWidth(4);
        $sheet->getColumnDimension('AD')->setWidth(6);

        $spreadsheet->getActiveSheet()->getStyle('A10')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('B10')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C10')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C11')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('U10')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('V10')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('V11')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('Z11')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('AC11')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('AD11')->getFont()->setBold(true);


        $sheet->setCellValue('A1', 'GOBIERNO DEL ESTADO DE GUERRERO');
        $sheet->setCellValue('A2', 'SECRETARIA DE EDUCACION DE GUERRERO');
        $sheet->setCellValue('A3', 'SECRETARIA DE EDUCACION MEDIA SUPERIOR Y SUPERIOR');
        $sheet->setCellValue('A4', 'DEPARTAMENTO DE EDUCACION SUPERIOR');
        $sheet->setCellValue('A5', 'CENTRO DE ESTUDIOS SOR JUANA INES DE LA CRUZ S.C.');
        $sheet->setCellValue('A6', 'LICENCIATURA EN ENFERMERIA');
        $sheet->setCellValue('A7', 'OCTAVO CUATRIMESTRE SEMIESCOLARIZADO');
        $sheet->setCellValue('A8', 'NOMBRE DEL PROFESOR _______________________________________________MATERIA ___________________________________________');
        //$sheet->setCellValue('A9', '');
        $sheet->setCellValue('A10', 'NP');
        $sheet->setCellValue('B10', 'NOMBRE DEL ALUMNO');
        $sheet->setCellValue('C10', 'ASISTENCIAS');
        $sheet->setCellValue('C11', 'FECHA');
        $sheet->setCellValue('C12', '   /           /'.date('Y'));
        $sheet->setCellValue('D12', '   /           /'.date('Y'));
        $sheet->setCellValue('E12', '   /           /'.date('Y'));
        $sheet->setCellValue('F12', '   /           /'.date('Y'));
        $sheet->setCellValue('G12', '   /           /'.date('Y'));
        $sheet->setCellValue('H12', '   /           /'.date('Y'));
        $sheet->setCellValue('I12', '   /           /'.date('Y'));
        $sheet->setCellValue('J12', '   /           /'.date('Y'));
        $sheet->setCellValue('K12', '   /           /'.date('Y'));
        $sheet->setCellValue('L12', '   /           /'.date('Y'));
        $sheet->setCellValue('M12', '   /           /'.date('Y'));
        $sheet->setCellValue('N12', '   /           /'.date('Y'));
        $sheet->setCellValue('O12', '   /           /'.date('Y'));
        $sheet->setCellValue('P12', '   /           /'.date('Y'));
        $sheet->setCellValue('Q12', '   /           /'.date('Y'));
        $sheet->setCellValue('R12', '   /           /'.date('Y'));
        $sheet->setCellValue('S12', '   /           /'.date('Y'));
        $sheet->setCellValue('T12', '   /           /'.date('Y'));
        $sheet->setCellValue('U10', 'TOTAL INASISTENCIA');
        $sheet->setCellValue('V10', 'EVALUACION SUMATORIA');
        $sheet->setCellValue('V11', 'RASGOS');
        $sheet->setCellValue('Z11', 'INSTRU');
        $sheet->setCellValue('AC11', 'EXAMEN');
        $sheet->setCellValue('AD11', 'PROM. GRAL');

        $startCell = 13;
        $indice    = 1;

        foreach ($alumnos as $alumno) {
            $sheet->setCellValue('A'.$startCell,$indice);
            $sheet->setCellValue('B'.$startCell,$alumno->Nombre." ".$alumno->Apellido_materno." ".$alumno->Apellido_paterno);
            $indice++;
            $startCell++;
        }

        $sheet->setCellValue('A'.$startCell,'PROMEDIO DE APROVECHAMIENTO  _______________');
        $startCell++;
        $startCell++;
        $sheet->setCellValue('A'.$startCell,'PORCENTAJE DE APROBADOS            ________________');
        $startCell++;
        $startCell++;
        $sheet->setCellValue('A'.$startCell,'ELABORO _____________________________________');
        $startCell++;
        $startCell++;
        $sheet->setCellValue('A'.$startCell,'Vo.Bo. ________________________________________');

        $writer = new Xlsx($spreadsheet);
        $writer->save('Matricula.xlsx');
        return ['data'=>true];
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
                    }
                }
            }
        }
        
        //print_r('select A.Id,A.Nombre,A.Apellido_materno,A.Apellido_paterno,A.Email,A.Telefono,If(A.Estatus = 1,"Activo","Inactivo") AS Estatus FROM alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id WHERE A.Estatus = 1'.$queryWhere);
        $alumnos = DB::select('select A.Id,A.Nombre,A.Apellido_materno,A.Apellido_paterno,A.Email,A.Telefono,If(A.Estatus = 1,"Activo","Inactivo") AS Estatus FROM alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id WHERE A.Estatus = 1'.$queryWhere);
        return ['data'=>$alumnos];
    }
}
