<head>
    <link rel="stylesheet" href="css/anuncio.css">
</head>

<?php
// Variables disponibles: $cursos, $id_curso, $anuncios, $anunciosGenerales

$cursoSeleccionado = null;
if (isset($id_curso) && $id_curso) {
    foreach ($cursos as $curso) {
        if ($curso['id_curso'] == $id_curso) {
            $cursoSeleccionado = $curso;
            break;
        }
    }
}
?>

<h2>Anuncios Generales</h2>
<?php if(!empty($anunciosGenerales)): ?>
    <ul>
    <?php foreach($anunciosGenerales as $anuncio): ?>
        <li>
            <strong><?= htmlspecialchars($anuncio['titulo']) ?></strong>
            <p><?= nl2br(htmlspecialchars($anuncio['descripcion'])) ?></p>
            <em><?= htmlspecialchars($anuncio['docente'] ?? 'Sistema') ?> - <?= date('d/m/Y', strtotime($anuncio['fecha_publicacion'])) ?></em>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay anuncios generales.</p>
<?php endif; ?>

<hr>

<h2>Anuncios del Curso <?= $cursoSeleccionado['nombre_curso'] ?? 'Seleccione un curso'; ?></h2>

<form method="GET" action="index.php" style="margin-bottom: 15px;">
    <input type="hidden" name="c" value="Anuncio">
    <input type="hidden" name="a" value="verPorEstudiante">
    <label for="id_curso">Seleccionar curso:</label>
    <select name="id_curso" onchange="this.form.submit()">
        <option value="">-- Seleccione --</option>
        <?php foreach ($cursos as $curso): ?>
            <option value="<?= $curso['id_curso'] ?>" <?= ($id_curso == $curso['id_curso']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($curso['nombre_curso'] . " (" . $curso['nombre_carrera'] . ")") ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if (!empty($anuncios)): ?>
    <ul>
        <?php foreach ($anuncios as $anuncio): ?>
            <li style="margin-bottom: 15px;">
                <strong><?= htmlspecialchars($anuncio['titulo']) ?></strong> 
                <em>(<?= date('d/m/Y', strtotime($anuncio['fecha_publicacion'])) ?>)</em>
                <p><?= nl2br(htmlspecialchars($anuncio['descripcion'])) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay anuncios para este curso.</p>
<?php endif; ?>
