<?php
require_once __DIR__ . '/../Conexion.php';

class TareaModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // --- Crear tarea con procedimiento almacenado ---
    public function crearTarea($id_asignacion, $titulo, $descripcion, $fecha_entrega) {
        $stmt = $this->db->conexion->prepare("CALL sp_crear_tarea(?, ?, ?, ?)");
        return $stmt->execute([$id_asignacion, $titulo, $descripcion, $fecha_entrega]);
    }

    // --- Insertar tarea con valor ---
    public function insertarTarea($id_asignacion, $titulo, $descripcion, $fecha_entrega, $valor_tarea) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_tarea(?, ?, ?, ?, ?)");
        return $stmt->execute([$id_asignacion, $titulo, $descripcion, $fecha_entrega, $valor_tarea]);
    }

    // --- Registrar entrega de tarea ---
    public function registrarEntrega($id_tarea, $id_estudiante, $link_drive) {
        $stmt = $this->db->conexion->prepare("CALL sp_registrar_entrega(?, ?, ?)");
        return $stmt->execute([$id_tarea, $id_estudiante, $link_drive]);
    }

    // --- Calificar entrega ---
    public function calificarEntrega($id_entrega, $calificacion, $observaciones) {
        $stmt = $this->db->conexion->prepare("CALL sp_calificar_entrega(?, ?, ?)");
        return $stmt->execute([$id_entrega, $calificacion, $observaciones]);
    }

    // --- Listar tareas de un curso/asignación ---
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

    // --- Obtener entregas de una tarea ---
    public function obtenerEntregasPorTarea($id_tarea) {
        $stmt = $this->db->conexion->prepare("
            SELECT e.*, est.nombres, est.apellidos,
                   CASE WHEN e.calificacion IS NULL THEN 'No Calificada' ELSE 'Calificada' END AS estado
            FROM entregas_tareas e
            JOIN estudiantes est ON e.id_estudiante = est.id_estudiante
            WHERE e.id_tarea = ?
            ORDER BY est.apellidos, est.nombres
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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- Obtener todos los cursos de un docente ---
   public function obtenerCursosPorDocente($id_docente) {
    $stmt = $this->db->conexion->prepare("
        SELECT cd.id_asignacion,
               c.id_carrera,  -- <-- Agregado
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


    // --- Obtener id_docente desde id_usuario ---
    public function obtenerIdDocentePorUsuario($id_usuario) {
        $stmt = $this->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchColumn();
    }

    // --- Obtener conteo de entregas por tarea ---
    public function obtenerConteoEntregasPorTarea($id_tarea) {
        $sql = "
            SELECT 
                SUM(CASE WHEN calificacion IS NOT NULL THEN 1 ELSE 0 END) AS calificadas,
                SUM(CASE WHEN calificacion IS NULL THEN 1 ELSE 0 END) AS pendientes
            FROM entregas_tareas
            WHERE id_tarea = ?
        ";
        $stmt = $this->db->conexion->prepare($sql);
        $stmt->execute([$id_tarea]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: ['calificadas' => 0, 'pendientes' => 0];
    }

    // --- Métodos para estudiantes ---
    public function obtenerTareasPorEstudiante($id_estudiante) {
        $stmt = $this->db->conexion->prepare("
            SELECT t.*,
                   cd.id_curso,
                   c.nombre_curso,
                   ca.nombre_carrera,
                   cd.anio_academico,
                   cd.semestre,
                   e.id_entrega,
                   e.calificacion
            FROM tareas t
            JOIN cursos_docentes cd ON t.id_asignacion = cd.id_asignacion
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            JOIN matriculas m ON m.id_asignacion = cd.id_asignacion
            LEFT JOIN entregas_tareas e 
                   ON e.id_tarea = t.id_tarea AND e.id_estudiante = ?
            WHERE m.id_estudiante = ?
            ORDER BY t.fecha_entrega ASC
        ");
        $stmt->execute([$id_estudiante, $id_estudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTareasConEstado($id_estudiante) {
        return $this->obtenerTareasPorEstudiante($id_estudiante);
    }

    public function obtenerEntregaPorTareaYEstudiante($id_tarea, $id_estudiante) {
        $stmt = $this->db->conexion->prepare("
            SELECT t.titulo, t.fecha_entrega, c.nombre_curso, ca.nombre_carrera,
                   e.link_drive, e.calificacion, e.observaciones
            FROM tareas t
            JOIN cursos_docentes cd ON t.id_asignacion = cd.id_asignacion
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            LEFT JOIN entregas_tareas e ON e.id_tarea = t.id_tarea AND e.id_estudiante = ?
            WHERE t.id_tarea = ?
        ");
        $stmt->execute([$id_estudiante, $id_tarea]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- Obtener todos los cursos de un estudiante ---
    public function obtenerCursosPorEstudiante($id_estudiante) {
        $stmt = $this->db->conexion->prepare("
            SELECT c.id_curso,
                   c.nombre_curso,
                   ca.nombre_carrera,
                   cd.id_asignacion,
                   cd.anio_academico,
                   cd.semestre
            FROM cursos c
            INNER JOIN cursos_docentes cd ON cd.id_curso = c.id_curso
            INNER JOIN matriculas m ON m.id_asignacion = cd.id_asignacion
            INNER JOIN carreras ca ON c.id_carrera = ca.id_carrera
            WHERE m.id_estudiante = ?
            ORDER BY c.nombre_curso ASC
        ");
        $stmt->execute([$id_estudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- Obtener el valor máximo de una tarea ---
    public function obtenerValorTarea($id_tarea) {
        $stmt = $this->db->conexion->prepare("SELECT valor_tarea FROM tareas WHERE id_tarea = ?");
        $stmt->execute([$id_tarea]);
        return $stmt->fetchColumn(); // Devuelve el valor de la tarea
    }
}
?>
