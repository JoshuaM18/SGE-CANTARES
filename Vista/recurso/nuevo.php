<head>
    <link rel="stylesheet" href="css/recurso.css">
</head>
<h2>Agregar Material Didáctico</h2>

<?php if (isset($mensaje)) : ?>
    <div class="mensaje-exito"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<form action="index.php?c=Recurso&a=agregar" method="post">
    <!-- Enviamos el ID de la asignación -->
    <input type="hidden" name="id_asignacion" value="<?= htmlspecialchars($id_asignacion) ?>">

    <div>
        <label for="titulo">Título del recurso:</label>
        <input type="text" name="titulo" id="titulo" required placeholder="Nombre del recurso">
    </div>

    <div>
        <label for="link_recurso">Link de Drive:</label>
        <input type="url" name="link_recurso" id="link_recurso" placeholder="https://drive.google.com/..." required>
    </div>

    <div>
        <button type="submit">Guardar</button>
        <a href="index.php?c=Recurso&a=index">Cancelar</a>
    </div>
</form>
