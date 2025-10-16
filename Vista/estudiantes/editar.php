<?php
if (!isset($estudiante)) {
    echo "No se encontró el estudiante.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="css/estilos_estudiantes.css">
</head>
<body>
    <h1>Editar Estudiante</h1>
    <form action="index.php?c=Estudiante&a=actualizar" method="POST">
        <input type="hidden" name="id_estudiante" value="<?php echo $estudiante['id_estudiante']; ?>">

        <label>ID Usuario:</label>
        <input type="number" name="id_usuario" value="<?php echo $estudiante['id_usuario']; ?>" readonly>

        <label>Nombres:</label>
        <input type="text" name="nombres" value="<?php echo $estudiante['nombres']; ?>" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $estudiante['apellidos']; ?>" required>

        <label>Fecha de nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $estudiante['fecha_nacimiento']; ?>">

        <label>Género:</label>
        <select name="genero">
            <option value="M" <?php if($estudiante['genero']=='M') echo 'selected'; ?>>Masculino</option>
            <option value="F" <?php if($estudiante['genero']=='F') echo 'selected'; ?>>Femenino</option>
            <option value="Otro" <?php if($estudiante['genero']=='Otro') echo 'selected'; ?>>Otro</option>
        </select>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $estudiante['direccion']; ?>">

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $estudiante['telefono']; ?>">

        <label>Fecha de ingreso:</label>
        <input type="date" name="fecha_ingreso" value="<?php echo $estudiante['fecha_ingreso']; ?>">

        <button type="submit">Actualizar</button>
    </form>
    
    <a href="index.php?c=Estudiante&a=index">Cancelar</a>
</body>
</html>