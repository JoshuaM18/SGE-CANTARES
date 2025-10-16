<?php
require_once __DIR__ . '/../Conexion.php';

class EstudianteModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener todos los estudiantes
    public function obtenerEstudiantes() {
        $stmt = $this->db->conexion->prepare("
            SELECT e.*, u.nombre_usuario, u.correo
            FROM estudiantes e
            JOIN usuarios u ON e.id_usuario = u.id_usuario
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }
    
    

    public function obtenerUsuariosDisponibles() {
    $stmt = $this->db->conexion->prepare("
        SELECT * FROM usuarios 
        WHERE rol = 'Estudiante' 
        AND id_usuario NOT IN (SELECT id_usuario FROM estudiantes)
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Obtener estudiante por ID
    public function obtenerEstudiantePorId($id) {
        $stmt = $this->db->conexion->prepare("
            SELECT e.*, u.nombre_usuario, u.correo
            FROM estudiantes e
            JOIN usuarios u ON e.id_usuario = u.id_usuario
            WHERE e.id_estudiante = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar estudiante
    public function insertarEstudiante($id_usuario, $nombres, $apellidos, $fecha_nacimiento, $genero, $direccion, $telefono, $fecha_ingreso) {
        $stmt = $this->db->conexion->prepare("
            INSERT INTO estudiantes 
            (id_usuario, nombres, apellidos, fecha_nacimiento, genero, direccion, telefono, fecha_ingreso)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$id_usuario, $nombres, $apellidos, $fecha_nacimiento, $genero, $direccion, $telefono, $fecha_ingreso]);
    }

    // Actualizar estudiante
    public function actualizarEstudiante($id_estudiante, $nombres, $apellidos, $fecha_nacimiento, $genero, $direccion, $telefono, $fecha_ingreso) {
        $stmt = $this->db->conexion->prepare("
            UPDATE estudiantes SET 
                nombres = ?, 
                apellidos = ?, 
                fecha_nacimiento = ?, 
                genero = ?, 
                direccion = ?, 
                telefono = ?, 
                fecha_ingreso = ?
            WHERE id_estudiante = ?
        ");
        return $stmt->execute([$nombres, $apellidos, $fecha_nacimiento, $genero, $direccion, $telefono, $fecha_ingreso, $id_estudiante]);
    }

    // Eliminar estudiante
    public function eliminarEstudiante($id_estudiante) {
        $stmt = $this->db->conexion->prepare("DELETE FROM estudiantes WHERE id_estudiante = ?");
        return $stmt->execute([$id_estudiante]);
    }
}
?>
