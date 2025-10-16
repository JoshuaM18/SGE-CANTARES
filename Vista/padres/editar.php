<!DOCTYPE html>
<html>
<head>
    <title>Editar Padre</title>
</head>
<body>
    <h1>Editar Padre</h1>
    <form action="index.php?c=Padre&a=actualizar" method="POST">
        <input type="hidden" name="id_padre" value="<?php echo $padre['id_padre']; ?>">

        <label>ID Usuario:</label>
        <input type="text" value="<?php echo $padre['id_usuario']; ?>" readonly><br><br>

        <label>Nombres:</label>
        <input type="text" name="nombres" value="<?php echo $padre['nombres']; ?>" required><br><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $padre['apellidos']; ?>" required><br><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $padre['telefono']; ?>"><br><br>

        <label>Correo:</label>
        <input type="email" name="correo" value="<?php echo $padre['correo']; ?>"><br><br>

        <label>Dirección:</label>
        <textarea name="direccion"><?php echo $padre['direccion']; ?></textarea><br><br>

        <button type="submit">Actualizar</button>
        <a href="index.php?c=Padre&a=index">Cancelar</a>
    </form>
</body>
</html>
