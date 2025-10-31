<!DOCTYPE html>
<html>
<head>
    <title>Agregar Curso al Catálogo</title>
</head>
<body>
    <h1>Agregar Curso al Catálogo</h1>

    <form action="index.php?c=CatalogoCurso&a=guardar" method="POST">
        <label>Nombre del curso:</label><br>
        <input type="text" name="nombre_curso" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <button type="submit">Guardar Curso</button>
        <a href="index.php?c=CatalogoCurso&a=index">Cancelar</a>
    </form>
</body>
</html>
