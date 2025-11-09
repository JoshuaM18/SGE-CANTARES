<head>
    <link rel="stylesheet" href="css/recurso.css">
</head>
<h2>Material Didáctico - Mis cursos</h2>

<?php if (!empty($vista_asignaciones)): ?>
    <?php foreach ($vista_asignaciones as $asig): ?>
        <h3><?= htmlspecialchars($asig['nombre_curso']) ?></h3>

        <?php 
        $lista = $vista_recursos[$asig['id_asignacion']] ?? [];
        if (!empty($lista)): 
        ?>
            <ul>
            <?php foreach ($lista as $r): ?>
                <li>
                    <!-- Nombre del recurso clickeable -->
                    <span class="recurso-titulo" onclick="togglePreview('preview-<?= $r['id_recurso'] ?>')">
                        <?= htmlspecialchars($r['titulo']) ?>
                    </span> - 
                    <a href="<?= htmlspecialchars($r['link_recurso']) ?>" target="_blank">Abrir en Drive</a>

                    <!-- Vista previa oculta por defecto -->
                    <div id="preview-<?= $r['id_recurso'] ?>" class="preview-container" style="display:none; margin-top:10px;">
                        <iframe src="<?= htmlspecialchars($r['link_recurso']) ?>" width="800" height="600"></iframe>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay recursos para este curso.</p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No estás matriculado en ningún curso.</p>
<?php endif; ?>

<script>
function togglePreview(id) {
    const elem = document.getElementById(id);
    elem.style.display = (elem.style.display === "none") ? "block" : "none";
}
</script>
