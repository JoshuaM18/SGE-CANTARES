<?php
require_once __DIR__ . '/../conexion.php';

class ReporteModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function getNotasPorEstudiante($id_estudiante) {
        $stmt = $this->db->conexion->prepare("CALL sp_reporte_notas_por_estudiante(?)");
        $stmt->execute([$id_estudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAsistenciaMensual($mes, $anio) {
        $stmt = $this->db->conexion->prepare("CALL sp_reporte_asistencia_mensual(?, ?)");
        $stmt->execute([$mes, $anio]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocentesPorCarrera($id_carrera) {
        $stmt = $this->db->conexion->prepare("CALL sp_reporte_docentes_por_carrera(?)");
        $stmt->execute([$id_carrera]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMatriculasPorCurso($id_curso) {
        $stmt = $this->db->conexion->prepare("CALL sp_reporte_matriculas_por_curso(?)");
        $stmt->execute([$id_curso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
