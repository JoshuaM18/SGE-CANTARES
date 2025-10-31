<h1>Editar Comentario</h1>
<form action="index.php?c=Comentario&a=actualizar" method="POST">
    <input type="hidden" name="id_comentario" value="<?= $comentario['id_comentario'] ?>">
    <input type="hidden" name="id_tarea" value="<?= $comentario['id_tarea'] ?>">
    <textarea name="comentario" required><?= htmlspecialchars($comentario['comentario']) ?></textarea><br>
    <button type="submit">Actualizar</button>
</form>
