<head>
    <link rel="stylesheet" href="css/anuncio.css">
</head>
<?php
// Variables disponibles: $cursos, $id_curso, $anuncios, $cursoSeleccionado, $anunciosGenerales
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

<h2>Anuncios del Curso <?= $cursoSeleccionado['nombre_curso'] ?? '' ?></h2>

<?php if ($cursoSeleccionado): ?>
    <a href="index.php?c=Anuncio&a=nuevo&id_curso=<?= $cursoSeleccionado['id_curso'] ?>" class="btn btn-primary">Nuevo Anuncio</a>
<?php else: ?>
    <a href="index.php?c=Anuncio&a=nuevo" class="btn btn-primary">Nuevo Anuncio General</a>
<?php endif; ?>

<!-- Selección de curso -->
<form method="GET" action="index.php" style="margin-top: 15px;">
    <input type="hidden" name="c" value="Anuncio">
    <input type="hidden" name="a" value="index">
    <label for="id_curso">Seleccionar curso:</label>
    <select name="id_curso" onchange="this.form.submit()">
        <option value="">-- Todos / General --</option>
        <?php foreach ($cursos as $curso): ?>
            <option value="<?= $curso['id_curso'] ?>" <?= ($id_curso == $curso['id_curso']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($curso['nombre_curso'] . " (" . $curso['nombre_carrera'] . ")") ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<hr>

<?php if (!empty($anuncios)): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Docente</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($anuncios as $anuncio): ?>
                <tr>
                    <td><?= htmlspecialchars($anuncio['titulo']) ?></td>
                    <td><?= nl2br(htmlspecialchars($anuncio['descripcion'])) ?></td>
                    <td><?= htmlspecialchars($anuncio['docente'] ?? 'Sistema') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($anuncio['fecha_publicacion'])) ?></td>
                    <td>
                        <a href="index.php?c=Anuncio&a=archivar&id_anuncio=<?= $anuncio['id_anuncio'] ?>&id_curso=<?= $id_curso ?>" onclick="return confirm('¿Archivar este anuncio?');">Archivar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif($id_curso): ?>
    <p>No hay anuncios para este curso.</p>
<?php endif; ?>
