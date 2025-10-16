<h1>Editar Asignación de Docente a Curso</h1>
<form action="index.php?c=CursoDocente&a=actualizar" method="POST">
    <input type="hidden" name="id_asignacion" value="<?= $asignacion['id_asignacion'] ?>">

    <label>Curso:</label>
    <select name="id_curso" required>
        <?php foreach($cursos as $c): ?>
            <option value="<?= $c['id_curso'] ?>" <?= $c['id_curso'] == $asignacion['id_curso'] ? 'selected' : '' ?>>
                <?= $c['nombre_curso'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Docente:</label>
    <select name="id_docente" required>
        <?php foreach($docentes as $d): ?>
            <option value="<?= $d['id_docente'] ?>" <?= $d['id_docente'] == $asignacion['id_docente'] ? 'selected' : '' ?>>
                <?= $d['nombres'] . ' ' . $d['apellidos'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Año Académico:</label>
    <input type="number" name="anio_academico" min="2000" max="2100" value="<?= $asignacion['anio_academico'] ?>" required><br><br>

    <label>Semestre:</label>
    <select name="semestre" required>
        <option value="1" <?= $asignacion['semestre']=='1' ? 'selected' : '' ?>>1</option>
        <option value="2" <?= $asignacion['semestre']=='2' ? 'selected' : '' ?>>2</option>
    </select><br><br>

    <button type="submit">Actualizar</button>
</form>
<a href="index.php?c=CursoDocente&a=index">Volver al listado</a>
