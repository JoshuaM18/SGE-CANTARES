<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="css/estilos_tareas.css">
</head>

<h1>Lista de Tareas</h1>

<?php if ($_SESSION['usuario']['rol'] === 'Docente'): ?>
    <!-- Seleccionar curso/carrera -->
    <form method="get" style="margin-bottom:20px;">
    <input type="hidden" name="c" value="Tarea">
    <input type="hidden" name="a" value="listar">
    <label for="id_asignacion"><strong>Seleccionar Curso/Carrera:</strong></label><br>
    <select name="id_asignacion" id="id_asignacion" onchange="this.form.submit();">
        <?php
        // Obtener id_docente real
        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocentePorUsuario($id_usuario);
        $cursos_docente = $this->modelo->obtenerCursosPorDocente($id_docente);
        foreach ($cursos_docente as $curso):
            $selected = ($curso['id_asignacion'] == $id_asignacion) ? 'selected' : '';
        ?>
            <option value="<?= $curso['id_asignacion'] ?>" <?= $selected ?>>
                <?= htmlspecialchars($curso['nombre_curso']) ?> - <?= htmlspecialchars($curso['nombre_carrera']) ?> 
                (Año: <?= $curso['anio_academico'] ?>, Semestre: <?= $curso['semestre'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php endif; ?>

<?php if (!empty($tareas)): ?>
    <!-- Información del curso y carrera -->
    <div class="info-curso" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; border-radius: 8px; background: #f9f9f9;">
        <strong>Curso:</strong> <?= htmlspecialchars($tareas[0]['nombre_curso']) ?><br>
        <strong>Carrera:</strong> <?= htmlspecialchars($tareas[0]['nombre_carrera']) ?><br>
        <strong>Año:</strong> <?= htmlspecialchars($tareas[0]['anio_academico']) ?><br>
        <strong>Semestre:</strong> <?= htmlspecialchars($tareas[0]['semestre']) ?>
    </div>
<?php endif; ?>

<!-- Botón de crear tarea solo para docentes -->
<?php if ($_SESSION['usuario']['rol'] === 'Docente' && $id_asignacion): ?>
    <a href="index.php?c=Tarea&a=crear&id_asignacion=<?= $id_asignacion ?>">+ Crear Nueva Tarea</a>
    <br><br>
<?php endif; ?>

<?php if (!empty($tareas)): ?>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha Publicación</th>
                <th>Fecha Entrega</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tareas as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['titulo']) ?></td>
                    <td><?= htmlspecialchars($t['descripcion']) ?></td>
                    <td><?= $t['fecha_publicacion'] ?></td>
                    <td><?= $t['fecha_entrega'] ?></td>
                    <td>
                        <?php if ($_SESSION['usuario']['rol'] === 'Estudiante'): ?>
                            <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $t['id_tarea'] ?>&id_asignacion=<?= $id_asignacion ?>">Entregar</a>
                        <?php elseif ($_SESSION['usuario']['rol'] === 'Docente'): ?>
                            <a href="index.php?c=Tarea&a=calificar&id_tarea=<?= $t['id_tarea'] ?>&id_asignacion=<?= $id_asignacion ?>">Calificar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay tareas creadas para este curso.</p>
<?php endif; ?>

<br>
<a href="index.php">Volver al menú principal</a>
