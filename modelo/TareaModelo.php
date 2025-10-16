<?php
require_once __DIR__ . '/../Conexion.php';

class TareaModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // --- Crear tarea ---
    public function crearTarea($id_asignacion, $titulo, $descripcion, $fecha_entrega) {
        $stmt = $this->db->conexion->prepare("CALL sp_crear_tarea(?, ?, ?, ?)");
        return $stmt->execute([$id_asignacion, $titulo, $descripcion, $fecha_entrega]);
    }

    // --- Registrar entrega ---
    public function registrarEntrega($id_tarea, $id_estudiante, $link_drive) {
        $stmt = $this->db->conexion->prepare("CALL sp_registrar_entrega(?, ?, ?)");
        return $stmt->execute([$id_tarea, $id_estudiante, $link_drive]);
    }

    // --- Calificar entrega ---
    public function calificarEntrega($id_entrega, $calificacion, $observaciones) {
        $stmt = $this->db->conexion->prepare("CALL sp_calificar_entrega(?, ?, ?)");
        return $stmt->execute([$id_entrega, $calificacion, $observaciones]);
    }

    // --- Listar tareas de un curso/asignación con info de curso y carrera ---
    public function obtenerTareasPorAsignacion($id_asignacion) {
        $stmt = $this->db->conexion->prepare("
            SELECT t.*,
                   c.nombre_curso,
                   ca.nombre_carrera,
                   cd.anio_academico,
                   cd.semestre
            FROM tareas t
            JOIN cursos_docentes cd ON t.id_asignacion = cd.id_asignacion
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            WHERE t.id_asignacion = ?
        ");
        $stmt->execute([$id_asignacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Listar entregas de una tarea ---
    public function obtenerEntregasPorTarea($id_tarea) {
        $stmt = $this->db->conexion->prepare("
            SELECT e.*, est.nombres, est.apellidos
            FROM entregas_tareas e
            JOIN estudiantes est ON e.id_estudiante = est.id_estudiante
            WHERE id_tarea = ?
        ");
        $stmt->execute([$id_tarea]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Obtener información de un curso por id_asignacion ---
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
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un solo curso
    }

    // --- Obtener todos los cursos de un docente (para select al crear tarea) ---
    // Obtener todos los cursos asignados a un docente
public function obtenerCursosPorDocente($id_docente) {
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

// Obtener id_docente real desde id_usuario
public function obtenerIdDocentePorUsuario($id_usuario) {
    $stmt = $this->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    return $stmt->fetchColumn();
}

public function obtenerTareasPorEstudiante($id_estudiante) {
    $stmt = $this->db->conexion->prepare("
        SELECT t.*,
               c.nombre_curso,
               ca.nombre_carrera,
               cd.anio_academico,
               cd.semestre
        FROM tareas t
        JOIN cursos_docentes cd ON t.id_asignacion = cd.id_asignacion
        JOIN cursos c ON cd.id_curso = c.id_curso
        JOIN carreras ca ON c.id_carrera = ca.id_carrera
        JOIN matriculas m ON m.id_asignacion = cd.id_asignacion
        WHERE m.id_estudiante = ?
        ORDER BY t.fecha_entrega ASC
    ");
    $stmt->execute([$id_estudiante]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    
}
?>
