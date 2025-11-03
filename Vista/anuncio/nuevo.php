<?php
// Variables disponibles: $cursos, $cursoSeleccionado, $docente
?>

<h2>Crear Nuevo Anuncio</h2>

<form action="index.php?c=Anuncio&a=guardar" method="POST">
    <!-- Selección de curso -->
    <label for="id_curso">Curso (dejar vacío para anuncio general):</label><br>
    <select name="id_curso">
        <option value="">-- General (Visible para todos) --</option>
        <?php foreach ($cursos as $curso): ?>
            <option value="<?= $curso['id_curso'] ?>" 
                <?php if(isset($cursoSeleccionado) && $cursoSeleccionado['id_curso'] == $curso['id_curso']) echo 'selected'; ?>>
                <?= htmlspecialchars($curso['nombre_curso'] . " (" . $curso['nombre_carrera'] . ")") ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Datos ocultos del docente -->
    <input type="hidden" name="id_docente" value="<?= $docente['id_docente'] ?? '' ?>">

    <!-- Título -->
    <label for="titulo">Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <!-- Descripción -->
    <label for="descripcion">Descripción:</label><br>
    <textarea name="descripcion" rows="5" required></textarea><br><br>

    <button type="submit">Guardar Anuncio</button>
    <a href="index.php?c=Anuncio&a=index&id_curso=<?= $cursoSeleccionado['id_curso'] ?? '' ?>">Cancelar</a>
</form>
