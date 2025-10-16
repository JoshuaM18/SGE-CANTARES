<?php
require_once __DIR__ . '/../Conexion.php';

class CursoModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function obtenerCursos() {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_cursos()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCursoPorId($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_curso_por_id(?)");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarCurso($id_carrera, $nombre, $descripcion, $creditos) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_curso(?, ?, ?, ?)");
        return $stmt->execute([$id_carrera, $nombre, $descripcion, $creditos]);
    }

    public function actualizarCurso($id, $id_carrera, $nombre, $descripcion, $creditos) {
        $stmt = $this->db->conexion->prepare("CALL sp_actualizar_curso(?, ?, ?, ?, ?)");
        return $stmt->execute([$id, $id_carrera, $nombre, $descripcion, $creditos]);
    }

    public function eliminarCurso($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_eliminar_curso(?)");
        return $stmt->execute([$id]);
    }
}
?>
