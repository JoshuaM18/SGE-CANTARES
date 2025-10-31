<?php
require_once "modelo/MensajeModelo.php";

class MensajeController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new MensajeModelo($conexion);
    }

    public function bandejaEntrada() {
        $mensajes = $this->modelo->obtenerBandejaEntrada($_GET['id_usuario']);
        require_once "vista/mensajes/bandeja_entrada.php";
    }

    public function bandejaSalida() {
        $mensajes = $this->modelo->obtenerBandejaSalida($_GET['id_usuario']);
        require_once "vista/mensajes/bandeja_salida.php";
    }

    public function nuevo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->enviarMensaje($_POST['id_remitente'], $_POST['id_destinatario'], $_POST['asunto'], $_POST['contenido']);
            header("Location: index.php?c=Mensaje&a=bandejaSalida&id_usuario=" . $_POST['id_remitente']);
        } else {
            require_once "vista/mensajes/nuevo.php";
        }
    }
}
?>
