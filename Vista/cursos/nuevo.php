<!DOCTYPE html>
<html>
<head>
    <title>Agregar Nuevo Curso</title>
</head>
<body>
    <h1>Agregar Curso</h1>
    <form action="index.php?c=Curso&a=guardar" method="POST">
        <label>Carrera:</label><br>
        <select name="id_carrera" required>
            <option value="">-- Selecciona Carrera --</option>
            <?php foreach($carreras as $c): ?>
                <option value="<?= $c['id_carrera'] ?>"><?= $c['nombre_carrera'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Nombre del curso:</label><br>
        <input type="text" name="nombre_curso" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <label>Créditos:</label><br>
        <input type="number" name="creditos" min="1" required><br><br>

        <button type="submit">Guardar</button>
        <a href="index.php?c=Curso&a=index">Cancelar</a>
    </form>
</body>
</html>
