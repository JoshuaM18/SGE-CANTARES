<?php
// Variable disponible: $anuncio
?>

<h2><?php echo htmlspecialchars($anuncio['titulo']); ?></h2>
<p><strong>Docente:</strong> <?php echo htmlspecialchars($anuncio['docente']); ?></p>
<p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($anuncio['fecha_publicacion'])); ?></p>
<hr>
<p><?php echo nl2br(htmlspecialchars($anuncio['descripcion'])); ?></p>

<a href="index.php?c=Anuncio&a=index&id_curso=<?php echo $anuncio['id_curso']; ?>" class="btn btn-secondary">Volver</a>
