<?php
require_once __DIR__ . '/../modelo/ReporteModelo.php';
require_once __DIR__ . '/../modelo/EstudianteModelo.php';
require_once __DIR__ . '/../modelo/CursoModelo.php';
require_once __DIR__ . '/../modelo/CarreraModelo.php';
require_once __DIR__ . '/../librerias/tcpdf/tcpdf.php';

class ReporteController {
    private $modeloReporte;
    private $modeloEstudiante;
    private $modeloCurso;
    private $modeloCarrera;

    public function __construct() {
        $this->modeloReporte = new ReporteModelo();
        $this->modeloEstudiante = new EstudianteModelo();
        $this->modeloCurso = new CursoModelo();
        $this->modeloCarrera = new CarreraModelo();
    }

    // --- Mostrar menú de reportes ---
    public function index() {
        $estudiantes = $this->modeloEstudiante->obtenerEstudiantes();
        $cursos = $this->modeloCurso->obtenerCursos();
        $carreras = $this->modeloCarrera->obtenerCarreras();

        require_once __DIR__ . '/../vista/reportes/index.php';
    }

    // --- Reporte de notas por estudiante ---
    public function notasPorEstudiante($id_estudiante) {
        $notas = $this->modeloReporte->getNotasPorEstudiante($id_estudiante);

        // 🧹 Limpieza de salida
        if (ob_get_length()) ob_end_clean();
        header_remove();

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = "<h2>Reporte de Notas - Estudiante ID: $id_estudiante</h2>";
        $html .= "<table border='1' cellpadding='5'>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Nota</th>
                            <th>Periodo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($notas as $n) {
            $html .= "<tr>
                        <td>{$n['curso']}</td>
                        <td>{$n['nota']}</td>
                        <td>{$n['periodo']}</td>
                      </tr>";
        }
        $html .= "</tbody></table>";

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("reporte_notas_{$id_estudiante}.pdf", 'I');
        exit;
    }

    // --- Reporte de asistencia mensual ---
    public function asistenciaMensual($mes, $anio) {
        $asistencias = $this->modeloReporte->getAsistenciaMensual($mes, $anio);

        if (ob_get_length()) ob_end_clean();
        header_remove();

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = "<h2>Reporte de Asistencia - $mes/$anio</h2>";
        $html .= "<table border='1' cellpadding='5'>
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Curso</th>
                            <th>Asistencias</th>
                            <th>Faltas</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($asistencias as $a) {
            $html .= "<tr>
                        <td>{$a['estudiante']}</td>
                        <td>{$a['curso']}</td>
                        <td>{$a['asistencias']}</td>
                        <td>{$a['faltas']}</td>
                      </tr>";
        }
        $html .= "</tbody></table>";

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("reporte_asistencia_{$mes}_{$anio}.pdf", 'I');
        exit;
    }

    // --- Reporte de docentes por carrera ---
    public function docentesPorCarrera($id_carrera) {
        $docentes = $this->modeloReporte->getDocentesPorCarrera($id_carrera);

        if (ob_get_length()) ob_end_clean();
        header_remove();

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = "<h2>Docentes - Carrera ID: $id_carrera</h2>";
        $html .= "<table border='1' cellpadding='5'>
                    <thead>
                        <tr>
                            <th>Docente</th>
                            <th>Especialidad</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($docentes as $d) {
            $html .= "<tr>
                        <td>{$d['nombres']} {$d['apellidos']}</td>
                        <td>{$d['especialidad']}</td>
                        <td>{$d['correo_institucional']}</td>
                      </tr>";
        }
        $html .= "</tbody></table>";

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("reporte_docentes_carrera_{$id_carrera}.pdf", 'I');
        exit;
    }

    // --- Reporte de matrículas por curso ---
    public function matriculasPorCurso($id_curso) {
        $matriculas = $this->modeloReporte->getMatriculasPorCurso($id_curso);

        if (ob_get_length()) ob_end_clean();
        header_remove();

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = "<h2>Matrículas - Curso ID: $id_curso</h2>";
        $html .= "<table border='1' cellpadding='5'>
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Correo</th>
                            <th>Fecha de Matrícula</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($matriculas as $m) {
            $html .= "<tr>
                        <td>{$m['estudiante']}</td>
                        <td>{$m['correo']}</td>
                        <td>{$m['fecha_matricula']}</td>
                      </tr>";
        }
        $html .= "</tbody></table>";

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("reporte_matriculas_curso_{$id_curso}.pdf", 'I');
        exit;
    }
}
?>
