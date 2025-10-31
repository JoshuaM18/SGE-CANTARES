<?php
require_once __DIR__ . '/../Conexion.php';

class ComentarioModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener comentarios de una tarea
  public function obtenerComentariosPorTarea($id_tarea)
{
    $stmt = $this->db->conexion->prepare("
        SELECT 
            c.*, 
            u.nombre_usuario AS nombre,
            u.rol
        FROM comentarios_tareas c
        JOIN usuarios u ON c.id_usuario = u.id_usuario
        WHERE c.id_tarea = ?
        ORDER BY c.fecha ASC
    ");
    $stmt->execute([$id_tarea]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Insertar comentario
    public function insertarComentario($id_tarea, $id_usuario, $comentario) {
        $stmt = $this->db->conexion->prepare("
            INSERT INTO comentarios_tareas (id_tarea, id_usuario, comentario) VALUES (?, ?, ?)
        ");
        return $stmt->execute([$id_tarea, $id_usuario, $comentario]);
    }
}
?>
