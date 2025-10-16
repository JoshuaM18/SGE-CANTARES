<?php
require_once __DIR__ . '/../Conexion.php';

class CarreraModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function obtenerCarreras() {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_carreras()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCarreraPorId($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_carrera_por_id(?)");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarCarrera($nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_carrera(?, ?)");
        return $stmt->execute([$nombre, $descripcion]);
    }

    public function actualizarCarrera($id, $nombre, $descripcion) {
        $stmt = $this->db->conexion->prepare("CALL sp_actualizar_carrera(?, ?, ?)");
        return $stmt->execute([$id, $nombre, $descripcion]);
    }

    public function eliminarCarrera($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_eliminar_carrera(?)");
        return $stmt->execute([$id]);
    }
}
?>
