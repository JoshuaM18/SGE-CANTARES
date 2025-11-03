<?php
require_once __DIR__ . '/../Conexion.php';

class MensajeModelo {
    private $db;

    public function __construct() {
        $this->db = new Conexion(); // PDO
    }

    // Mensajes recibidos
    public function obtenerMensajesRecibidos($id_usuario) {
        $stmt = $this->db->conexion->prepare("
            SELECT 
                m.id_mensaje,
                m.id_remitente,
                m.id_destinatario,
                m.asunto,
                m.contenido,
                m.fecha,
                m.leido,
                u_rem.nombre_usuario AS remitente,
                u_rem.rol AS rol_remitente
            FROM mensajes m
            JOIN usuarios u_rem ON m.id_remitente = u_rem.id_usuario
            WHERE m.id_destinatario = ?
            ORDER BY m.fecha DESC
        ");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mensajes enviados
    public function obtenerMensajesEnviados($id_usuario) {
        $stmt = $this->db->conexion->prepare("
            SELECT 
                m.id_mensaje,
                m.id_remitente,
                m.id_destinatario,
                m.asunto,
                m.contenido,
                m.fecha,
                m.leido,
                u_dest.nombre_usuario AS destinatario,
                u_dest.rol AS rol_destinatario
            FROM mensajes m
            JOIN usuarios u_dest ON m.id_destinatario = u_dest.id_usuario
            WHERE m.id_remitente = ?
            ORDER BY m.fecha DESC
        ");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enviar mensaje
   public function enviarMensaje($id_remitente, $id_destinatario, $asunto, $contenido) {
    try {
        $stmt = $this->db->conexion->prepare("
            INSERT INTO mensajes (id_remitente, id_destinatario, asunto, contenido)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$id_remitente, $id_destinatario, $asunto, $contenido]);
        return ['success' => true];
    } catch (PDOException $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

    // Obtener usuarios
    public function obtenerUsuarios() {
        $stmt = $this->db->conexion->prepare("
            SELECT id_usuario, nombre_usuario, rol 
            FROM usuarios 
            WHERE estado = 'Activo' AND rol IN ('Docente', 'Estudiante')
            ORDER BY nombre_usuario ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Conversación
    public function obtenerConversacion($id_usuario, $id_otro) {
        $stmt = $this->db->conexion->prepare("
            SELECT 
                m.id_mensaje,
                m.id_remitente,
                m.id_destinatario,
                m.contenido,
                m.fecha,
                u_rem.nombre_usuario AS remitente,
                u_rem.rol AS rol_remitente,
                u_dest.nombre_usuario AS destinatario,
                u_dest.rol AS rol_destinatario
            FROM mensajes m
            JOIN usuarios u_rem ON m.id_remitente = u_rem.id_usuario
            JOIN usuarios u_dest ON m.id_destinatario = u_dest.id_usuario
            WHERE (m.id_remitente = ? AND m.id_destinatario = ?) 
               OR (m.id_remitente = ? AND m.id_destinatario = ?)
            ORDER BY m.fecha ASC
        ");
        $stmt->execute([$id_usuario, $id_otro, $id_otro, $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
