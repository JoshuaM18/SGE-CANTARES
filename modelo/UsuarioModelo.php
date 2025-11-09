<?php
require_once __DIR__ . '/../conexion.php';

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

    public function obtenerUsuariosExcepto($id_actual) {
    $stmt = $this->db->conexion->prepare("SELECT id_usuario, nombre_usuario, rol FROM usuarios WHERE id_usuario != ?");
    $stmt->execute([$id_actual]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerAlumnosPorCurso($id_curso) {
    $stmt = $this->db->conexion->prepare("
        SELECT u.id_usuario, u.nombre_usuario, u.correo
        FROM estudiantes e
        INNER JOIN matriculas m ON e.id_estudiante = m.id_estudiante
        INNER JOIN usuarios u ON e.id_usuario = u.id_usuario
        INNER JOIN cursos_docentes cd ON m.id_asignacion = cd.id_asignacion
        WHERE cd.id_curso = ? AND m.estado = 'Inscrito'
    ");
    $stmt->execute([$id_curso]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function obtenerTodosEstudiantes() {
    $stmt = $this->db->conexion->prepare("
        SELECT u.id_usuario 
        FROM usuarios u
        JOIN estudiantes e ON u.id_usuario = e.id_usuario
        WHERE u.estado = 'Activo'
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




}
?>
