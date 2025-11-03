<?php
session_start();
if (!isset($_SESSION['usuario'])) { echo "Usuario no logueado"; exit; }

require_once __DIR__ . '/../../modelo/MensajeModelo.php';
$modelo = new MensajeModelo();

$id_usuario = $_SESSION['usuario']['id_usuario'];
$id_conversacion = $_GET['id_conversacion'] ?? 0;

$mensajes = $modelo->obtenerConversacion($id_usuario, $id_conversacion);

foreach ($mensajes as $m) {
    $clase = $m['id_remitente'] == $id_usuario ? 'enviado' : 'recibido';
    echo "<div class='mensaje $clase'>{$m['contenido']}<br><small>{$m['fecha']}</small></div>";
}
?>

