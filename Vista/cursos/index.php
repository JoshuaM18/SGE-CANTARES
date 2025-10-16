<!DOCTYPE html>
<html>
<head>
    <title>Listado de Cursos</title>
</head>
<body>
    <h1>Cursos</h1>
    <a href="index.php?c=Curso&a=nuevo">Agregar Nuevo Curso</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Descripción</th>
                <th>Créditos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cursos as $c): ?>
            <tr>
                <td><?= $c['id_curso'] ?></td>
                <td><?= $c['nombre_curso'] ?></td>
                <td><?= $c['nombre_carrera'] ?></td>
                <td><?= $c['descripcion'] ?></td>
                <td><?= $c['creditos'] ?></td>
                <td>
                    <a href="index.php?c=Curso&a=editar&id=<?= $c['id_curso'] ?>">Editar</a> |
                    <a href="index.php?c=Curso&a=eliminar&id=<?= $c['id_curso'] ?>" onclick="return confirm('¿Eliminar curso?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>
