<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_estudiantes.css">
</head>
<body>
<h1>Listado de Estudiantes</h1>
<a href="index.php?c=Estudiante&a=nuevo">Agregar Estudiante</a>
<table>
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Nombre completo</th>
        <th>Correo</th>
        <th>Género</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Fecha de nacimiento</th>
        <th>Fecha de ingreso</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($estudiantes as $e): ?>
    <tr>
        <td><?php echo $e['id_estudiante']; ?></td>
        <td><?php echo $e['nombre_usuario']; ?></td>
        <td><?php echo $e['nombres'] . ' ' . $e['apellidos']; ?></td>
        <td><?php echo $e['correo']; ?></td>
        <td><?php echo $e['genero']; ?></td>
        <td><?php echo $e['direccion']; ?></td>
        <td><?php echo $e['telefono']; ?></td>
        <td><?php echo $e['fecha_nacimiento']; ?></td>
        <td><?php echo $e['fecha_ingreso']; ?></td>
        <td>
            <a href="index.php?c=Estudiante&a=editar&id=<?php echo $e['id_estudiante']; ?>">Editar</a>
            <a href="index.php?c=Estudiante&a=eliminar&id=<?php echo $e['id_estudiante']; ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
