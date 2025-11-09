<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Asistencia por Día</title>
     <link rel="stylesheet" href="css/asistencia.css">
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
