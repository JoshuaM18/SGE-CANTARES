<?php
require_once __DIR__ . '/../../modelo/MensajeModelo.php';

$id_usuario = $_SESSION['usuario']['id_usuario'] ?? 0; 
$modelo = new MensajeModelo();

// Obtener mensajes recibidos y enviados
$mensajesRecibidos = $modelo->obtenerMensajesRecibidos($id_usuario);
$mensajesEnviados = $modelo->obtenerMensajesEnviados($id_usuario);

// Organizar conversaciones únicas
$conversaciones = [];

// Recibidos
foreach ($mensajesRecibidos as $m) {
    $otro_id = $m['id_remitente'];
    if (!isset($conversaciones[$otro_id]) || strtotime($m['fecha']) > strtotime($conversaciones[$otro_id]['fecha'])) {
        $conversaciones[$otro_id] = [
            'id' => $otro_id,
            'nombre' => $m['remitente'],
            'rol' => $m['rol_remitente'],
            'ultimo_mensaje' => $m['contenido'],
            'fecha' => $m['fecha']
        ];
    }
}

// Enviados
foreach ($mensajesEnviados as $m) {
    $otro_id = $m['id_destinatario'];
    if (!isset($conversaciones[$otro_id]) || strtotime($m['fecha']) > strtotime($conversaciones[$otro_id]['fecha'])) {
        $conversaciones[$otro_id] = [
            'id' => $otro_id,
            'nombre' => $m['destinatario'],
            'rol' => $m['rol_destinatario'],
            'ultimo_mensaje' => $m['contenido'],
            'fecha' => $m['fecha']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Bandeja de Entrada</title>
<link rel="stylesheet" href="css/mensajes.css">
<style>
.chat-container { display: flex; max-width: 900px; margin: 20px auto; border: 1px solid #ccc; }
.chat-sidebar { width: 30%; border-right: 1px solid #ccc; padding: 10px; }
.chat-main { flex: 1; padding: 10px; display: flex; flex-direction: column; }
#chatContenido { flex: 1; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; height: 400px; }
.chat-input { display: flex; }
.chat-input textarea { flex: 1; resize: none; }
.btn-nuevo { display: block; margin-bottom: 10px; padding: 5px 10px; background: #4CAF50; color: #fff; border: none; cursor: pointer; text-decoration: none; text-align: center; }
.chat-item { cursor: pointer; padding: 5px; border-bottom: 1px solid #ddd; }
.chat-item.selected { background: #eee; }
.mensaje.enviado { text-align: right; background: #d1ffd1; margin: 5px; padding: 5px; border-radius: 5px; }
.mensaje.recibido { text-align: left; background: #f1f1f1; margin: 5px; padding: 5px; border-radius: 5px; }
</style>
</head>
<body>

<div class="chat-container">

    <a href="/SGE/Vista/mensajes/nuevo.php" class="btn-nuevo">📤 Nuevo Mensaje</a>

    <div class="chat-sidebar">
        <h2>Conversaciones</h2>
        <ul id="listaChats">
            <?php foreach ($conversaciones as $conv): ?>
                <li class="chat-item" data-id="<?= $conv['id'] ?>" data-nombre="<?= htmlspecialchars($conv['nombre']) ?>" data-rol="<?= htmlspecialchars($conv['rol']) ?>">
                    <strong><?= htmlspecialchars($conv['nombre']) ?></strong><br>
                    <small><?= htmlspecialchars($conv['rol']) ?></small><br>
                    <small><?= htmlspecialchars($conv['ultimo_mensaje']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="chat-main">
        <div id="chatContenido">
            <p class="text-muted">Selecciona un chat para leer mensajes.</p>
        </div>
        <div class="chat-input">
            <textarea id="mensajeTexto" rows="2" placeholder="Escribe un mensaje..."></textarea>
            <button id="btnEnviar">Enviar</button>
        </div>
    </div>
</div>

<script>
window.idUsuario = <?= $id_usuario ?>;
</script>
<script src="/SGE/Vista/js/mensajes.js"></script>
</body>
</html>
