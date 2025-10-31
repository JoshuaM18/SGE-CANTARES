<?php
require_once __DIR__ . '/../Conexion.php';

class CatalogoCursoModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener todos los cursos del catálogo
   public function obtenerCatalogoCursos() {
    $stmt = $this->db->conexion->prepare("SELECT id_catalogo_curso, nombre_curso, descripcion FROM catalogo_cursos ORDER BY nombre_curso ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Obtener un curso por ID
    public function obtenerCursoPorId($id) {
        $stmt = $this->db->conexion->prepare("SELECT * FROM catalogo_cursos WHERE id_catalogo_curso = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar nuevo curso en catálogo
    public function insertarCurso($nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("INSERT INTO catalogo_cursos (nombre_curso, descripcion) VALUES (?, ?)");
        return $stmt->execute([$nombre, $descripcion]);
    }

    // Actualizar curso en catálogo
    public function actualizarCurso($id, $nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("UPDATE catalogo_cursos SET nombre_curso = ?, descripcion = ? WHERE id_catalogo_curso = ?");
        return $stmt->execute([$nombre, $descripcion, $id]);
    }

    // Eliminar curso del catálogo
    public function eliminarCurso($id) {
        $stmt = $this->db->conexion->prepare("DELETE FROM catalogo_cursos WHERE id_catalogo_curso = ?");
        return $stmt->execute([$id]);
    }
}
?>
