<?php
require_once __DIR__ . '/../conexion.php';

class NotificacionModelo {
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->conexion; // directamente PDO
    }

    // Insertar notificación
    public function insertar(int $id_usuario, string $titulo, string $mensaje): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO notificaciones (id_usuario, titulo, mensaje)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$id_usuario, $titulo, $mensaje]);
    }

    // Obtener todas las notificaciones de un usuario
    public function obtenerPorUsuario(int $id_usuario): array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM notificaciones
            WHERE id_usuario = ?
            ORDER BY fecha DESC
        ");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Marcar notificación como leída
    public function marcarLeida(int $id_notificacion): bool {
        $stmt = $this->pdo->prepare("
            UPDATE notificaciones
            SET leido = TRUE
            WHERE id_notificacion = ?
        ");
        return $stmt->execute([$id_notificacion]);
    }

    // Contar notificaciones no leídas
    public function contarNoLeidas(int $id_usuario): int {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) AS total_no_leidas
            FROM notificaciones
            WHERE id_usuario = ? AND leido = FALSE
        ");
        $stmt->execute([$id_usuario]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total_no_leidas'];
    }

    // Enviar correo al usuario (temporalmente desactivado)
    public function enviarCorreo(string $correo, string $titulo, string $mensaje): bool {
        // ⚠️ Comentado para evitar warnings en XAMPP
        // $headers = "From: noreply@tuapp.com\r\n";
        // $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        // return mail($correo, $titulo, $mensaje, $headers);

        return true; // simulamos que siempre se envía correctamente
    }
}
?>
