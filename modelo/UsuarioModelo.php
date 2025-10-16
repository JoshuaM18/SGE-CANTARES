<?php
require_once __DIR__ . '/../Conexion.php';

class UsuarioModelo {
    public $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    public function obtenerUsuarios() {
        $stmt = $this->db->conexion->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuarioPorId($id) {
        $stmt = $this->db->conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarUsuario($nombre_usuario, $contrasena, $correo, $rol, $estado) {
        $stmt = $this->db->conexion->prepare("
            INSERT INTO usuarios (nombre_usuario, contrasena, correo, rol, estado)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$nombre_usuario, $contrasena, $correo, $rol, $estado]);
    }

    public function actualizarUsuario($id_usuario, $nombre_usuario, $correo, $rol, $estado) {
        $stmt = $this->db->conexion->prepare("
            UPDATE usuarios SET nombre_usuario = ?, correo = ?, rol = ?, estado = ?
            WHERE id_usuario = ?
        ");
        return $stmt->execute([$nombre_usuario, $correo, $rol, $estado, $id_usuario]);
    }

    public function eliminarUsuario($id_usuario) {
        $stmt = $this->db->conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id_usuario]);
    }

    // 🔹 NUEVO: obtener usuario por nombre de usuario (para login)
    public function obtenerUsuarioPorNombre($nombre_usuario) {
        $stmt = $this->db->conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$nombre_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
