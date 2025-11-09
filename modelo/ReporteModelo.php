<?php
require_once __DIR__ . '/../conexion.php';

class ReporteModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // SP: obtener todas las calificaciones de un estudiante
    public function obtenerCalificacionesPorEstudiante($id_estudiante) {
        $stmt = $this->db->conexion->prepare("CALL sp_reporte_calificaciones_por_estudiante(:id_estudiante)");
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // SP: obtener calificaciones hasta un bimestre específico
    public function obtenerCalificacionesPorEstudianteBimestre($id_estudiante, $bimestre) {
        $stmt = $this->db->conexion->prepare("CALL sp_reporte_calificaciones_por_estudiante_bimestre(:id_estudiante, :bimestre)");
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        $stmt->bindParam(':bimestre', $bimestre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
