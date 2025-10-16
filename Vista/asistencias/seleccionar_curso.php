<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Curso</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f9f9f9; 
        }
        h1 { 
            color: #333; 
        }
        table {
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 15px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left;
        }
        th {
            background-color: #007BFF; 
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none; 
            color: #007BFF; 
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .volver {
            display: inline-block;
            margin-top: 20px;
            color: white;
            background-color: #28a745;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .volver:hover {
            background-color: #218838;
        }
    </style>
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
