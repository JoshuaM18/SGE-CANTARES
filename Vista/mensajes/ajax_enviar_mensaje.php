<?php
session_start();
require_once __DIR__ . '/../../modelo/MensajeModelo.php';

$id_remitente = $_POST['id_remitente'] ?? 0;
$id_destinatario = $_POST['id_destinatario'] ?? 0;
$contenido = $_POST['contenido'] ?? '';

if (!$id_remitente || !$id_destinatario || !$contenido) {
    echo "Error: datos incompletos.";
    exit;
}

$modelo = new MensajeModelo();
$result = $modelo->enviarMensaje($id_remitente, $id_destinatario, '', $contenido);

echo ($result['success']) ? 'ok' : $result['error'];
?>
