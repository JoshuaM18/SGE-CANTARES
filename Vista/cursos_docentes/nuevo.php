<head>
     <link rel="stylesheet" href="css/cdocente.css">
</head>
<h1>Nueva Asignación de Docente a Cursos</h1>

<form action="index.php?c=CursoDocente&a=guardarMultiple" method="POST">
    <label>Docente:</label>
    <select name="id_docente" required>
        <?php foreach($docentes as $d): ?>
            <option value="<?= $d['id_docente'] ?>"><?= htmlspecialchars($d['nombres'].' '.$d['apellidos']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Año Académico:</label>
    <input type="number" name="anio_academico" min="2000" max="2100" required><br><br>

    <h3>Seleccione los cursos a asignar:</h3>

    <?php
    $ultimaCarrera = null;
    $ultimoGrado = null;

    foreach($cursos as $c):
        // Agrupar por carrera
        if ($ultimaCarrera !== $c['id_carrera']):
            if ($ultimaCarrera !== null) echo "</div>"; // cerrar carrera anterior
            echo "<div style='margin-bottom:20px;'>";
            echo "<h2 onclick=\"this.nextElementSibling.style.display = (this.nextElementSibling.style.display == 'none' ? 'block' : 'none');\" style='cursor:pointer;'>
                    Carrera: " . htmlspecialchars($c['nombre_carrera']) . "</h2>";
            echo "<div style='display:none; margin-left:20px;'>"; // contenedor de cursos por carrera
            $ultimaCarrera = $c['id_carrera'];
            $ultimoGrado = null;
        endif;

        // Agrupar por grado
        if ($ultimoGrado !== $c['grado']):
            if ($ultimoGrado !== null) echo "</div>"; // cerrar grado anterior
            echo "<h3 onclick=\"this.nextElementSibling.style.display = (this.nextElementSibling.style.display == 'none' ? 'block' : 'none');\" style='cursor:pointer; margin-left:10px;'>
                    Grado: " . htmlspecialchars($c['grado']) . "</h3>";
            echo "<div style='display:none; margin-left:30px;'>"; // contenedor de cursos por grado
            $ultimoGrado = $c['grado'];
        endif;
        ?>
        <div>
            <input type="checkbox" name="id_curso[]" value="<?= $c['id_curso'] ?>">
            <?= htmlspecialchars($c['nombre_curso']) ?>
        </div>
    <?php
    endforeach;
    if ($ultimoGrado !== null) echo "</div>";
    if ($ultimaCarrera !== null) echo "</div>";
    ?>

    <br>
    <button type="submit">Guardar Asignaciones</button>
</form>

<a href="index.php?c=CursoDocente&a=index">Volver al listado</a>
