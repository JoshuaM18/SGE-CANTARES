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

    public function insertarCurso($id_carrera, $nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_curso(?, ?, ?)");
        return $stmt->execute([$id_carrera, $nombre, $descripcion]);
    }

    public function actualizarCurso($id, $id_carrera, $nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("CALL sp_actualizar_curso(?, ?, ?, ?)");
        return $stmt->execute([$id, $id_carrera, $nombre, $descripcion]);
    }

    public function eliminarCurso($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_eliminar_curso(?)");
        return $stmt->execute([$id]);
    }

    public function obtenerCursosCatalogo() {
    $stmt = $this->db->conexion->prepare("SELECT id_catalogo_curso, nombre_curso FROM catalogo_cursos ORDER BY nombre_curso ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function insertarCursosDesdeCatalogo($id_carrera, $cursosSeleccionados) {
        foreach ($cursosSeleccionados as $id_catalogo_curso) {
            $stmt = $this->db->conexion->prepare("
                INSERT INTO cursos (id_carrera, nombre_curso)
                SELECT ?, nombre_curso FROM catalogo_cursos WHERE id_catalogo_curso = ?
            ");
            $stmt->execute([$id_carrera, $id_catalogo_curso]);
        }
        return true;
    }

    public function obtenerCatalogoCursos() {
    $stmt = $this->db->conexion->prepare("SELECT * FROM catalogo_cursos ORDER BY nombre_curso ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
?>
