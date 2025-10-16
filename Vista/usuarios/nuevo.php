<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
    <link rel="stylesheet" href="css/estilos_usuarios.css">
</head>
<body>
<h1>Agregar Usuario</h1>
<form action="index.php?c=Usuario&a=guardar" method="POST">
    <label for="nombre_usuario">Nombre de usuario:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" required>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required>

    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo">

    <label for="rol">Rol:</label>
    <select id="rol" name="rol" required>
        <option value="Administrador">Administrador</option>
        <option value="Docente">Docente</option>
        <option value="Estudiante">Estudiante</option>
        <option value="Padre">Padre</option>
        <option value="Personal">Personal</option>
    </select>

    <button type="submit">Guardar</button>
</form>
<a href="index.php?c=Usuario&a=index">Volver al listado</a>
</body>
</html>