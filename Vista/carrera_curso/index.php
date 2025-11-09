<head>
    <link rel="stylesheet" href="css/carrera.css">
</head>
<h1>Asignaciones de Cursos a Carreras</h1>
<a href="index.php?c=CarreraCurso&a=nuevo">Nueva Asignación</a><br><br>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Curso</th>
        <th>Carrera</th>
        <th>Docente</th>
        <th>Año Académico</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($asignaciones as $a): ?>
        <tr>
            <td><?= $a['id_asignacion'] ?></td>
            <td><?= htmlspecialchars($a['nombre_curso']) ?></td>
            <td><?= htmlspecialchars($a['nombre_carrera']) ?></td>
            <td><?= htmlspecialchars($a['docente_nombres'].' '.$a['docente_apellidos']) ?></td>
            <td><?= $a['anio_academico'] ?></td>
            <td>
                <a href="index.php?c=CarreraCurso&a=editar&id=<?= $a['id_asignacion'] ?>">Editar</a> |
                <a href="index.php?c=CarreraCurso&a=eliminar&id=<?= $a['id_asignacion'] ?>" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
