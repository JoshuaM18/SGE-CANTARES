<!DOCTYPE html>
<html>
<head>
    <title>Listado de Padres</title>
</head>
<body>
    <h1>Listado de Padres</h1>
    <a href="index.php?c=Padre&a=nuevo">Agregar Padre</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($padres as $p): ?>
        <tr>
            <td><?php echo $p['id_padre']; ?></td>
            <td><?php echo $p['nombre_usuario']; ?></td>
            <td><?php echo $p['nombres']; ?></td>
            <td><?php echo $p['apellidos']; ?></td>
            <td><?php echo $p['telefono']; ?></td>
            <td><?php echo $p['correo']; ?></td>
            <td><?php echo $p['direccion']; ?></td>
            <td>
                <a href="index.php?c=Padre&a=editar&id=<?php echo $p['id_padre']; ?>">Editar</a> |
                <a href="index.php?c=Padre&a=eliminar&id=<?php echo $p['id_padre']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este padre?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
