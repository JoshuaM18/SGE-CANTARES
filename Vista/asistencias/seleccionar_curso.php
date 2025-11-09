<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Curso</title>
    <link rel="stylesheet" href="css/asistencia.css">
</head>
<body>
    <h1>Cursos Asignados</h1>

    <?php if (!empty($cursos)): ?>
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Carrera</th>
                    <th>Año Académico</th>
                    <th>Semestre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nombre_curso']) ?></td>
                        <td><?= htmlspecialchars($c['nombre_carrera']) ?></td>
                        <td><?= htmlspecialchars($c['anio_academico']) ?></td>
                        <td><?= htmlspecialchars($c['semestre']) ?></td>
                        <td>
                            <a href="index.php?c=Asistencia&a=index&id_asignacion=<?= $c['id_asignacion'] ?>">
                                Registrar Asistencia
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes cursos asignados.</p>
    <?php endif; ?>

    <a href="index.php" class="volver">Volver al menú</a>
</body>
</html>
