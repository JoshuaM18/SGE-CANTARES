<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Depuración temporal
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../modelo/ReporteModelo.php';
require_once __DIR__ . '/../modelo/EstudianteModelo.php';
require_once __DIR__ . '/../pdf/ReporteCalificacionesPDF.php';

class ReporteController {
    public $modelo;

    public function __construct() {
        $this->modelo = new ReporteModelo();
    }

    // Acción por defecto: lista de reportes
    public function index() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
            exit("<p>No tiene permiso para ver esta sección.</p>");
        }
        require __DIR__ . '/../vista/reportes/index.php';
    }

    // Formulario para seleccionar estudiante y bimestre
    public function calificaciones() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
            exit("<p>No tiene permiso para ver esta sección.</p>");
        }

        $estModelo = new EstudianteModelo();
        $estudiantes = $estModelo->obtenerEstudiantes();

        require __DIR__ . '/../vista/reportes/calificaciones_form.php';
    }

    // Generar PDF
    public function generar($data) {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
            exit("<p>No tiene permiso para generar reportes.</p>");
        }

        // Limpiar cualquier salida previa para TCPDF
        if (ob_get_length()) { ob_end_clean(); }

        $id_estudiante = $data['id_estudiante'] ?? null;
        $bimestre = isset($data['bimestre']) ? (int)$data['bimestre'] : 1;
        $mostrarNotaFinal = isset($data['mostrar_nota_final']);
        $conductaSeleccionada = $data['conducta'] ?? 'BUENA';
        $asistenciaSeleccionada = $data['asistencia'] ?? '100%';

        if (!$id_estudiante) {
            exit("<p>Debe seleccionar un estudiante.</p>");
        }

        // Obtener calificaciones hasta el bimestre seleccionado
        $datos = $this->modelo->obtenerCalificacionesPorEstudianteBimestre($id_estudiante, $bimestre);

        if (!$datos || count($datos) === 0) {
            exit("<p>No se encontraron calificaciones para este estudiante.</p>");
        }

        // Preparar datos para el PDF
        $params = [
            'datos' => $datos,
            'bimestre' => $bimestre,
            'mostrar_nota_final' => $mostrarNotaFinal,
            'conducta' => $conductaSeleccionada,
            'asistencia' => $asistenciaSeleccionada
        ];

        // Nombre del PDF
        $nombreAlumno = trim(($datos[0]['nombre_estudiante'] ?? '') . ' ' . ($datos[0]['apellido_estudiante'] ?? ''));
        $pdfNombre = str_replace(' ', '_', $nombreAlumno) . '_Bimestre_' . $bimestre . '.pdf';

        // Generar PDF usando la clase independiente
        $pdf = new ReporteCalificacionesPDF();
        $pdf->generar($params, $pdfNombre);

        exit;
    }
}
