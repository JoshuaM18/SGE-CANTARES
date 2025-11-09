<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/calificaciones.css">
</head>
<body>
    <h1>Ingresar Notas</h1>

    <?php if(!empty($notas)): ?>
        <?php 
            $curso_nombre = $notas[0]['nombre_curso'];
            $anio_academico = $notas[0]['anio_academico'];
        ?>
        <div class="info-curso">
            Curso: <?= htmlspecialchars($curso_nombre) ?> - Año: <?= $anio_academico ?>
        </div>

        <form action="index.php?c=Calificacion&a=guardarBimestre" method="post">
            <label>Seleccione Bimestre:</label>
            <select name="bimestre" required>
                <option value="1">Bimestre 1</option>
                <option value="2">Bimestre 2</option>
                <option value="3">Bimestre 3</option>
                <option value="4">Bimestre 4</option>
            </select>

            <table>
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>B1</th>
                        <th>B2</th>
                        <th>B3</th>
                        <th>B4</th>
                        <th>Promedio</th>
                        <th>Observaciones</th>
                        <th>Nota a Ingresar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($notas as $n): ?>
                        <tr>
                            <td><?= htmlspecialchars($n['nombre_estudiante']) ?></td>
                            <td><?= $n['nota_b1'] ?></td>
                            <td><?= $n['nota_b2'] ?></td>
                            <td><?= $n['nota_b3'] ?></td>
                            <td><?= $n['nota_b4'] ?></td>
                            <td><?= number_format($n['nota_final'], 2) ?></td>
                            <td><?= htmlspecialchars($n['observaciones']) ?></td>
                            <td>
                                <input type="hidden" name="id_matricula[]" value="<?= $n['id_matricula'] ?>">
                                <input type="number" step="0.01" name="nota[]" placeholder="Nueva nota">
                                <input type="text" name="observaciones[]" placeholder="Observación">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit">Guardar Notas</button>
        </form>
    <?php else: ?>
        <p>No hay estudiantes asignados a este curso.</p>
    <?php endif; ?>

    <br>
    <a href="index.php?c=Calificacion&a=index">Volver a Cursos Asignados</a>
</body>
</html>
