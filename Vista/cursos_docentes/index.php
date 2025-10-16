<h1>Asignaciones de Docentes a Cursos</h1>
<a href="index.php?c=CursoDocente&a=nuevo">Nueva Asignación</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Curso</th>
        <th>Docente</th>
        <th>Año Académico</th>
        <th>Semestre</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($asignaciones as $a): ?>
    <tr>
        <td><?= $a['id_asignacion'] ?></td>
        <td><?= $a['nombre_curso'] ?></td>
        <td><?= $a['nombres'].' '.$a['apellidos'] ?></td>
        <td><?= $a['anio_academico'] ?></td>
        <td><?= $a['semestre'] ?></td>
        <td>
            <a href="index.php?c=CursoDocente&a=editar&id=<?= $a['id_asignacion'] ?>">Editar</a> |
            <a href="index.php?c=CursoDocente&a=eliminar&id=<?= $a['id_asignacion'] ?>" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
