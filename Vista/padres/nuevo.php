<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Padre</title>
</head>
<body>
    <h1>Registrar Padre</h1>
    <form action="index.php?c=Padre&a=guardar" method="POST">

        <label>Usuario asociado:</label>
        <select name="id_usuario" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?php echo $u['id_usuario']; ?>">
                    <?php echo $u['nombre_usuario'] . " - " . $u['correo']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Nombres:</label>
        <input type="text" name="nombres" required><br><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required><br><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono"><br><br>

        <label>Correo:</label>
        <input type="email" name="correo"><br><br>

        <label>Dirección:</label>
        <textarea name="direccion"></textarea><br><br>

        <button type="submit">Guardar</button>
        <a href="index.php?c=Padre&a=index">Cancelar</a>
    </form>
</body>
</html>
