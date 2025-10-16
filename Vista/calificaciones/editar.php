<h1>Editar Calificación</h1>
<form action="index.php?c=Calificacion&a=actualizar" method="POST">
    <input type="hidden" name="id_calificacion" value="<?= $calificacion['id_calificacion'] ?>">

    <label>Matrícula:</label>
    <select name="id_matricula" required>
        <?php foreach($matriculas as $m): ?>
            <option value="<?= $m['id_matricula'] ?>" <?= $m['id_matricula'] == $calificacion['id_matricula'] ? 'selected' : '' ?>>
                <?= $m['nombres'].' '.$m['apellidos'] ?> - <?= $m['nombre_curso'] ?> - Año: <?= $m['anio_academico'] ?> - Semestre: <?= $m['semestre'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Nota:</label>
    <input type="number" step="0.01" name="nota" min="0" max="100" value="<?= $calificacion['nota'] ?>" required>
    <br><br>

    <label>Observaciones:</label>
    <textarea name="observaciones"><?= $calificacion['observaciones'] ?></textarea>
    <br><br>

    <button type="submit">Actualizar Calificación</button>
</form>
<br>
<a href="index.php?c=Calificacion&a=index">Volver al listado</a>
