<h1>Nueva Asignación de Docente a Curso</h1>
<form action="index.php?c=CursoDocente&a=guardar" method="POST">
    <label>Curso:</label>
    <select name="id_curso" required>
        <?php foreach($cursos as $c): ?>
            <option value="<?= $c['id_curso'] ?>"><?= $c['nombre_curso'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Docente:</label>
    <select name="id_docente" required>
        <?php foreach($docentes as $d): ?>
            <option value="<?= $d['id_docente'] ?>"><?= $d['nombres'].' '.$d['apellidos'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Año Académico:</label>
    <input type="number" name="anio_academico" min="2000" max="2100" required><br><br>

    <label>Semestre:</label>
    <select name="semestre" required>
        <option value="1">1</option>
        <option value="2">2</option>
    </select><br><br>

    <button type="submit">Guardar</button>
</form>
<a href="index.php?c=CursoDocente&a=index">Volver al listado</a>
