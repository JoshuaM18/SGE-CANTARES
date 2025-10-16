<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Estudiante</title>
    <link rel="stylesheet" href="css/estilos_estudiantes.css">
</head>
<body>
    <h1>Agregar Nuevo Estudiante</h1>
    <form action="index.php?c=Estudiante&a=guardar" method="POST">
        <label>Usuario:</label>
        <select name="id_usuario" required>
            <option value="">-- Selecciona un usuario --</option>
            <?php foreach($usuarios as $u): ?>
                <option value="<?= $u['id_usuario'] ?>"><?= $u['nombre_usuario'] ?> (<?= $u['correo'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <label>Nombres:</label>
        <input type="text" name="nombres" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento">

        <label>Género:</label>
        <select name="genero">
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            <option value="Otro">Otro</option>
        </select>

        <label>Dirección:</label>
        <input type="text" name="direccion">

        <label>Teléfono:</label>
        <input type="text" name="telefono">

        <label>Fecha de Ingreso:</label>
        <input type="date" name="fecha_ingreso">

        <button type="submit">Guardar</button>
    </form>
    
    <a href="index.php?c=Estudiante&a=index">Volver al listado</a>
</body>
</html>