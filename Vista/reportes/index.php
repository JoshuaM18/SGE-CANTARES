<h2>📊 Módulo de Reportes</h2>
<p>Seleccione el reporte que desea generar:</p>
<ul>

    <!-- Notas por estudiante -->
    <li>
        <form action="index.php?c=Reporte&a=notasPorEstudiante" method="GET">
            <label>Estudiante:</label>
            <select name="id_estudiante" required>
                <option value="">-- Seleccione un estudiante --</option>
                <?php foreach($estudiantes as $e): ?>
                    <option value="<?= $e['id_estudiante'] ?>"><?= $e['nombres'] ?> <?= $e['apellidos'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Generar PDF</button>
        </form>
    </li>

    <!-- Asistencia mensual -->
    <li>
        <form action="index.php?c=Reporte&a=asistenciaMensual" method="GET">
            <label>Mes:</label>
            <select name="mes" required>
                <option value="">-- Mes --</option>
                <?php for($m=1; $m<=12; $m++): ?>
                    <option value="<?= $m ?>"><?= $m ?></option>
                <?php endfor; ?>
            </select>

            <label>Año:</label>
            <select name="anio" required>
                <option value="">-- Año --</option>
                <?php
                $anio_actual = date('Y');
                for ($y = $anio_actual; $y >= 2000; $y--): ?>
                    <option value="<?= $y ?>"><?= $y ?></option>
                <?php endfor; ?>
            </select>

            <button type="submit">Generar PDF</button>
        </form>
    </li>

    <!-- Docentes por carrera -->
    <li>
        <form action="index.php?c=Reporte&a=docentesPorCarrera" method="GET">
            <label>Carrera:</label>
            <select name="id_carrera" required>
                <option value="">-- Seleccione una carrera --</option>
                <?php foreach($carreras as $c): ?>
                    <option value="<?= $c['id_carrera'] ?>"><?= $c['nombre_carrera'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Generar PDF</button>
        </form>
    </li>

    <!-- Matrículas por curso -->
    <li>
        <form action="index.php?c=Reporte&a=matriculasPorCurso" method="GET">
            <label>Curso:</label>
            <select name="id_curso" required>
                <option value="">-- Seleccione un curso --</option>
                <?php foreach($cursos as $curso): ?>
                    <option value="<?= $curso['id_curso'] ?>"><?= $curso['nombre_curso'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Generar PDF</button>
        </form>
    </li>
    <li>
        <a href="index.php?c=TestPDF&a=generar">Generar PDF de Prueba</a>

    </li>

</ul>
