<h1>Notas del Estudiante</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Curso</th>
        <th>Año Académico</th>
        <th>Semestre</th>
        <th>Nota</th>
        <th>Observaciones</th>
    </tr>
    <?php foreach($notas as $n): ?>
    <tr>
        <td><?= $n['nombre_curso'] ?></td>
        <td><?= $n['anio_academico'] ?></td>
        <td><?= $n['semestre'] ?></td>
        <td><?= $n['nota'] ?></td>
        <td><?= $n['observaciones'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php">Volver al menú</a>
