<?php
require_once __DIR__ . '/../Conexion.php';

class AnuncioModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // 📌 Insertar un nuevo anuncio
    public function insertarAnuncio($id_curso, $id_docente, $titulo, $descripcion) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_anuncio(?, ?, ?, ?)");
        return $stmt->execute([$id_curso, $id_docente, $titulo, $descripcion]);
    }

    // 📌 Obtener todos los anuncios de un curso
    public function obtenerAnunciosPorCurso($id_curso) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_anuncios_por_curso(?)");
        $stmt->execute([$id_curso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 📌 Archivar (ocultar) un anuncio
    public function archivarAnuncio($id_anuncio) {
        $stmt = $this->db->conexion->prepare("CALL sp_archivar_anuncio(?)");
        return $stmt->execute([$id_anuncio]);
    }

    // 📌 Obtener la información básica del curso (para mostrar en vistas)
    public function obtenerCursoPorId($id_curso) {
    $stmt = $this->db->conexion->prepare("
        SELECT c.id_curso, c.nombre_curso, ca.nombre_carrera
        FROM cursos c
        JOIN carreras ca ON c.id_carrera = ca.id_carrera
        WHERE c.id_curso = ?
    ");
    $stmt->execute([$id_curso]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // 📌 Obtener los cursos que un docente imparte (para filtrar sus anuncios)
    public function obtenerCursosDocente($id_docente) {
        $stmt = $this->db->conexion->prepare("
            SELECT cd.id_asignacion, c.id_curso, c.nombre_curso, ca.nombre_carrera
            FROM cursos_docentes cd
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            WHERE cd.id_docente = ?
        ");
        $stmt->execute([$id_docente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Obtener anuncios generales (visibles para todos)
public function obtenerAnunciosGenerales() {
    $stmt = $this->db->conexion->prepare("
        SELECT a.*, CONCAT(d.nombres, ' ', d.apellidos) AS docente
        FROM anuncios a
        LEFT JOIN docentes d ON a.id_docente = d.id_docente
        WHERE a.id_curso IS NULL AND a.estado = 'Activo'
        ORDER BY a.fecha_publicacion DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




}
?>
