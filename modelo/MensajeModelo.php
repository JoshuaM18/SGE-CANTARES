<?php
class MensajeModelo {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerBandejaEntrada($id_usuario) {
        $query = $this->db->prepare("CALL sp_obtener_mensajes_recibidos(?)");
        $query->bindParam(1, $id_usuario);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBandejaSalida($id_usuario) {
        $query = $this->db->prepare("CALL sp_obtener_mensajes_enviados(?)");
        $query->bindParam(1, $id_usuario);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enviarMensaje($id_remitente, $id_destinatario, $asunto, $contenido) {
        $query = $this->db->prepare("CALL sp_enviar_mensaje(?, ?, ?, ?)");
        $query->bindParam(1, $id_remitente);
        $query->bindParam(2, $id_destinatario);
        $query->bindParam(3, $asunto);
        $query->bindParam(4, $contenido);
        return $query->execute();
    }
}
?>
