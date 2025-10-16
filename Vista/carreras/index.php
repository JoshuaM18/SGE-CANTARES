<!DOCTYPE html>
<html>
<head>
    <title>Listado de Carreras</title>
</head>
<body>
    <h1>Carreras</h1>
    <a href="index.php?c=Carrera&a=nuevo">Agregar Nueva Carrera</a>
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
            <?php foreach($carreras as $c): ?>
            <tr>
                <td><?= $c['id_carrera'] ?></td>
                <td><?= $c['nombre_carrera'] ?></td>
                <td><?= $c['descripcion'] ?></td>
                <td>
                    <a href="index.php?c=Carrera&a=editar&id=<?= $c['id_carrera'] ?>">Editar</a> |
                    <a href="index.php?c=Carrera&a=eliminar&id=<?= $c['id_carrera'] ?>" onclick="return confirm('¿Eliminar carrera?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Volver al menú</a>
</body>
</html>
