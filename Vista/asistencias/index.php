<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Asistencia</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        select, input[type="date"], button { padding: 5px; margin-top: 5px; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
        .curso-selector { margin-bottom: 20px; }
        .info-curso {
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .form-inline { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Registrar Asistencia</h1>

    <!-- Selector de curso -->
    <div class="curso-selector">
        <form action="index.php" method="get">
            <input type="hidden" name="c" value="Asistencia">
            <input type="hidden" name="a" value="index">
            <label for="id_asignacion">Seleccione Curso: </label>
            <select name="id_asignacion" id="id_asignacion" onchange="this.form.submit()">
                <option value="">-- Elegir curso --</option>
                <?php foreach($cursos as $curso): ?>
                    <option value="<?= $curso['id_asignacion'] ?>" <?= ($id_asignacion == $curso['id_asignacion']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars(
                            $curso['nombre_curso'] . 
                            " - Carrera: " . $curso['nombre_carrera'] . 
                            " - Año: " . $curso['anio_academico'] . 
                            " - Semestre: " . $curso['semestre']
                        ) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <?php if($id_asignacion): ?>
        <?php if(!empty($cursos)): ?>
            <?php 
                $cursoSeleccionado = null;
                foreach ($cursos as $curso) {
                    if ($curso['id_asignacion'] == $id_asignacion) {
                        $cursoSeleccionado = $curso;
                        break;
                    }
                }
            ?>
            <?php if ($cursoSeleccionado): ?>
                <div class="info-curso">
                    <strong>Curso:</strong> <?= htmlspecialchars($cursoSeleccionado['nombre_curso']) ?><br>
                    <strong>Carrera:</strong> <?= htmlspecialchars($cursoSeleccionado['nombre_carrera']) ?><br>
                    <strong>Año:</strong> <?= htmlspecialchars($cursoSeleccionado['anio_academico']) ?><br>
                    <strong>Semestre:</strong> <?= htmlspecialchars($cursoSeleccionado['semestre']) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Tabla de estudiantes -->
        <?php if(!empty($estudiantes)): ?>
            <form action="index.php?c=Asistencia&a=guardar" method="post">
                <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">
                <div class="form-inline">
                    <label>Fecha: <input type="date" name="fecha" value="<?= date('Y-m-d') ?>"></label>
                    <button type="submit">Guardar Asistencia</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($estudiantes as $e): ?>
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
            </form>

            <!-- Botón para historial -->
           <!-- Botón para historial por día -->
<form action="index.php" method="get" style="margin-top: 15px;">
    <input type="hidden" name="c" value="Asistencia">
    <input type="hidden" name="a" value="historialPorDia">
    <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">
    <label>Fecha: <input type="date" name="fecha" value="<?= date('Y-m-d') ?>"></label>
    <button type="submit">Ver Historial por Día</button>
</form>



        <?php else: ?>
            <p>No hay estudiantes asignados a este curso.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Seleccione un curso para registrar la asistencia.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">Volver al menú principal</a>
</body>
</html>
