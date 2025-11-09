<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos Asignados</title>
    <link rel="stylesheet" href="css/calificaciones.css">
</head>
<body>
    <h1>Cursos Asignados</h1>

    <?php if(!empty($cursos)): ?>

        <?php
        // Agrupar cursos por carrera (grado)
        $cursos_por_carrera = [];
        foreach ($cursos as $curso) {
            $carrera = $curso['nombre_carrera'] ?? 'Sin Grado';
            if (!isset($cursos_por_carrera[$carrera])) {
                $cursos_por_carrera[$carrera] = [];
            }
            $cursos_por_carrera[$carrera][] = $curso;
        }
        ?>

        <?php foreach ($cursos_por_carrera as $carrera => $cursos_grado): ?>
            <h2><?= htmlspecialchars($carrera) ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Año Académico</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos_grado as $curso): ?>
                        <tr>
                            <td><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                            <td><?= htmlspecialchars($curso['anio_academico']) ?></td>
                            <td>
                                <a href="index.php?c=Calificacion&a=ingresarNotas&id_asignacion=<?= $curso['id_asignacion'] ?>">Ingresar Notas</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

    <?php else: ?>
        <p>No tienes cursos asignados.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>
