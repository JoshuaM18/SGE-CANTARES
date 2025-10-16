<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Docente</title>
    <link rel="stylesheet" href="css/estilos_docentes.css">
</head>
<body>
    <h1>Registrar Docente</h1>
    <form action="index.php?c=Docente&a=guardar" method="POST">

        <label for="id_usuario">Usuario asociado:</label>
        <select id="id_usuario" name="id_usuario" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id_usuario'] ?>">
                    <?= $u['nombre_usuario'] . " - " . $u['correo'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="especialidad">Especialidad (Materia):</label>
        <select id="especialidad" name="especialidad" required>
            <option value="">Seleccione una materia</option>
            <option value="Matemáticas">Matemáticas</option>
            <option value="Comunicación y Lenguaje">Comunicación y Lenguaje</option>
            <option value="Ciencias Naturales">Ciencias Naturales</option>
            <option value="Estudios Sociales">Estudios Sociales</option>
            <option value="Formación Ciudadana">Formación Ciudadana</option>
            <option value="Educación Física">Educación Física</option>
            <option value="Inglés">Inglés</option>
            <option value="Química">Química</option>
            <option value="Física">Física</option>
            <option value="Biología">Biología</option>
            <option value="Contabilidad">Contabilidad</option>
            <option value="Computación">Computación</option>
            <option value="Dibujo Técnico">Dibujo Técnico</option>
            <option value="Música">Música</option>
            <option value="Artes Plásticas">Artes Plásticas</option>
            <option value="Filosofía">Filosofía</option>
            <option value="Psicología">Psicología</option>
            <option value="Estadística">Estadística</option>
            <option value="Administración de Empresas">Administración de Empresas</option>
            <option value="Literatura">Literatura</option>
        </select>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">

        <label for="correo_institucional">Correo Institucional:</label>
        <input type="email" id="correo_institucional" name="correo_institucional">

        <label for="fecha_contratacion">Fecha de Contratación:</label>
        <input type="date" id="fecha_contratacion" name="fecha_contratacion">

        <button type="submit">Guardar</button>
        <a href="index.php?c=Docente&a=index">Cancelar</a>
    </form>
</body>
</html>