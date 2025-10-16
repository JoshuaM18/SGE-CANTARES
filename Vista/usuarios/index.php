<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_usuarios.css">
</head>
<body>
<h1>Listado de Usuarios</h1>
<a href="index.php?c=Usuario&a=nuevo">Agregar Usuario</a>
<table>
<tr>
    <th>ID</th>
    <th>Nombre de usuario</th>
    <th>Correo</th>
    <th>Rol</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>
<?php foreach($usuarios as $u): ?>
<tr>
    <td><?= $u['id_usuario'] ?></td>
    <td><?= $u['nombre_usuario'] ?></td>
    <td><?= $u['correo'] ?></td>
    <td><?= $u['rol'] ?></td>
    <td><?= $u['estado'] ?></td>
    <td>
        <a href="index.php?c=Usuario&a=editar&id=<?= $u['id_usuario'] ?>">Editar</a>
        <a href="index.php?c=Usuario&a=eliminar&id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>