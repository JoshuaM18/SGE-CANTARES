<?php
session_start();
if(!isset($_SESSION['usuario'])) exit("Debe iniciar sesión");

require_once __DIR__ . '/pdf/ReporteCalificacionesPDF.php';
require_once __DIR__ . '/conexion.php';

if(ob_get_length()) ob_end_clean();

$id_estudiante = $_POST['id_estudiante'] ?? null;
if(!$id_estudiante) exit("Falta el estudiante");

$bimestre = $_POST['bimestre'] ?? 1;
$mostrarNotaFinal = isset($_POST['mostrar_nota_final']);
$conducta = $_POST['conducta'] ?? 'BUENA';
$asistencia = $_POST['asistencia'] ?? '100%';

$db = new Conexion();
$pdo = $db->conexion;

$stmt = $pdo->prepare("
    SELECT e.nombre_estudiante, e.apellido_estudiante, e.grado,
           c.nombre_curso, n.bimestre1, n.bimestre2, n.bimestre3, n.bimestre4
    FROM estudiantes e
    JOIN calificaciones n ON e.id_estudiante = n.id_estudiante
    JOIN cursos c ON n.id_curso = c.id_curso
    WHERE e.id_estudiante = ?
");
$stmt->execute([$id_estudiante]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!$datos) exit("No hay calificaciones");

$params = [
    'datos'=>$datos,
    'bimestre'=>$bimestre,
    'mostrar_nota_final'=>$mostrarNotaFinal,
    'conducta'=>$conducta,
    'asistencia'=>$asistencia
];

$nombreAlumno = trim($datos[0]['nombre_estudiante'].' '.$datos[0]['apellido_estudiante']);
$pdfNombre = str_replace(' ','_',$nombreAlumno).'_Bimestre_'.$bimestre.'.pdf';

$pdf = new ReporteCalificacionesPDF();
$pdf->generar($params,$pdfNombre);
