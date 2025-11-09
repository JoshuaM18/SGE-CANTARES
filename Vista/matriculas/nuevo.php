<head>
    <link rel="stylesheet" href="css/matriculas.css">
</head>
<h1>Nueva Matrícula de Estudiante</h1>

<form action="index.php?c=Matricula&a=guardar" method="POST">

    <label>Estudiante:</label>
    <select name="id_estudiante" required>
        <?php foreach($estudiantes as $e): ?>
            <option value="<?= $e['id_estudiante'] ?>">
                <?= htmlspecialchars($e['nombres'].' '.$e['apellidos']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Carrera:</label>
    <select name="id_carrera" required>
        <?php foreach($carreras as $c): ?>
            <option value="<?= $c['id_carrera'] ?>">
                <?= htmlspecialchars($c['nombre_carrera']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Año Académico:</label>
    <input type="number" name="anio_academico" min="2000" max="2100" value="<?= date('Y') ?>" required>
    <br><br>

    <label>Estado:</label>
    <select name="estado">
        <?php 
        $estados = ['Inscrito','Retirado','Aprobado','Reprobado'];
        foreach($estados as $estado): 
        ?>
            <option value="<?= $estado ?>"><?= $estado ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Guardar Matrícula</button>
</form>

<br>
<a href="index.php?c=Matricula&a=index">Volver al listado</a>
