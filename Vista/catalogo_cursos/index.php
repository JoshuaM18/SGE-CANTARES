<?php $cursos = $cursos ?? []; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Cursos</title>
</head>
<body>
    <h1>Catálogo de Cursos</h1>
    <a href="index.php?c=CatalogoCurso&a=nuevo">Agregar Nuevo Curso</a><br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cursos)): ?>
                <?php foreach($cursos as $c): ?>
                <tr>
                    <td><?= $c['id_catalogo_curso'] ?></td>
                    <td><?= $c['nombre_curso'] ?></td>
                    <td><?= $c['descripcion'] ?></td>
                    <td>
                        <a href="index.php?c=CatalogoCurso&a=editar&id=<?= $c['id_catalogo_curso'] ?>">Editar</a> |
                        <a href="index.php?c=CatalogoCurso&a=eliminar&id=<?= $c['id_catalogo_curso'] ?>" onclick="return confirm('¿Eliminar curso del catálogo?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay cursos en el catálogo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
