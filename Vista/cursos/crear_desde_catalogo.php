<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Cursos desde Catálogo aaaaaaaaaaaaaaaa</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f6f8;
    padding: 30px;
}
form {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: auto;
}
h1 {
    text-align: center;
    color: #0C2340;
}
label {
    font-weight: bold;
}
select, button {
    margin-top: 10px;
}
.cursos-lista {
    margin-top: 15px;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 8px;
    max-height: 300px;
    overflow-y: auto;
}
.cursos-lista label {
    display: block;
    margin-bottom: 5px;
}
button {
    background: #0C2340;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
button:hover {
    background: #140b46;
}
</style>
</head>
<body>

<h1>Agregar Cursos desde Catálogo</h1>

<form action="index.php?c=Curso&a=guardarDesdeCatalogo" method="POST">
    <label for="id_carrera">Seleccionar Carrera:</label><br>
    <select name="id_carrera" id="id_carrera" required>
        <option value="">-- Selecciona una carrera --</option>
        <?php foreach ($carreras as $c): ?>
            <option value="<?= $c['id_carrera'] ?>"><?= htmlspecialchars($c['nombre_carrera']) ?></option>
        <?php endforeach; ?>
    </select>

    <div class="cursos-lista">
        <p><strong>Selecciona los cursos a agregar:</strong></p>
        <?php foreach ($cursos_catalogo as $curso): ?>
            <label>
                <input type="checkbox" name="cursos[]" value="<?= $curso['id_catalogo_curso'] ?>">
                <?= htmlspecialchars($curso['nombre_curso']) ?>
            </label>
        <?php endforeach; ?>
    </div>

    <button type="submit">Guardar Cursos</button>
    <a href="index.php?c=Curso&a=index" style="margin-left:10px;">Cancelar</a>
</form>
<a href="index.php?c=CatalogoCurso&a=index">Administrar Catálogo de Cursos</a>
</body>
</html>
