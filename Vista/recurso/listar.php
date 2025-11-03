<h2>Material Didáctico</h2>

<a href="index.php?c=recurso&a=nuevo&id_asignacion=<?= $_GET['id_asignacion'] ?>">Agregar nuevo recurso</a>
<hr>

<?php if (!empty($recursos)): ?>
    <?php foreach ($recursos as $r): ?>
        <div style="margin-bottom: 30px; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
            <h3><?= htmlspecialchars($r['titulo']) ?></h3>
            
            <!-- Vista incrustada de Drive -->
            <iframe src="<?= convertirLinkDrive($r['link_recurso']) ?>" width="100%" height="400px"></iframe>
            
            <br>
            <a href="<?= $r['link_recurso'] ?>" target="_blank">Abrir en Drive / Descargar</a> |
            <a href="index.php?c=recurso&a=editar&id_recurso=<?= $r['id_recurso'] ?>">Editar</a> |
            <a href="index.php?c=recurso&a=eliminar&id_recurso=<?= $r['id_recurso'] ?>&id_asignacion=<?= $_GET['id_asignacion'] ?>" onclick="return confirm('¿Desea eliminar este recurso?');">Eliminar</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay recursos disponibles.</p>
<?php endif; ?>

<?php
// Función para convertir un link normal de Drive a link de preview para iframe
function convertirLinkDrive($link) {
    if (strpos($link, "drive.google.com") !== false) {
        if (preg_match("/\/d\/(.*?)\/view/", $link, $matches)) {
            return "https://drive.google.com/file/d/".$matches[1]."/preview";
        }
    }
    return $link; // Si no es un link de Drive, devuelve el link original
}
?>
