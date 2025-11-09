<?php
require_once __DIR__ . '/../modelo/NotificacionModelo.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class NotificacionController {
    private $modelo;
    private $usuarioModelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new NotificacionModelo();
        $this->usuarioModelo = new UsuarioModelo();
    }

    /**
     * Crear notificación para un usuario.
     * @param int $id_usuario
     * @param string $titulo
     * @param string $mensaje
     */
    public function crearNotificacion(int $id_usuario, string $titulo, string $mensaje) {
        // Insertar notificación en la base de datos
        if ($this->modelo->insertar($id_usuario, $titulo, $mensaje)) {
            $usuario = $this->usuarioModelo->obtenerUsuarioPorId($id_usuario);
            if ($usuario && !empty($usuario['correo'])) {
                // Por ahora comentamos el envío de correo
                // $this->modelo->enviarCorreo($usuario['correo'], $titulo, $mensaje);
            }
        }
    }

    /**
     * Obtener todas las notificaciones de un usuario.
     * @param int|null $id_usuario
     * @return array
     */
    public function verNotificaciones(int $id_usuario = null): array {
        if (!$id_usuario) {
            $id_usuario = $_SESSION['usuario']['id_usuario'];
        }
        return $this->modelo->obtenerPorUsuario($id_usuario);
    }

    /**
     * Marcar notificación como leída.
     */
    public function leerNotificacion() {
        $id_notificacion = $_GET['id_notificacion'] ?? null;
        if ($id_notificacion && is_numeric($id_notificacion)) {
            $this->modelo->marcarLeida((int)$id_notificacion);
        }
        header("Location: index.php");
        exit();
    }

    /**
     * Contar notificaciones no leídas de un usuario.
     * @param int $id_usuario
     * @return int
     */
    public function contarNoLeidas(int $id_usuario): int {
        return $this->modelo->contarNoLeidas($id_usuario);
    }
}
