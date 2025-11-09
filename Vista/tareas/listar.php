<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Tareas</title>
<link rel="stylesheet" href="css/estilos_tareas.css">
<style>
.scroll-carreras, .scroll-cursos {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding: 1rem 0;
    margin-bottom: 2rem;
}
.scroll-carreras button, .scroll-cursos button {
    flex: 0 0 auto;
    padding: 0.6rem 1.2rem;
    border: 2px solid #140b46ff;
    border-radius: 12px;
    background: #ffffff;
    color: #0C2340;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.3s ease;
}
.scroll-carreras button.active, .scroll-cursos button.active,
.scroll-carreras button:hover, .scroll-cursos button:hover {
    background: #0C2340;
    color: #ffffff;
}
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}
.card {
    display: block;
    background: #ffffff;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.card.pendiente { border-top: 4px solid #140b46ff; }
.card.parcial { border-top: 4px solid #fff3cd; background: #fffbea; }
.card.calificada { border-top: 4px solid #d4edda; background: #e9f7ef; }
.card h3 { margin-top: 0; }
.card a {
    display: inline-block;
    margin-top: 0.5rem;
    padding: 0.3rem 0.6rem;
    background: #0C2340;
    color: #ffffff;
    text-decoration: none;
    border-radius: 6px;
}
.card a:hover { background: #140b46ff; }
</style>
</head>
<body>
<h1>Lista de Tareas</h1>

<?php if ($_SESSION['usuario']['rol'] === 'Docente' && !empty($id_asignacion ?? null)): ?>
    <a href="index.php?c=Tarea&a=crear&id_asignacion=<?= htmlspecialchars($id_asignacion) ?>" style="margin-bottom: 20px; display: inline-block;">+ Crear Nueva Tarea</a>
<?php endif; ?>

<?php
// Agrupar cursos por carrera
$carreras = [];
foreach ($cursos_docente as $curso) {
    $idCarrera = $curso['id_carrera'] ?? 'sin_carrera';
    $carreras[$idCarrera][] = $curso;
}
?>

<!-- Scroll horizontal de carreras -->
<div class="scroll-carreras">
<?php foreach ($carreras as $idCarrera => $cursos): ?>
    <button data-carrera="<?= htmlspecialchars($idCarrera) ?>"><?= htmlspecialchars($cursos[0]['nombre_carrera'] ?? 'Sin Carrera') ?></button>
<?php endforeach; ?>
</div>

<!-- Scroll horizontal de cursos -->
<?php foreach ($carreras as $idCarrera => $cursos): ?>
<div class="scroll-cursos" data-carrera="<?= htmlspecialchars($idCarrera) ?>" style="display:none;">
    <?php foreach ($cursos as $curso): ?>
        <button class="curso-btn" data-asignacion="<?= htmlspecialchars($curso['id_asignacion'] ?? '') ?>">
            <?= htmlspecialchars($curso['nombre_curso'] ?? 'Curso sin nombre') ?>
        </button>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>

<!-- Tarjetas de tareas -->
<div class="cards-container">
<?php 
foreach ($cursos_docente as $curso):
    $idAsignacion = $curso['id_asignacion'] ?? '';
    $idCarrera = $curso['id_carrera'] ?? 'sin_carrera';
    $tareasCurso = $tareasPorCurso[$idAsignacion] ?? [];
    foreach ($tareasCurso as $t):
        $calificadas = (int)($t['calificadas'] ?? 0);
        $pendientes = (int)($t['pendientes'] ?? 0);
        $clase = $pendientes === 0 && $calificadas > 0 ? 'calificada' : ($pendientes > 0 && $calificadas > 0 ? 'parcial' : 'pendiente');
?>
<div class="card <?= $clase ?>" data-asignacion="<?= htmlspecialchars($idAsignacion) ?>" data-carrera="<?= htmlspecialchars($idCarrera) ?>">
    <h3><?= htmlspecialchars($t['titulo'] ?? '') ?></h3>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($t['descripcion'] ?? '') ?></p>
    <p><strong>Valor:</strong> <?= htmlspecialchars($t['valor_tarea'] ?? 0) ?> pts</p>
    <p><strong>Fecha Entrega:</strong> <?= htmlspecialchars($t['fecha_entrega'] ?? '') ?></p>
    <p class="estado">Calificadas: <?= $calificadas ?> | Pendientes: <?= $pendientes ?></p>
    
    <?php if ($_SESSION['usuario']['rol'] === 'Docente'): ?>
        <a href="index.php?c=Tarea&a=calificar&id_tarea=<?= $t['id_tarea'] ?>&id_asignacion=<?= htmlspecialchars($idAsignacion) ?>">Calificar</a>
    <?php else: ?>
        <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $t['id_tarea'] ?>&id_asignacion=<?= htmlspecialchars($idAsignacion) ?>">Entregar</a>
    <?php endif; ?>

    <a href="index.php?c=Comentario&a=index&id_tarea=<?= $t['id_tarea'] ?>">Ver comentarios</a>
</div>
<?php
    endforeach;
endforeach;
?>
</div>

<script>
// Filtrar cursos y tareas
const botonesCarrera = document.querySelectorAll('.scroll-carreras button');
const contenedoresCursos = document.querySelectorAll('.scroll-cursos');
const tarjetas = document.querySelectorAll('.cards-container .card');

function mostrarTarjetas(asignacionId) {
    tarjetas.forEach(t => {
        t.style.display = (t.getAttribute('data-asignacion') == asignacionId) ? 'block' : 'none';
    });
}

botonesCarrera.forEach(btn => {
    btn.addEventListener('click', () => {
        botonesCarrera.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const idCarrera = btn.getAttribute('data-carrera');

        // Mostrar contenedor de cursos correspondiente
        contenedoresCursos.forEach(c => {
            c.style.display = (c.getAttribute('data-carrera') === idCarrera) ? 'flex' : 'none';
            // reset active buttons
            c.querySelectorAll('.curso-btn').forEach(cb => cb.classList.remove('active'));
        });

        // Mostrar tareas del primer curso visible
        const primerCurso = document.querySelector(`.scroll-cursos[data-carrera="${idCarrera}"] .curso-btn`);
        if(primerCurso) {
            primerCurso.classList.add('active');
            mostrarTarjetas(primerCurso.getAttribute('data-asignacion'));
        }
    });
});

contenedoresCursos.forEach(c => {
    c.querySelectorAll('.curso-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            // quitar active de todos los botones
            c.querySelectorAll('.curso-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            mostrarTarjetas(btn.getAttribute('data-asignacion'));
        });
    });
});

// Al cargar la página, activar la primera carrera
if(botonesCarrera.length > 0){
    botonesCarrera[0].click();
}
</script>

<br>
<a href="index.php">Volver al menú principal</a>
</body>
</html>
