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

<style>
form {
    max-width: 500px;
    margin-top: 20px;
}

form div {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"], input[type="url"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}

button {
    padding: 8px 15px;
    cursor: pointer;
}

.mensaje-exito {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}
</style>
