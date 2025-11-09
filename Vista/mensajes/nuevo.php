<?php
session_start();
require_once __DIR__ . '/../../modelo/UsuarioModelo.php';
require_once __DIR__ . '/../../modelo/MensajeModelo.php';

$id_usuario = $_SESSION['usuario']['id_usuario'] ?? 0;

$usuarioModelo = new UsuarioModelo();
$usuarios = $usuarioModelo->obtenerUsuariosExcepto($id_usuario); // Trae todos menos el usuario logueado
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="css/mensajeria.css">
<meta charset="UTF-8">
<title>Nuevo Mensaje</title>
</head>
<body>

<div class="nuevo-container">
    <h2>Enviar Nuevo Mensaje</h2>

    <!-- Botón de regreso -->
   <a href="/SGE/index.php?c=Mensaje&a=bandejaEntrada&id_usuario=<?= $id_usuario ?>" class="btn-regresar">← Volver a Bandeja de Entrada</a>
    <form id="formNuevoMensaje">
        <input type="hidden" name="id_remitente" value="<?= $id_usuario ?>">

        <label for="id_destinatario">Destinatario:</label>
        <select name="id_destinatario" id="id_destinatario" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id_usuario'] ?>">
                    <?= htmlspecialchars($u['nombre_usuario']) ?> (<?= $u['rol'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto">

        <label for="contenido">Mensaje:</label>
        <textarea name="contenido" id="contenido" rows="4" required></textarea>

        <button type="submit" class="btn-enviar">Enviar</button>
    </form>

    <div id="resultadoEnvio"></div>
</div>

<script>
const form = document.getElementById('formNuevoMensaje');
const resultado = document.getElementById('resultadoEnvio');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch('ajax_enviar_mensaje.php', {  // Ajusta la ruta según tu estructura
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        resultado.innerHTML = data.includes("correctamente") 
            ? '<p class="exito">' + data + '</p>' 
            : '<p class="error">' + data + '</p>';
        if (data.includes("correctamente")) form.reset();
    })
    .catch(err => {
        resultado.innerHTML = '<p class="error">Error al enviar el mensaje.</p>';
        console.error(err);
    });
});
</script>

</body>
</html>
