<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos Asignados</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Cursos Asignados</h1>

    <?php if(!empty($cursos)): ?>
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Año Académico</th>
                    <th>Semestre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cursos as $curso): ?>
                    <tr>
                        <td><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                        <td><?= htmlspecialchars($curso['anio_academico']) ?></td>
                        <td><?= htmlspecialchars($curso['semestre']) ?></td>
                        <td>
                            <a href="index.php?c=Calificacion&a=ingresarNotas&id_asignacion=<?= $curso['id_asignacion'] ?>">Ingresar Notas</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes cursos asignados.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>
