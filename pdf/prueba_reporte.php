<?php
require_once __DIR__ . '/ReporteCalificacionesPDF.php';

// Datos de prueba
$datos = [
    ['curso'=>'Contabilidad','bimestre1'=>71,'bimestre2'=>64,'bimestre3'=>67,'bimestre4'=>54,'nota_final'=>64],
    ['curso'=>'Matemática Comercial','bimestre1'=>72,'bimestre2'=>83,'bimestre3'=>66,'bimestre4'=>56,'nota_final'=>69],
    ['curso'=>'Fundamentos de Derecho','bimestre1'=>83,'bimestre2'=>75,'bimestre3'=>82,'bimestre4'=>90,'nota_final'=>82],
    ['curso'=>'Inglés Comercial','bimestre1'=>78,'bimestre2'=>71,'bimestre3'=>68,'bimestre4'=>77,'nota_final'=>74],
    ['curso'=>'Publicidad I','bimestre1'=>78,'bimestre2'=>65,'bimestre3'=>79,'bimestre4'=>88,'nota_final'=>78],
    ['curso'=>'Mercadotecnia I','bimestre1'=>78,'bimestre2'=>97,'bimestre3'=>81,'bimestre4'=>75,'nota_final'=>83],
    ['curso'=>'Introducción a la Economía','bimestre1'=>83,'bimestre2'=>84,'bimestre3'=>81,'bimestre4'=>98,'nota_final'=>87],
    ['curso'=>'Comunicación','bimestre1'=>72,'bimestre2'=>49,'bimestre3'=>70,'bimestre4'=>100,'nota_final'=>73],
    ['curso'=>'Administración y Organización de Oficina','bimestre1'=>79,'bimestre2'=>67,'bimestre3'=>79,'bimestre4'=>81,'nota_final'=>77],
    ['curso'=>'Computación I','bimestre1'=>90,'bimestre2'=>82,'bimestre3'=>98,'bimestre4'=>76,'nota_final'=>87],
    ['curso'=>'Programación','bimestre1'=>94,'bimestre2'=>68,'bimestre3'=>77,'bimestre4'=>97,'nota_final'=>84],
    ['curso'=>'Desarrollo Humano y Profesional','bimestre1'=>71,'bimestre2'=>60,'bimestre3'=>70,'bimestre4'=>91,'nota_final'=>73],
    ['curso'=>'Educación Física','bimestre1'=>93,'bimestre2'=>94,'bimestre3'=>90,'bimestre4'=>91,'nota_final'=>92],
    ['curso'=>'Formación Cristiana','bimestre1'=>88,'bimestre2'=>83,'bimestre3'=>78,'bimestre4'=>80,'nota_final'=>82],
];

// Parámetros para generar el PDF
$params = [
    'datos' => $datos,
    'bimestre' => 4,             // Todos los bimestres
    'mostrar_nota_final' => true,
    'conducta' => 'BUENA',
    'asistencia' => '100%',
];

// Crear el PDF
$pdf = new ReporteCalificacionesPDF();
$pdf->generar($params, 'reporte_prueba.pdf');
