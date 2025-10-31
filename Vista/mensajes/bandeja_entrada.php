<h2>Bandeja de Entrada</h2>
<a href="index.php?c=Mensaje&a=nuevo">Nuevo mensaje</a>
<table border="1">
<tr><th>Remitente</th><th>Asunto</th><th>Fecha</th></tr>
<?php foreach ($mensajes as $m): ?>
<tr>
    <td><?= $m['remitente'] ?></td>
    <td><a href="index.php?c=Mensaje&a=ver&id_mensaje=<?= $m['id_mensaje'] ?>"><?= htmlspecialchars($m['asunto']) ?></a></td>
    <td><?= $m['fecha'] ?></td>
</tr>
<?php endforeach; ?>
</table>
