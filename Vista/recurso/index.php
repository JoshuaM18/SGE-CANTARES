<head>
    <link rel="stylesheet" href="css/recurso.css">
</head>
<h2>Material Didáctico - Todos los cursos</h2>

<?php if (!empty($vista_asignaciones)): ?>

    <?php 
    // Agrupar asignaciones por carrera (grado)
    $asignaciones_por_carrera = [];
    foreach ($vista_asignaciones as $asig) {
        $carrera = $asig['nombre_carrera'] ?? 'Sin Grado';
        if (!isset($asignaciones_por_carrera[$carrera])) {
            $asignaciones_por_carrera[$carrera] = [];
        }
        $asignaciones_por_carrera[$carrera][] = $asig;
    }
    ?>

    <?php foreach ($asignaciones_por_carrera as $carrera => $asigs): ?>
        <!-- Carrera clickeable -->
        <h3 class="carrera-titulo" onclick="toggleCursos('cursos-<?= md5($carrera) ?>')" style="cursor:pointer;">
            <?= htmlspecialchars($carrera) ?> ▼
        </h3>

        <div id="cursos-<?= md5($carrera) ?>" class="cursos-container" style="display:none; margin-left:20px;">
            <?php foreach ($asigs as $asig): ?>
                <!-- Curso clickeable -->
                <h4 class="curso-titulo" onclick="toggleRecursos('recursos-<?= $asig['id_asignacion'] ?>')" style="cursor:pointer;">
                    <?= htmlspecialchars($asig['nombre_curso']) ?> 
                    <small style="color: #555;">(<?= htmlspecialchars($carrera) ?>)</small> ▼
                </h4>

                <div id="recursos-<?= $asig['id_asignacion'] ?>" class="recursos-container" style="display:none; margin-left:20px;">
                    <?php if ($_SESSION['usuario']['rol'] === 'Docente'): ?>
                        <a href="index.php?c=Recurso&a=nuevo&id_asignacion=<?= $asig['id_asignacion'] ?>">➕ Agregar Material</a>
                    <?php endif; ?>

                    <?php 
                    $lista = $vista_recursos[$asig['id_asignacion']] ?? [];
                    if (!empty($lista)): 
                    ?>
                        <ul>
                        <?php foreach ($lista as $r): ?>
                            <li>
                                <span class="recurso-titulo" onclick="togglePreview('preview-<?= $r['id_recurso'] ?>')" style="cursor:pointer;">
                                    <?= htmlspecialchars($r['titulo']) ?>
                                </span> - 
                                <a href="<?= htmlspecialchars($r['link_recurso']) ?>" target="_blank">Ver en Drive</a>

                                <div id="preview-<?= $r['id_recurso'] ?>" class="preview-container" style="display:none; margin-top:10px;">
                                    <iframe src="<?= htmlspecialchars($r['link_recurso']) ?>" width="800" height="600"></iframe>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No hay recursos para este curso.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <p>No tienes cursos asignados.</p>
<?php endif; ?>

<script>
function togglePreview(id) {
    const elem = document.getElementById(id);
    elem.style.display = (elem.style.display === "none") ? "block" : "none";
}

function toggleCursos(id) {
    const elem = document.getElementById(id);
    elem.style.display = (elem.style.display === "none") ? "block" : "none";
}

function toggleRecursos(id) {
    const elem = document.getElementById(id);
    elem.style.display = (elem.style.display === "none") ? "block" : "none";
}
</script>
