<?php
require_once __DIR__ . '/../Conexion.php';

class AsistenciaModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener cursos asignados a un docente
   public function obtenerCursosDocente($id_docente) {
    $stmt = $this->db->conexion->prepare("
        SELECT cd.id_asignacion,
               c.nombre_curso,
               ca.nombre_carrera,
               cd.anio_academico,
               cd.semestre
        FROM cursos_docentes cd
        JOIN cursos c ON cd.id_curso = c.id_curso
        JOIN carreras ca ON c.id_carrera = ca.id_carrera
        WHERE cd.id_docente = ?
    ");
    $stmt->execute([$id_docente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Registrar o actualizar asistencia
    public function registrarAsistencia($id_matricula, $fecha, $estado) {
        $stmt = $this->db->conexion->prepare("CALL sp_registrar_asistencia(?, ?, ?)");
        return $stmt->execute([$id_matricula, $fecha, $estado]);
    }

    // Obtener asistencia de un estudiante por curso
    public function obtenerAsistenciaPorEstudiante($id_estudiante, $id_asignacion) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_asistencia_por_estudiante(?, ?)");
        $stmt->execute([$id_estudiante, $id_asignacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener lista de estudiantes de un curso para registrar asistencia
    public function obtenerEstudiantesPorAsignacion($id_asignacion) {
        $stmt = $this->db->conexion->prepare("
            SELECT m.id_matricula, e.nombres, e.apellidos
            FROM matriculas m
            JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
            WHERE m.id_asignacion = ?
        ");
        $stmt->execute([$id_asignacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener asistencias de un curso por fecha
public function obtenerAsistenciaPorCursoYFecha($id_asignacion, $fecha) {
    $stmt = $this->db->conexion->prepare("
        SELECT e.nombres, e.apellidos, a.estado
        FROM asistencias a
        JOIN matriculas m ON a.id_matricula = m.id_matricula
        JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
        WHERE m.id_asignacion = ? AND a.fecha = ?
    ");
    $stmt->execute([$id_asignacion, $fecha]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function obtenerCursoPorAsignacion($id_asignacion) {
    $stmt = $this->db->conexion->prepare("
        SELECT cd.id_asignacion,
               c.nombre_curso,
               ca.nombre_carrera,
               cd.anio_academico,
               cd.semestre
        FROM cursos_docentes cd
        JOIN cursos c ON cd.id_curso = c.id_curso
        JOIN carreras ca ON c.id_carrera = ca.id_carrera
        WHERE cd.id_asignacion = ?
    ");
    $stmt->execute([$id_asignacion]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Solo un curso
}


}
?>
