<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/carrera.css">
    <title>Agregar Nueva Carrera</title>
</head>
<body>
    <h1>Agregar Carrera</h1>
    <form action="index.php?c=Carrera&a=guardar" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre_carrera" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <button type="submit">Guardar</button>
        <a href="index.php?c=Carrera&a=index">Cancelar</a>
    </form>
</body>
</html>
