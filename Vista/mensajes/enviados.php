<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes Enviados</title>
    <link rel="stylesheet" href="css/mensajeria.css">
</head>
<body>
<div class="chat-container">
    <div class="chat-sidebar">
        <h2>Mensajes Enviados</h2>
        <ul id="listaChats">
            <?php foreach ($mensajes as $msg): ?>
                <li class="chat-item" data-id="<?= $msg['id_mensaje'] ?>">
                   <strong><?= htmlspecialchars($msg['destinatario']) ?></strong> <small>(<?= $msg['rol_destinatario'] ?>)</small>
<br>
                    <small><?= htmlspecialchars($msg['asunto']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
        <button id="btnNuevo" class="btn-nuevo" onclick="window.location='index.php?c=Mensaje&a=nuevo&id_usuario=<?= $_GET['id_usuario'] ?? 0 ?>'">📤 Nuevo Mensaje</button>
    </div>

    <div class="chat-main">
        <div id="chatContenido" class="chat-content">
            <p class="text-muted">Selecciona un mensaje enviado para ver su contenido.</p>
        </div>
        <div class="chat-input">
            <textarea id="mensajeTexto" placeholder="Escribe un mensaje..."></textarea>
            <button id="btnEnviar">Enviar</button>
        </div>
    </div>
</div>

<script src="/SGE/Vista/js/mensajes.js"></script>

<script>
const idUsuario = <?= json_encode($_GET['id_usuario'] ?? 0) ?>;
</script>
</body>
</html>
