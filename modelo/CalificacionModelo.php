<?php
require_once __DIR__ . '/../Conexion.php';

class CalificacionModelo {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Conexion();
        $this->pdo = $this->db->conexion;
    }

    // ---------------------------
    // Obtener id_docente desde id_usuario
    // ---------------------------
    public function obtenerIdDocente($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id_docente'] ?? null;
    }

    // ---------------------------
    // Obtener cursos asignados a un docente
    // ---------------------------
  public function obtenerCursosDocente($id_docente) {
    $stmt = $this->pdo->prepare("
        SELECT cd.id_asignacion, c.nombre_curso, ca.nombre_carrera, cd.anio_academico
        FROM cursos_docentes cd
        JOIN cursos c ON cd.id_curso = c.id_curso
        JOIN carreras ca ON c.id_carrera = ca.id_carrera
        WHERE cd.id_docente = ?
    ");
    $stmt->execute([$id_docente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // ---------------------------
    // Obtener estudiantes de un curso (por asignación)
    // ---------------------------
    public function obtenerEstudiantesPorCurso($id_asignacion) {
        $sql = "
            SELECT e.id_estudiante, e.nombres, e.apellidos, m.id_matricula
            FROM estudiantes e
            JOIN matriculas m ON e.id_estudiante = m.id_estudiante
            WHERE m.id_asignacion = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_asignacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ---------------------------
    // Obtener calificaciones de un curso (por estudiante)
    // ---------------------------
    public function obtenerNotasPorCurso($id_asignacion) {
    $stmt = $this->pdo->prepare("
        SELECT 
            m.id_matricula,
            CONCAT(e.nombres, ' ', e.apellidos) AS nombre_estudiante,
            c1.nombre_curso,
            cd.anio_academico,
            IFNULL(c.nota_b1,0) AS nota_b1,
            IFNULL(c.nota_b2,0) AS nota_b2,
            IFNULL(c.nota_b3,0) AS nota_b3,
            IFNULL(c.nota_b4,0) AS nota_b4,
            IFNULL((c.nota_b1 + c.nota_b2 + c.nota_b3 + c.nota_b4)/4,0) AS nota_final,
            c.observaciones
        FROM matriculas m
        INNER JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
        INNER JOIN cursos_docentes cd ON m.id_asignacion = cd.id_asignacion
        INNER JOIN cursos c1 ON cd.id_curso = c1.id_curso
        LEFT JOIN calificaciones c ON m.id_matricula = c.id_matricula
        WHERE m.id_asignacion = ?
        ORDER BY e.apellidos, e.nombres
    ");
    $stmt->execute([$id_asignacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // ---------------------------
    // Guardar o actualizar calificación general
    // ---------------------------
    public function guardarCalificacion($id_matricula, $nota, $observaciones) {
        $stmt = $this->pdo->prepare("CALL sp_insertar_calificacion(?, ?, ?)");
        return $stmt->execute([$id_matricula, $nota, $observaciones]);
    }

    // ---------------------------
    // Guardar o actualizar calificación por bimestre
    // ---------------------------
    public function guardarCalificacionBimestre($id_matricula, $bimestre, $nota, $observaciones) {
        $stmt = $this->pdo->prepare("CALL sp_insertar_calificacion_bimestre(?, ?, ?, ?)");
        return $stmt->execute([$id_matricula, $bimestre, $nota, $observaciones]);
    }
}
?>
