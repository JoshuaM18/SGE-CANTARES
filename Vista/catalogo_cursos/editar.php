<!DOCTYPE html>
<html>
<head>
    <title>Editar Curso del Catálogo</title>
</head>
<body>
    <h1>Editar Curso del Catálogo</h1>

    <form action="index.php?c=CatalogoCurso&a=actualizar" method="POST">
        <input type="hidden" name="id_catalogo_curso" value="<?= $curso['id_catalogo_curso'] ?>">

        <label>Nombre del curso:</label><br>
        <input type="text" name="nombre_curso" value="<?= $curso['nombre_curso'] ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= $curso['descripcion'] ?></textarea><br><br>

        <button type="submit">Actualizar Curso</button>
        <a href="index.php?c=CatalogoCurso&a=index">Cancelar</a>
    </form>
</body>
</html>
