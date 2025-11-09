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
<link rel="stylesheet" href="css/mensajeria.css">
<style>
:root {
    --amarillo: #f1c40f;
    --azul-marino: #2c3e50;
    --gris-claro: #f9f9f9;
}

/* Contenedor general */
.chat-container {
    display: flex;
    height: 90vh;
    border: 1px solid #ccc;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Sidebar */
.chat-sidebar {
    width: 250px;
    background-color: #fff; /* blanco */
    border-right: 1px solid #ccc;
    padding: 10px;
    overflow-y: auto;
}

/* Botón nuevo */
#btnNuevo {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    padding: 0.3rem 0.6rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    background: var(--amarillo);
    color: var(--azul-marino);
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(241,196,15,0.3);
    transition: all 0.2s ease;
    white-space: nowrap;
}

#btnNuevo::before {
    content: '✏️';
    margin-right: 0.3rem;
}

/* Chat principal */
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: var(--gris-claro);
}

/* Contenido de mensajes */
#chatContenido {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
}

/* Input */
.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ccc;
    background: #fff;
}

.chat-input textarea {
    flex: 1;
    resize: none;
    padding: 5px;
}

.chat-input button {
    margin-left: 5px;
}

/* Mensajes */
.mensaje {
    margin-bottom: 0.5rem;
    padding: 5px 10px;
    border-radius: 8px;
    max-width: 80%;
    word-wrap: break-word;
}

.enviado {
    background-color: #d1e7dd;
    align-self: flex-end;
}

.recibido {
    background-color: #fff;
    align-self: flex-start;
}
</style>
</head>
<body>

<div class="chat-container">

    <!-- Sidebar con botón -->
    <div class="chat-sidebar">
        <button id="btnNuevo" onclick="location.href='/SGE/Vista/mensajes/nuevo.php'">Nuevo Mensaje</button>
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

    <!-- Área principal de chat -->
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
