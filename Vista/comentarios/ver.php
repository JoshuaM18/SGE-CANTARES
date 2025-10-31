<h1>Comentario</h1>
<p><?= htmlspecialchars($comentario['comentario']) ?></p>
<p>Fecha: <?= $comentario['fecha'] ?></p>
<a href="index.php?c=Comentario&a=index&id_tarea=<?= $comentario['id_tarea'] ?>">Volver</a>
