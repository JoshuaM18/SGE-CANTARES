<head>
    <link rel="stylesheet" href="css/matriculas.css">
</head>
<h1>Editar Matrícula</h1>

<?php if ($matricula && !empty($estudiantes) && !empty($cursos)): ?>
<form action="index.php?c=Matricula&a=actualizar" method="POST">
    <input type="hidden" name="id_matricula" value="<?= $matricula['id_matricula'] ?>">

    <label>Estudiante:</label>
    <select name="id_estudiante" required>
        <?php foreach($estudiantes as $e): ?>
            <option value="<?= $e['id_estudiante'] ?>" 
                <?= $e['id_estudiante'] == $matricula['id_estudiante'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['nombres'].' '.$e['apellidos']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Curso / Asignación:</label>
    <select name="id_asignacion" required>
        <?php foreach($cursos as $c): ?>
            <option value="<?= $c['id_asignacion'] ?>" 
                <?= $c['id_asignacion'] == $matricula['id_asignacion'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nombre_curso'] . ' (' . $c['nombre_carrera'] . ')') ?> 
                - Docente: <?= htmlspecialchars($c['docente_nombres'].' '.$c['docente_apellidos']) ?> 
                - Año: <?= $c['anio_academico'] ?>
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
<?php else: ?>
    <p>Error: No se pudo cargar la matrícula, estudiantes o cursos.</p>
<?php endif; ?>

<br>
<a href="index.php?c=Matricula&a=index">Volver al listado</a>
