<?php
require_once __DIR__ . '/../Conexion.php';

class NuevoCursoModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Insertar un nuevo curso individual al catálogo
    public function insertarCurso($nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("
            INSERT INTO catalogo_cursos (nombre_curso, descripcion)
            VALUES (?, ?)
        ");
        return $stmt->execute([$nombre, $descripcion]);
    }

    // Obtener todos los cursos creados
    public function obtenerCursos() {
        $stmt = $this->db->conexion->prepare("SELECT * FROM catalogo_cursos ORDER BY id_catalogo_curso DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar un curso (opcional)
    public function eliminarCurso($id) {
        $stmt = $this->db->conexion->prepare("DELETE FROM catalogo_cursos WHERE id_catalogo_curso = ?");
        return $stmt->execute([$id]);
    }
}
?>
