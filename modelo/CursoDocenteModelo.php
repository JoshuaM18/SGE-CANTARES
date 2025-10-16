<?php
require_once __DIR__ . '/../Conexion.php';

class CursoDocenteModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function obtenerAsignaciones() {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_asignaciones()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarDocente($id_curso, $id_docente, $anio_academico, $semestre) {
        $stmt = $this->db->conexion->prepare("CALL sp_asignar_docente_a_curso(?, ?, ?, ?)");
        return $stmt->execute([$id_curso, $id_docente, $anio_academico, $semestre]);
    }

    public function eliminarAsignacion($id_asignacion) {
        $stmt = $this->db->conexion->prepare("CALL sp_eliminar_asignacion(?)");
        return $stmt->execute([$id_asignacion]);
    }

    public function obtenerCursos() {
        $stmt = $this->db->conexion->prepare("SELECT * FROM cursos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDocentes() {
        $stmt = $this->db->conexion->prepare("SELECT * FROM docentes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAsignacionPorId($id_asignacion) {
    $stmt = $this->db->conexion->prepare("SELECT * FROM cursos_docentes WHERE id_asignacion = ?");
    $stmt->execute([$id_asignacion]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function actualizarAsignacion($id_asignacion, $id_curso, $id_docente, $anio_academico, $semestre) {
    $stmt = $this->db->conexion->prepare("CALL sp_actualizar_asignacion(?, ?, ?, ?, ?)");
    return $stmt->execute([$id_asignacion, $id_curso, $id_docente, $anio_academico, $semestre]);
}

}
?>
