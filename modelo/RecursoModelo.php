<?php
require_once __DIR__ . '/../conexion.php';

class RecursoModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

   public function obtenerAsignacionesDocente($id_docente) {
    $stmt = $this->db->conexion->prepare("
        SELECT cd.id_asignacion, c.nombre_curso, ca.nombre_carrera
        FROM cursos_docentes cd
        JOIN cursos c ON cd.id_curso = c.id_curso
        JOIN carreras ca ON c.id_carrera = ca.id_carrera
        WHERE cd.id_docente = ?
    ");
    $stmt->execute([$id_docente]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function obtenerRecursosPorAsignacion($id_asignacion) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_recursos_por_asignacion(?)");
        $stmt->execute([$id_asignacion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerRecursoPorId($id_recurso) {
        $stmt = $this->db->conexion->prepare("SELECT * FROM recursos WHERE id_recurso = ?");
        $stmt->execute([$id_recurso]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarRecurso($id_asignacion, $titulo, $link_recurso) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_recurso(?, ?, ?)");
        return $stmt->execute([$id_asignacion, $titulo, $link_recurso]);
    }

    public function actualizarRecurso($id_recurso, $titulo, $link_recurso) {
        $stmt = $this->db->conexion->prepare("
            UPDATE recursos SET titulo = ?, link_recurso = ? WHERE id_recurso = ?
        ");
        return $stmt->execute([$titulo, $link_recurso, $id_recurso]);
    }

    public function eliminarRecurso($id_recurso) {
        $stmt = $this->db->conexion->prepare("DELETE FROM recursos WHERE id_recurso = ?");
        return $stmt->execute([$id_recurso]);
    }


}
