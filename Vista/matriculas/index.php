<h1>Matrículas de Estudiantes</h1>

<a href="index.php?c=Matricula&a=nuevo">Nueva Matrícula</a>
<br><br>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Estudiante</th>
        <th>Curso</th>
        <th>Docente</th>
        <th>Año Académico</th>
        <th>Semestre</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php if(!empty($matriculas)): ?>
        <?php foreach($matriculas as $m): ?>
            <tr>
                <td><?= $m['id_matricula'] ?></td>
                <td><?= htmlspecialchars($m['estudiante_nombres'].' '.$m['estudiante_apellidos']) ?></td>
                <td><?= htmlspecialchars($m['nombre_curso']) ?></td>
                <td><?= htmlspecialchars($m['docente_nombres'].' '.$m['docente_apellidos']) ?></td>
                <td><?= $m['anio_academico'] ?></td>
                <td><?= $m['semestre'] ?></td>
                <td><?= $m['estado'] ?></td>
                <td>
                    <a href="index.php?c=Matricula&a=editar&id=<?= $m['id_matricula'] ?>">Editar</a> |
                    <a href="index.php?c=Matricula&a=eliminar&id=<?= $m['id_matricula'] ?>" onclick="return confirm('¿Eliminar esta matrícula?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No hay matrículas registradas.</td>
        </tr>
    <?php endif; ?>
</table>
