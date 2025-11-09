<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/carrera.css">
    <title>Editar Carrera</title>
</head>
<body>
    <h1>Editar Carrera</h1>
    <form action="index.php?c=Carrera&a=actualizar" method="POST">
        <input type="hidden" name="id_carrera" value="<?= $carrera['id_carrera'] ?>">

        <label>Nombre:</label><br>
        <input type="text" name="nombre_carrera" value="<?= $carrera['nombre_carrera'] ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= $carrera['descripcion'] ?></textarea><br><br>

        <button type="submit">Actualizar</button>
        <a href="index.php?c=Carrera&a=index">Cancelar</a>
    </form>
</body>
</html>
