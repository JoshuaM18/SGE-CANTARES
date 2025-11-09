<?php
require_once __DIR__ . '/../modelo/MensajeModelo.php';

class MensajeController {
    private $modelo;

    public function __construct() {
        $this->modelo = new MensajeModelo();
    }

    // Bandeja de entrada (mensajes recibidos)
    public function bandejaEntrada($id_usuario) {
        $mensajes = $this->modelo->obtenerMensajesRecibidos($id_usuario);
        require __DIR__ . '/../vista/mensajes/entrada.php';
    }

    // Bandeja de enviados (mensajes enviados)
    public function bandejaEnviados($id_usuario) {
        $mensajes = $this->modelo->obtenerMensajesEnviados($id_usuario);
        require __DIR__ . '/../vista/mensajes/enviados.php';
    }

    // Formulario para enviar mensaje
 public function nuevo() {
    require_once __DIR__ . '/../modelo/UsuarioModelo.php';
    $usuarioModelo = new UsuarioModelo();
    $usuarios = $usuarioModelo->obtenerUsuarios(); // Trae todos los usuarios
    require __DIR__ . '/../vista/mensajes/nuevo.php';
}

    // Procesar envío de mensaje
    public function enviar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_remitente = $_POST['id_remitente'];
        $id_destinatario = $_POST['id_destinatario'];
        $asunto = $_POST['asunto'];
        $contenido = $_POST['contenido'];

        $resultado = $this->modelo->enviarMensaje($id_remitente, $id_destinatario, $asunto, $contenido);

        if ($resultado) {
            // 🔹 Integración Notificaciones
            require_once __DIR__ . '/../controller/NotificacionController.php';

            $notificacionController = new NotificacionController();
            $titulo_notif = "Nuevo mensaje recibido";
            $mensaje_notif = "Has recibido un nuevo mensaje: '{$asunto}'";
            $notificacionController->crearNotificacion($id_destinatario, $titulo_notif, $mensaje_notif);

            header("Location: index.php?c=Mensaje&a=bandejaEntrada&id_usuario=$id_remitente");
            exit();
        } else {
            echo "<p>Error al enviar el mensaje. Inténtalo de nuevo.</p>";
        }
    }
}

}
?>
