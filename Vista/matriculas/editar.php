<h1>Editar Matrícula</h1>
<form action="index.php?c=Matricula&a=actualizar" method="POST">
    <input type="hidden" name="id_matricula" value="<?= $matricula['id_matricula'] ?>">

    <label>Estudiante:</label>
    <select name="id_estudiante" required>
        <?php foreach($estudiantes as $e): ?>
            <option value="<?= $e['id_estudiante'] ?>" 
                <?= $e['id_estudiante'] == $matricula['id_estudiante'] ? 'selected' : '' ?>>
                <?= $e['nombres'].' '.$e['apellidos'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Curso / Asignación:</label>
    <select name="id_asignacion" required>
        <?php foreach($cursos as $c): ?>
            <option value="<?= $c['id_asignacion'] ?>" 
                <?= $c['id_asignacion'] == $matricula['id_asignacion'] ? 'selected' : '' ?>>
                <?= $c['nombre_curso'] ?> (<?= $c['nombre_carrera'] ?>) 
                - Docente: <?= $c['docente_nombres'].' '.$c['docente_apellidos'] ?> 
                - Año: <?= $c['anio_academico'] ?> 
                - Semestre: <?= $c['semestre'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Estado:</label>
    <select name="estado">
        <?php 
        $estados = ['Inscrito','Retirado','Aprobado','Reprobado'];
        foreach($estados as $estado): 
        ?>
            <option value="<?= $estado ?>" <?= $estado == $matricula['estado'] ? 'selected' : '' ?>>
                <?= $estado ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Actualizar Matrícula</button>
</form>
<br>
<a href="index.php?c=Matricula&a=index">Volver al listado</a>
