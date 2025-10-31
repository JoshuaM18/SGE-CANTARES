<!DOCTYPE html>
<html>
<head>
    <title>Agregar Cursos desde Catálogo</title>
</head>
<body>
    <h1>Agregar Cursos desde Catálogo</h1>

    <form action="index.php?c=Curso&a=guardarDesdeCatalogo" method="POST">
        <label>Carrera:</label><br>
        <select name="id_carrera" required>
            <option value="">-- Selecciona Carrera --</option>
            <?php foreach($carreras as $c): ?>
                <option value="<?= $c['id_carrera'] ?>"><?= $c['nombre_carrera'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Cursos:</label><br>
        <select name="cursos[]" multiple size="10" required>
            <?php foreach($cursos_catalogo as $curso): ?>
                <option value="<?= $curso['id_catalogo_curso'] ?>"><?= $curso['nombre_curso'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Guardar Cursos</button>
        <a href="index.php?c=Curso&a=index">Cancelar</a>
    </form>
</body>
</html>
