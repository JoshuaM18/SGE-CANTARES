<?php
require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';

class ReporteCalificacionesPDF extends TCPDF {

    // Pie de página
    public function Footer() {
        $this->SetY(-25);
        $this->SetFont('times','I',10);
        $this->MultiCell(0,6,"El principio de la Sabiduría es el temor a Jehová.\nProverbios 1:7",0,'C');

        $this->SetY(-15);
        $this->SetFont('helvetica','I',9);
        $fecha = $this->fechaEspañol();
        $this->Cell(0,10,$fecha,0,0,'C');
    }

    private function fechaEspañol() {
        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $dia = date('d');
        $mes = $meses[(int)date('m')-1];
        $anio = date('Y');
        return "Guatemala, $dia de $mes de $anio";
    }

    public function generar($params, $pdfNombre) {
        if(ob_get_length()){ ob_end_clean(); }

        $datos = $params['datos'];
        $bimestre = $params['bimestre'];
        $mostrarNotaFinal = $params['mostrar_nota_final'];
        $conductaSeleccionada = $params['conducta'];
        $asistenciaSeleccionada = $params['asistencia'];

        $bimestresNombres = ['PRIMER','SEGUNDO','TERCER','CUARTO'];

        $this->SetCreator('TCPDF');
        $this->SetAuthor('Liceo Cristiano Cantares');
        $this->SetTitle('Reporte de Calificaciones');
        $this->SetMargins(15,25,15);
        $this->setPrintHeader(false);
        $this->setPrintFooter(true);
        $this->AddPage('P','LETTER');
        $this->SetFont('helvetica','',9);

        $colorAzul = [0,51,102];
        $colorGris = [240,240,240];
        $colorRojo = [204,0,0];

        // Logo
        $logoPath = __DIR__ . '/../img/logo HD.jpg';
        if(file_exists($logoPath)){
            $this->Image($logoPath, ($this->getPageWidth()/2)-25, 15, 50, 0, '', '', '', false, 300);
        }
        $this->Ln(40);

        // Encabezado
        $this->SetFont('helvetica','B',14);
        $this->SetTextColor($colorRojo[0],$colorRojo[1],$colorRojo[2]);
        $this->Cell(0,6,'LICEO CRISTIANO CANTARES',0,1,'C');

        $this->SetFont('helvetica','B',12);
        $this->SetTextColor($colorAzul[0],$colorAzul[1],$colorAzul[2]);
        $this->Cell(0,6,'Reporte de Calificaciones',0,1,'C');

        $this->SetFont('helvetica','',11);
        $this->SetTextColor(0,0,0);
        $this->Cell(0,6,'Ciclo Escolar 2025',0,1,'C');
        $this->Ln(5);

        // Datos del estudiante
        $nombreAlumno = trim($datos[0]['nombre_estudiante'].' '.$datos[0]['apellido_estudiante']);
        $grado = $datos[0]['grado'] ?? '';
        $this->SetFont('helvetica','',10);
        $this->Cell(30,6,'Alumno:',0,0);
        $this->Cell(0,6,$nombreAlumno,0,1);
        if($grado){
            $this->Cell(30,6,'Grado:',0,0);
            $this->Cell(0,6,$grado,0,1);
        }
        $this->Cell(30,6,'Bimestre:',0,0);
        $this->Cell(0,6,$bimestresNombres[$bimestre-1],0,1);
        $this->Ln(5);

// --- Tabla encabezado ---
$this->SetFont('helvetica','B',9);
$this->SetFillColor($colorAzul[0],$colorAzul[1],$colorAzul[2]);
$this->SetTextColor(255,255,255);

// Primera fila: ÁREAS CURRICULARES y nombre de bimestres
$this->MultiCell(60,8,"ÁREAS\nCURRICULARES",1,'C',1,0,'','',true,0,false,true,8,'M');
for($i=0;$i<$bimestre;$i++){
    $this->Cell(25,4,$bimestresNombres[$i],1,0,'C',1);
}
if($mostrarNotaFinal){
    $this->Cell(25,4,'NOTA',1,0,'C',1);
}
$this->Ln();

// Segunda fila: BIMESTRE / FINAL
$this->Cell(60,4,'',0,0); // columna ÁREAS CURRICULARES vacía
for($i=0;$i<$bimestre;$i++){
    $this->Cell(25,4,'BIMESTRE',1,0,'C',1);
}
if($mostrarNotaFinal){
    $this->Cell(25,4,'FINAL',1,0,'C',1);
}
$this->Ln();



        // --- Datos de notas ---
        $this->SetFont('helvetica','',9);
        $todosPromovidos = true;
        $colorGrisCursos = [230,230,230]; // gris suave para columna de cursos

        foreach($datos as $row){
            // Columna curso con gris
            $this->SetFillColor($colorGrisCursos[0],$colorGrisCursos[1],$colorGrisCursos[2]);
            $this->SetTextColor(0,0,0);
            $this->Cell(60,6,$row['curso'],1,0,'L',1);

            $suma=0; $cont=0;
            for($i=1;$i<=$bimestre;$i++){
                $nota = $row['bimestre'.$i] ?? '';
                if($nota !== ''){
                    $suma += $nota;
                    $cont++;
                    if($nota < 60){
                        $this->SetTextColor($colorRojo[0],$colorRojo[1],$colorRojo[2]);
                    } else {
                        $this->SetTextColor(0,0,0);
                    }
                    $this->Cell(25,6,intval($nota),1,0,'C');
                } else {
                    $this->SetTextColor(0,0,0);
                    $this->Cell(25,6,'',1,0,'C');
                }
            }

            $notaFinalCurso = ($cont>0)?($suma/$cont):0;
            if($mostrarNotaFinal){
                if($notaFinalCurso < 60){
                    $this->SetTextColor($colorRojo[0],$colorRojo[1],$colorRojo[2]);
                } else {
                    $this->SetTextColor(0,0,0);
                }
                $this->Cell(25,6,intval($notaFinalCurso),1,0,'C');
            }

            $this->Ln();
            if($cont>0 && $notaFinalCurso<60){ $todosPromovidos=false; }
        }

        // --- Restaurar negro para todo lo demás ---
        $this->SetTextColor(0,0,0);

        // Conducta y asistencia
        $this->Ln(5);
        $this->SetFont('helvetica','B',10);
        $this->Cell(0,6,$bimestresNombres[$bimestre-1].' BIMESTRE',0,1);

        $this->SetFont('helvetica','',9);
        $this->SetFillColor($colorGris[0],$colorGris[1],$colorGris[2]);
        $this->SetDrawColor(0,0,0);

        $conductaTexto = ['EXCELENTE'=>'','BUENA'=>'','REGULAR'=>'','MALA'=>''];
        $conductaTexto[$conductaSeleccionada] = '• ';
        $this->Cell(40,6,'CONDUCTA:',1,0,'L',1);
        $this->MultiCell(0,6,
            $conductaTexto['EXCELENTE'].'EXCELENTE  '.
            $conductaTexto['BUENA'].'BUENA  '.
            $conductaTexto['REGULAR'].'REGULAR  '.
            $conductaTexto['MALA'].'MALA',1,'L',1,1);

        $asistenciaOpciones = ['25%','50%','75%','100%'];
        $asistenciaTexto = '';
        foreach($asistenciaOpciones as $opc){
            $asistenciaTexto .= ($asistenciaSeleccionada==$opc?'• ':'').' '.$opc.'  ';
        }
        $this->Cell(40,6,'ASISTENCIA:',1,0,'L',1);
        $this->MultiCell(0,6,trim($asistenciaTexto),1,'L',1,1);

        if($mostrarNotaFinal){
            $this->Ln(4);
            $this->SetFont('helvetica','B',12);
            $resultado = $todosPromovidos?'PROMOVIDO':'REPROBADO';
            $this->Cell(0,8,'RESULTADO FINAL: '.$resultado,0,1,'C');
        }

        // Firma y sello
        $this->Ln(15);
        $this->SetFont('times','',12);
        $this->Cell(80,6,'Ing. Patricia Jocabeth Rodas García',0,1,'L');
        $this->Cell(80,6,'Vo. Bo. Directora',0,0,'L');

        $selloPath = __DIR__ . '/../img/Sello mejorado.jpg';
        if(file_exists($selloPath)){
            $this->Image($selloPath, 95, $this->getY()-12, 40, 0, '', '', '', false, 300);
        }

        $this->Output($pdfNombre,'I');
    }
}
?>
