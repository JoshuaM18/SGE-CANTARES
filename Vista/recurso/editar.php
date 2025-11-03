<h2>Editar Material Didáctico</h2>

<form action="index.php?c=recurso&a=actualizar" method="POST">
    <input type="hidden" name="id_recurso" value="<?= $recurso['id_recurso'] ?>">
    <input type="hidden" name="id_asignacion" value="<?= $recurso['id_asignacion'] ?>">

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($recurso['titulo']) ?>" required><br><br>

    <label>Link de Drive:</label><br>
    <input type="url" name="link_recurso" value="<?= htmlspecialchars($recurso['link_recurso']) ?>" required><br><br>

    <button type="submit">Actualizar</button>
    <a href="index.php?c=recurso&a=listar&id_asignacion=<?= $recurso['id_asignacion'] ?>">Cancelar</a>
</form>
