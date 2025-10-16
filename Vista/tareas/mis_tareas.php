<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas</title>
    <link rel="stylesheet" href="css/estilos_tareas.css">
</head>
<body>
<h1>Mis Tareas</h1>

<?php if (!empty($tareas)): ?>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Curso</th>
                <th>Carrera</th>
                <th>Año</th>
                <th>Semestre</th>
                <th>Fecha de Entrega</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tareas as $tarea): ?>
                <tr>
                    <td><?= htmlspecialchars($tarea['titulo']) ?></td>
                    <td><?= htmlspecialchars($tarea['nombre_curso']) ?></td>
                    <td><?= htmlspecialchars($tarea['nombre_carrera']) ?></td>
                    <td><?= htmlspecialchars($tarea['anio_academico']) ?></td>
                    <td><?= htmlspecialchars($tarea['semestre']) ?></td>
                    <td><?= htmlspecialchars($tarea['fecha_entrega']) ?></td>
                    <td>
                        <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $tarea['id_tarea'] ?>&id_asignacion=<?= $tarea['id_asignacion'] ?>">Entregar Tarea</a>
                    </td>

              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>No tienes tareas asignadas.</p>
<?php endif; ?>
</body>
</html>
