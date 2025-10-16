<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Docentes</title>
    <link rel="stylesheet" href="css/estilos_docentes.css">
</head>
<body>
    <h1>Listado de Docentes</h1>
    <a href="index.php?c=Docente&a=nuevo">Agregar Nuevo Docente</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Especialidad</th>
            <th>Teléfono</th>
            <th>Correo Institucional</th>
            <th>Fecha Contratación</th>
            <th>Acciones</th>
        </tr>
        <?php foreach($docentes as $d): ?>
        <tr>
            <td><?= $d['id_docente'] ?></td>
            <td><?= $d['nombre_usuario'] ?> (<?= $d['correo'] ?>)</td>
            <td><?= $d['nombres'] ?></td>
            <td><?= $d['apellidos'] ?></td>
            <td><?= $d['especialidad'] ?></td>
            <td><?= $d['telefono'] ?></td>
            <td><?= $d['correo_institucional'] ?></td>
            <td><?= $d['fecha_contratacion'] ?></td>
            <td>
                <a href="index.php?c=Docente&a=editar&id=<?= $d['id_docente'] ?>">Editar</a>
                <a href="index.php?c=Docente&a=eliminar&id=<?= $d['id_docente'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este docente?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>