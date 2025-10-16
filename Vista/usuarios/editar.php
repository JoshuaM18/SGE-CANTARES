<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/estilos_usuarios.css">
</head>
<body>
<h1>Editar Usuario</h1>
<form action="index.php?c=Usuario&a=actualizar" method="POST">
    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

    <label for="nombre_usuario">Nombre de usuario:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?= $usuario['nombre_usuario'] ?>" required>

    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" value="<?= $usuario['correo'] ?>">

    <label for="rol">Rol:</label>
    <select id="rol" name="rol" required>
        <option value="Administrador" <?= $usuario['rol']=='Administrador' ? 'selected' : '' ?>>Administrador</option>
        <option value="Docente" <?= $usuario['rol']=='Docente' ? 'selected' : '' ?>>Docente</option>
        <option value="Estudiante" <?= $usuario['rol']=='Estudiante' ? 'selected' : '' ?>>Estudiante</option>
        <option value="Padre" <?= $usuario['rol']=='Padre' ? 'selected' : '' ?>>Padre</option>
        <option value="Personal" <?= $usuario['rol']=='Personal' ? 'selected' : '' ?>>Personal</option>
    </select>

    <button type="submit">Actualizar</button>
</form>
<a href="index.php?c=Usuario&a=index">Cancelar</a>
</body>
</html>