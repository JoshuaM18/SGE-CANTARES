<?php
require_once __DIR__ . '/../Conexion.php';

class CarreraCursoModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener todas las asignaciones
    public function obtenerAsignaciones() {
        $stmt = $this->db->conexion->prepare("
            SELECT cd.id_asignacion, c.nombre_curso, ca.nombre_carrera,
                   d.nombres AS docente_nombres, d.apellidos AS docente_apellidos,
                   cd.anio_academico
            FROM cursos_docentes cd
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            JOIN docentes d ON cd.id_docente = d.id_docente
            ORDER BY ca.nombre_carrera, c.nombre_curso
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todas las carreras
    public function obtenerCarreras() {
        $stmt = $this->db->conexion->prepare("
            SELECT id_carrera, nombre_carrera FROM carreras ORDER BY nombre_carrera
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los cursos con su carrera
    public function obtenerCursosConCarrera() {
        $stmt = $this->db->conexion->prepare("
            SELECT c.id_curso, c.nombre_curso, ca.id_carrera, ca.nombre_carrera
            FROM cursos c
            LEFT JOIN carreras ca ON c.id_carrera = ca.id_carrera
            ORDER BY ca.nombre_carrera, c.nombre_curso
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los docentes
    public function obtenerDocentes() {
        $stmt = $this->db->conexion->prepare("
            SELECT id_docente, nombres, apellidos FROM docentes ORDER BY apellidos
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar asignaciones múltiples
    public function guardarAsignaciones($anio, $cursos_docentes) {
        foreach ($cursos_docentes as $id_curso => $id_docente) {
            $stmt = $this->db->conexion->prepare("
                INSERT INTO cursos_docentes (id_curso, id_docente, anio_academico)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$id_curso, $id_docente, $anio]);
        }
    }

    // Eliminar una asignación
    public function eliminarAsignacion($id_asignacion) {
        $stmt = $this->db->conexion->prepare("
            DELETE FROM cursos_docentes WHERE id_asignacion = ?
        ");
        return $stmt->execute([$id_asignacion]);
    }

    // Obtener asignación por ID
    public function obtenerAsignacionPorId($id_asignacion) {
        $stmt = $this->db->conexion->prepare("
            SELECT * FROM cursos_docentes WHERE id_asignacion = ?
        ");
        $stmt->execute([$id_asignacion]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar asignación
    public function actualizarAsignacion($id_asignacion, $id_curso, $id_docente, $anio_academico) {
        $stmt = $this->db->conexion->prepare("
            UPDATE cursos_docentes
            SET id_curso = ?, id_docente = ?, anio_academico = ?
            WHERE id_asignacion = ?
        ");
        return $stmt->execute([$id_curso, $id_docente, $anio_academico, $id_asignacion]);
    }
}
?>
