<?php
require_once __DIR__ . '/../Conexion.php';

class CalificacionModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener id_docente desde id_usuario
    public function obtenerIdDocente($id_usuario) {
        $stmt = $this->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id_docente'] ?? null;
    }

    // Obtener cursos asignados a un docente
    public function obtenerCursosDocente($id_docente) {
        $stmt = $this->db->conexion->prepare("
            SELECT cd.id_asignacion, c.nombre_curso, cd.anio_academico, cd.semestre
            FROM cursos_docentes cd
            JOIN cursos c ON cd.id_curso = c.id_curso
            WHERE cd.id_docente = ?
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener notas de un curso de un docente
    public function obtenerNotasPorCurso($id_docente, $id_asignacion) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_notas_por_docente(?, ?)");
        $stmt->execute([$id_docente, $id_asignacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar o actualizar calificación
    public function guardarCalificacion($id_matricula, $nota, $observaciones) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_calificacion(?, ?, ?)");
        return $stmt->execute([$id_matricula, $nota, $observaciones]);
    }
}
?>
