<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Asistencia</title>
    <link rel="stylesheet" href="css/asistencia.css">
</head>
<body>
    <h1>Registro de Asistencia</h1>

    <?php if (!isset($id_asignacion)): ?>
        <h2>Seleccione un curso</h2>
        <?php if (!empty($cursos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Carrera</th>
                        <th>Año</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                            <td><?= htmlspecialchars($curso['nombre_carrera']) ?></td>
                            <td><?= htmlspecialchars($curso['anio_academico']) ?></td>
                            <td>
                                <a href="index.php?c=Asistencia&a=index&id_asignacion=<?= $curso['id_asignacion'] ?>">
                                    Registrar asistencia
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes cursos asignados.</p>
        <?php endif; ?>
    <?php else: ?>
        <h2><?= htmlspecialchars($cursoSeleccionado['nombre_curso']) ?> - <?= htmlspecialchars($cursoSeleccionado['nombre_carrera']) ?></h2>
        <form method="post" action="index.php?c=Asistencia&a=guardar">
            <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">
            <label>Fecha:
                <input type="date" name="fecha" value="<?= date('Y-m-d') ?>">
            </label>
            <table>
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $e): ?>
                        <tr>
                            <td><?= htmlspecialchars($e['nombres'] . ' ' . $e['apellidos']) ?></td>
                            <td>
                                <select name="estado[<?= $e['id_matricula'] ?>]">
                                    <option value="Presente">Presente</option>
                                    <option value="Ausente">Ausente</option>
                                    <option value="Justificado">Justificado</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Guardar Asistencia</button>
        </form>

        <a href="index.php?c=Asistencia&a=historialPorDia&id_asignacion=<?= $id_asignacion ?>">Ver historial por día</a>
    <?php endif; ?>

    <br><br>
    <a href="index.php">Volver al menú principal</a>
</body>
</html>
