<h1>Nueva Calificación</h1>
<form action="index.php?c=Calificacion&a=guardar" method="POST">
    <label>Matrícula:</label>
    <select name="id_matricula" required>
        <option value="">-- Selecciona una matrícula --</option>
        <?php foreach($matriculas as $m): ?>
            <option value="<?= $m['id_matricula'] ?>">
                <?= $m['nombres'].' '.$m['apellidos'] ?> - <?= $m['nombre_curso'] ?> - Año: <?= $m['anio_academico'] ?> - Semestre: <?= $m['semestre'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Nota:</label>
    <input type="number" step="0.01" name="nota" min="0" max="100" required>
    <br><br>

    <label>Observaciones:</label>
    <textarea name="observaciones"></textarea>
    <br><br>

    <button type="submit">Guardar Calificación</button>
</form>
<br>
<a href="index.php?c=Calificacion&a=index">Volver al listado</a>
