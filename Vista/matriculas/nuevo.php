<h1>Nueva Matrícula</h1>

<form action="index.php?c=Matricula&a=guardar" method="POST">
    <!-- Selección de Estudiante -->
    <label>Estudiante:</label>
    <select name="id_estudiante" required>
        <option value="">-- Selecciona un estudiante --</option>
        <?php if(!empty($estudiantes)): ?>
            <?php foreach($estudiantes as $e): ?>
                <option value="<?= $e['id_estudiante'] ?>">
                    <?= htmlspecialchars($e['nombres'].' '.$e['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay estudiantes disponibles</option>
        <?php endif; ?>
    </select>
    <br><br>

    <!-- Selección de Curso / Asignación -->
    <label>Curso / Asignación:</label>
    <select name="id_asignacion" required>
        <option value="">-- Selecciona un curso --</option>
        <?php if(!empty($cursos)): ?>
            <?php foreach($cursos as $c): ?>
                <option value="<?= $c['id_asignacion'] ?>">
                    <?= htmlspecialchars($c['nombre_curso']) ?> (<?= htmlspecialchars($c['nombre_carrera']) ?>) 
                    - Docente: <?= htmlspecialchars($c['docente_nombres'].' '.$c['docente_apellidos']) ?> 
                    - Año: <?= $c['anio_academico'] ?> 
                    - Semestre: <?= $c['semestre'] ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay cursos disponibles</option>
        <?php endif; ?>
    </select>
    <br><br>

    <!-- Selección de Estado de la Matrícula -->
    <label>Estado:</label>
    <select name="estado" required>
        <option value="Inscrito">Inscrito</option>
        <option value="Retirado">Retirado</option>
        <option value="Aprobado">Aprobado</option>
        <option value="Reprobado">Reprobado</option>
    </select>
    <br><br>

    <button type="submit">Guardar Matrícula</button>
</form>

<br>
<a href="index.php?c=Matricula&a=index">Volver al listado</a>
