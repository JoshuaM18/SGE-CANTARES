<!DOCTYPE html>
<html>
<head>
    <title>Editar Curso</title>
</head>
<body>
    <h1>Editar Curso</h1>

    <form action="index.php?c=Curso&a=actualizar" method="POST">
        <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">

        <label>Carrera:</label><br>
        <select name="id_carrera" required>
            <?php foreach($carreras as $c): ?>
                <option value="<?= $c['id_carrera'] ?>" <?= $curso['id_carrera']==$c['id_carrera']?'selected':'' ?>>
                    <?= $c['nombre_carrera'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Nombre del curso:</label><br>
        <input type="text" name="nombre_curso" value="<?= $curso['nombre_curso'] ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= $curso['descripcion'] ?></textarea><br><br>

        <button type="submit">Actualizar Curso</button>
        <a href="index.php?c=Curso&a=index">Cancelar</a>
    </form>
</body>
</html>
