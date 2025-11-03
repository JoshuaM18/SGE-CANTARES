<h1>Notas del Estudiante</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Curso</th>
        <th>Año Académico</th>
        <th>B1</th>
        <th>B2</th>
        <th>B3</th>
        <th>B4</th>
        <th>Promedio</th>
        <th>Observaciones</th>
    </tr>
    <?php foreach($notas as $n): ?>
    <tr>
        <td><?= $n['nombre_curso'] ?></td>
        <td><?= $n['anio_academico'] ?></td>
        <td><?= $n['nota_b1'] ?></td>
        <td><?= $n['nota_b2'] ?></td>
        <td><?= $n['nota_b3'] ?></td>
        <td><?= $n['nota_b4'] ?></td>
        <td><?= number_format($n['nota_final'],2) ?></td>
        <td><?= $n['observaciones'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php">Volver al menú</a>
