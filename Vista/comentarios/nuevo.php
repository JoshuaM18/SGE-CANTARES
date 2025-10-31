<h2>Agregar Comentario</h2>

<form action="index.php?c=Comentario&a=guardar" method="POST">
    <input type="hidden" name="id_tarea" value="<?= $id_tarea ?>">
    <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario']['id_usuario'] ?>">
    
    <label for="comentario">Comentario:</label><br>
    <textarea name="comentario" id="comentario" rows="4" required></textarea><br><br>

    <button type="submit">Guardar Comentario</button>
    <a href="index.php?c=Comentario&a=index&id_tarea=<?= $id_tarea ?>">Cancelar</a>
</form>
