<?php
require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';

class ReporteCalificacionesPDF extends TCPDF {

    public function Footer() {
        $this->SetY(-25);
        $this->SetFont('times','I',10);
        $this->MultiCell(0,6,"El principio de la Sabiduría es el temor a Jehová.\nProverbios 1:7",0,'C');

        $this->SetY(-15);
        $this->SetFont('helvetica','I',9);
        $this->Cell(0,10,$this->fechaEspañol(),0,0,'C');
    }

    private function fechaEspañol() {
        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $dia = date('d');
        $mes = $meses[(int)date('m')-1];
        $anio = date('Y');
        return "Guatemala, $dia de $mes de $anio";
    }

    public function generar($params, $pdfNombre) {
        if (ob_get_length()) { ob_end_clean(); }

        $datos = $params['datos'] ?? [];
        $bimestre = $params['bimestre'] ?? 1;
        $mostrarNotaFinal = $params['mostrar_nota_final'] ?? false;
        $conductaSeleccionada = $params['conducta'] ?? '';
        $asistenciaSeleccionada = $params['asistencia'] ?? '';

        if (empty($datos)) die("Error: No hay datos para generar el PDF.");

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
        $logoPath = __DIR__ . '/../img/logo_HD.jpg';
        if(file_exists($logoPath)){
            $this->Image($logoPath, ($this->getPageWidth()/2)-25, 15, 50, 0, '', '', '', false, 300);
        }
        $this->Ln(40);

        // Encabezado
        $this->SetFont('helvetica','B',14);
        $this->SetTextColor($colorRojo[0], $colorRojo[1], $colorRojo[2]);
        $this->Cell(0,6,'LICEO CRISTIANO CANTARES',0,1,'C');

        $this->SetFont('helvetica','B',12);
        $this->SetTextColor($colorAzul[0], $colorAzul[1], $colorAzul[2]);
        $this->Cell(0,6,'Reporte de Calificaciones',0,1,'C');

        $this->SetFont('helvetica','',11);
        $this->SetTextColor(0,0,0);
        $this->Cell(0,6,'Ciclo Escolar 2025',0,1,'C');
        $this->Ln(5);

        // Datos estudiante
        $nombreAlumno = trim(($datos[0]['nombre_estudiante'] ?? '').' '.($datos[0]['apellido_estudiante'] ?? ''));
       // $grado = $datos[0]['grado'] ?? 'N/A';
        $this->SetFont('helvetica','',10);
        $this->Cell(30,6,'Alumno:',0,0); $this->Cell(0,6,$nombreAlumno,0,1);
       // $this->Cell(30,6,'Grado:',0,0); $this->Cell(0,6,$grado,0,1);
        $this->Cell(30,6,'Bimestre:',0,0); $this->Cell(0,6,$bimestresNombres[$bimestre-1] ?? 'N/A',0,1);
        $this->Ln(5);

        // Tabla encabezado
        $this->SetFont('helvetica','B',9);
        $this->SetFillColor($colorAzul[0], $colorAzul[1], $colorAzul[2]);
        $this->SetTextColor(255,255,255);

        $this->MultiCell(60,8,"ÁREAS\nCURRICULARES",1,'C',1,0,'','',true,0,false,true,8,'M');
        for ($i=0;$i<$bimestre;$i++) $this->Cell(25,4,$bimestresNombres[$i] ?? '',1,0,'C',1);
        if($mostrarNotaFinal) $this->Cell(25,4,'NOTA',1,0,'C',1);
        $this->Ln();

        $this->Cell(60,4,'',0,0);
        for ($i=0;$i<$bimestre;$i++) $this->Cell(25,4,'BIMESTRE',1,0,'C',1);
        if($mostrarNotaFinal) $this->Cell(25,4,'FINAL',1,0,'C',1);
        $this->Ln();

        // Datos notas
        $this->SetFont('helvetica','',9);
        $todosPromovidos = true;
        $colorGrisCursos = [230,230,230];

        foreach($datos as $row){
            $this->SetFillColor($colorGrisCursos[0], $colorGrisCursos[1], $colorGrisCursos[2]);
            $this->SetTextColor(0,0,0);
            $curso = $row['curso'] ?? 'N/A';
            $this->Cell(60,6,$curso,1,0,'L',1);

            $suma=0; $cont=0;
            for($i=1;$i<=$bimestre;$i++){
                $nota = isset($row['bimestre'.$i])?(int)$row['bimestre'.$i]:'';
                if($nota!==''){
                    $suma+=$nota; $cont++;
                    // Color correcto
                    if($nota<60){
                        $this->SetTextColor($colorRojo[0], $colorRojo[1], $colorRojo[2]);
                    } else {
                        $this->SetTextColor(0,0,0);
                    }
                    $this->Cell(25,6,$nota,1,0,'C');
                } else {
                    $this->SetTextColor(0,0,0);
                    $this->Cell(25,6,'',1,0,'C');
                }
            }

            $notaFinalCurso = $cont>0?round($suma/$cont):0;
            if($mostrarNotaFinal){
                if($notaFinalCurso<60){
                    $this->SetTextColor($colorRojo[0], $colorRojo[1], $colorRojo[2]);
                } else {
                    $this->SetTextColor(0,0,0);
                }
                $this->Cell(25,6,$notaFinalCurso,1,0,'C');
            }

            $this->Ln();
            if($cont>0 && $notaFinalCurso<60) $todosPromovidos=false;
        }

        // Conducta y asistencia
        $this->SetTextColor(0,0,0);
        $this->Ln(5);
        $this->SetFont('helvetica','B',10);
        $this->Cell(0,6,$bimestresNombres[$bimestre-1].' BIMESTRE',0,1);

        $this->SetFont('helvetica','',9);
        $this->SetFillColor($colorGris[0], $colorGris[1], $colorGris[2]);
        $this->SetDrawColor(0,0,0);

        $conductaTexto = ['EXCELENTE'=>'','BUENA'=>'','REGULAR'=>'','MALA'=>''];
        if(isset($conductaTexto[$conductaSeleccionada])) $conductaTexto[$conductaSeleccionada]='• ';
        $this->Cell(40,6,'CONDUCTA:',1,0,'L',1);
        $this->MultiCell(0,6,$conductaTexto['EXCELENTE'].'EXCELENTE  '.
                                  $conductaTexto['BUENA'].'BUENA  '.
                                  $conductaTexto['REGULAR'].'REGULAR  '.
                                  $conductaTexto['MALA'].'MALA',1,'L',1,1);

        $asistenciaOpciones=['25%','50%','75%','100%'];
        $asistenciaTexto='';
        foreach($asistenciaOpciones as $opc) $asistenciaTexto.=($asistenciaSeleccionada==$opc?'• ':'').' '.$opc.'  ';
        $this->Cell(40,6,'ASISTENCIA:',1,0,'L',1);
        $this->MultiCell(0,6,trim($asistenciaTexto),1,'L',1,1);

        if($mostrarNotaFinal){
            $this->Ln(4);
            $this->SetFont('helvetica','B',12);
            $this->Cell(0,8,'RESULTADO FINAL: '.($todosPromovidos?'PROMOVIDO':'REPROBADO'),0,1,'C');
        }

        // Firma y sello
        $this->Ln(15);
        $this->SetFont('times','',12);
        $this->Cell(80,6,'Ing. Patricia Jocabeth Rodas García',0,1,'L');
        $this->Cell(80,6,'Vo. Bo. Directora',0,0,'L');

        $selloPath = __DIR__ . '/../img/Sello_mejorado.jpg';
        if(file_exists($selloPath)) $this->Image($selloPath, 95, $this->getY()-12, 40, 0, '', '', '', false, 300);

        $this->Output($pdfNombre,'I');
        exit;
    }
}
?>
