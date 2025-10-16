<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Asistencia por Día</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        input[type="date"] { padding: 5px; }
        button { padding: 5px 10px; margin-left: 5px; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Historial de Asistencia por Día</h1>

    <!-- Selector de fecha -->
    <form action="index.php" method="get">
        <input type="hidden" name="c" value="Asistencia">
        <input type="hidden" name="a" value="historialPorDia">
        <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">
        <label>Fecha: <input type="date" name="fecha" value="<?= $fecha ?>"></label>
        <button type="submit">Ver Historial</button>
    </form>

    <br>

    <?php if ($cursoSeleccionado): ?>
    <div class="info-curso">
        <strong>Curso:</strong> <?= htmlspecialchars($cursoSeleccionado['nombre_curso']) ?><br>
        <strong>Carrera:</strong> <?= htmlspecialchars($cursoSeleccionado['nombre_carrera']) ?><br>
        <strong>Año:</strong> <?= htmlspecialchars($cursoSeleccionado['anio_academico']) ?><br>
        <strong>Semestre:</strong> <?= htmlspecialchars($cursoSeleccionado['semestre']) ?>
    </div>
<?php endif; ?>


    <?php if(!empty($asistencias)): ?>
        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($asistencias as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['nombres'] . ' ' . $a['apellidos']) ?></td>
                        <td><?= htmlspecialchars($a['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay registros de asistencia para esta fecha.</p>
    <?php endif; ?>

    <br>
    <a href="index.php?c=Asistencia&a=index&id_asignacion=<?= $id_asignacion ?>">Volver al curso</a>
</body>
</html>
