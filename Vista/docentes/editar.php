<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente</title>
    <link rel="stylesheet" href="css/estilos_docentes.css">
</head>
<body>
    <h1>Editar Docente</h1>
    <form action="index.php?c=Docente&a=actualizar" method="POST">

        <input type="hidden" name="id_docente" value="<?= $docente['id_docente'] ?>">

        <label for="id_usuario">ID Usuario:</label>
        <input type="text" id="id_usuario" value="<?= $docente['id_usuario'] ?>" readonly>

        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" value="<?= $docente['nombres'] ?>" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?= $docente['apellidos'] ?>" required>

        <label for="especialidad">Especialidad (Materia):</label>
        <select id="especialidad" name="especialidad" required>
            <option value="">Seleccione una materia</option>
            <?php
            $materias = [
                "Matemáticas","Comunicación y Lenguaje","Ciencias Naturales","Estudios Sociales",
                "Formación Ciudadana","Educación Física","Inglés","Química","Física","Biología",
                "Contabilidad","Computación","Dibujo Técnico","Música","Artes Plásticas",
                "Filosofía","Psicología","Estadística","Administración de Empresas","Literatura"
            ];
            foreach ($materias as $m): ?>
                <option value="<?= $m ?>" <?= $docente['especialidad']==$m ? "selected" : "" ?>>
                    <?= $m ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?= $docente['telefono'] ?>">

        <label for="correo_institucional">Correo Institucional:</label>
        <input type="email" id="correo_institucional" name="correo_institucional" value="<?= $docente['correo_institucional'] ?>">

        <label for="fecha_contratacion">Fecha de Contratación:</label>
        <input type="date" id="fecha_contratacion" name="fecha_contratacion" value="<?= $docente['fecha_contratacion'] ?>">

        <button type="submit">Actualizar</button>
        <a href="index.php?c=Docente&a=index">Cancelar</a>
    </form>
</body>
</html>