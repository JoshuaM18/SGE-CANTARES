<?php
require_once __DIR__ . '/../Conexion.php';

class DocenteModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion();
    }

    // Obtener todos los docentes
    public function obtenerDocentes() {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_docentes()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un docente por ID
    public function obtenerDocentePorId($id) {
        $stmt = $this->db->conexion->prepare("CALL sp_obtener_docente_por_id(?)");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener usuarios disponibles (rol = Docente y que no estén asignados)
    public function obtenerUsuariosDisponibles() {
        $stmt = $this->db->conexion->prepare("
            SELECT * FROM usuarios 
            WHERE rol = 'Docente' 
            AND id_usuario NOT IN (SELECT id_usuario FROM docentes)
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar docente
    public function insertarDocente($id_usuario, $nombres, $apellidos, $especialidad, $telefono, $correo_institucional, $fecha_contratacion) {
        $stmt = $this->db->conexion->prepare("CALL sp_insertar_docente(?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$id_usuario, $nombres, $apellidos, $especialidad, $telefono, $correo_institucional, $fecha_contratacion]);
    }

    // Actualizar docente
    public function actualizarDocente($id_docente, $nombres, $apellidos, $especialidad, $telefono, $correo_institucional, $fecha_contratacion) {
        $stmt = $this->db->conexion->prepare("CALL sp_actualizar_docente(?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$id_docente, $nombres, $apellidos, $especialidad, $telefono, $correo_institucional, $fecha_contratacion]);
    }

    // Eliminar docente
    public function eliminarDocente($id_docente) {
        $stmt = $this->db->conexion->prepare("CALL sp_eliminar_docente(?)");
        return $stmt->execute([$id_docente]);
    }
}
?>
