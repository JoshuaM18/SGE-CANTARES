<?php
require_once __DIR__ . '/../Conexion.php';

class MatriculaModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener todas las matrículas con info de estudiante, curso, docente y año/semestre
    public function obtenerMatriculas() {
        $stmt = $this->db->conexion->prepare("
            SELECT m.id_matricula,
                   e.nombres AS estudiante_nombres,
                   e.apellidos AS estudiante_apellidos,
                   c.nombre_curso,
                   d.nombres AS docente_nombres,
                   d.apellidos AS docente_apellidos,
                   cd.anio_academico,
                   cd.semestre,
                   m.estado
            FROM matriculas m
            JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
            JOIN cursos_docentes cd ON m.id_asignacion = cd.id_asignacion
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN docentes d ON cd.id_docente = d.id_docente
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener estudiantes disponibles
    public function obtenerEstudiantes() {
        $stmt = $this->db->conexion->prepare("
            SELECT id_estudiante, nombres, apellidos FROM estudiantes
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener cursos disponibles para matrícula, incluyendo carrera y docente
    public function obtenerCursosParaMatricula() {
        $stmt = $this->db->conexion->prepare("
            SELECT cd.id_asignacion,
                   c.nombre_curso,
                   ca.nombre_carrera,
                   d.nombres AS docente_nombres,
                   d.apellidos AS docente_apellidos,
                   cd.anio_academico,
                   cd.semestre
            FROM cursos_docentes cd
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            JOIN docentes d ON cd.id_docente = d.id_docente
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar matrícula usando procedimiento almacenado
    public function insertarMatricula($id_estudiante, $id_asignacion, $estado) {
        $stmt = $this->db->conexion->prepare("
            CALL sp_matricular_estudiante(?, ?, ?)
        ");
        return $stmt->execute([$id_estudiante, $id_asignacion, $estado]);
    }

    // Obtener matrícula por ID
    public function obtenerMatriculaPorId($id) {
        $stmt = $this->db->conexion->prepare("
            SELECT * FROM matriculas WHERE id_matricula = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar matrícula
    public function actualizarMatricula($id_matricula, $id_estudiante, $id_asignacion, $estado) {
        $stmt = $this->db->conexion->prepare("
            UPDATE matriculas
            SET id_estudiante = ?, id_asignacion = ?, estado = ?
            WHERE id_matricula = ?
        ");
        return $stmt->execute([$id_estudiante, $id_asignacion, $estado, $id_matricula]);
    }

    // Eliminar matrícula
    public function eliminarMatricula($id_matricula) {
        $stmt = $this->db->conexion->prepare("
            DELETE FROM matriculas WHERE id_matricula = ?
        ");
        return $stmt->execute([$id_matricula]);
    }
}
?>
