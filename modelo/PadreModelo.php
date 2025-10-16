<?php
require_once __DIR__ . '/../Conexion.php';

class PadreModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function obtenerPadres() {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_padres()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuariosDisponibles() {
        $stmt = $this->db->conexion->prepare("
            SELECT * FROM usuarios 
            WHERE rol = 'Padre' 
            AND id_usuario NOT IN (SELECT id_usuario FROM padres)
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPadrePorId($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_padre_por_id(?)");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarPadre($id_usuario, $nombres, $apellidos, $telefono, $correo, $direccion) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_padre(?,?,?,?,?,?)");
        return $stmt->execute([$id_usuario, $nombres, $apellidos, $telefono, $correo, $direccion]);
    }

    public function actualizarPadre($id_padre, $nombres, $apellidos, $telefono, $correo, $direccion) {
        $stmt = $this->db->conexion->prepare("CALL sp_actualizar_padre(?,?,?,?,?,?)");
        return $stmt->execute([$id_padre, $nombres, $apellidos, $telefono, $correo, $direccion]);
    }

    public function eliminarPadre($id_padre) {
        $stmt = $this->db->conexion->prepare("CALL sp_eliminar_padre(?)");
        return $stmt->execute([$id_padre]);
    }
}
?>
