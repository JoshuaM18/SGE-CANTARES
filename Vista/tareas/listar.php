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
/* Scroll horizontal para carreras y cursos */
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
    transition: all 0.3s ease;
    white-space: nowrap;
}

.scroll-carreras button.active, .scroll-cursos button.active,
.scroll-carreras button:hover, .scroll-cursos button:hover {
    background: #0C2340;
    color: #ffffff;
}

/* Contenedor de tarjetas */
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

/* Cada tarjeta */
.card {
    display: block;
    background: #ffffff;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.card.pendiente {
    border-top: 4px solid #140b46ff;
}

.card.parcial {
    border-top: 4px solid #fff3cd;
    background: #fffbea;
}

.card.calificada {
    border-top: 4px solid #d4edda;
    background: #e9f7ef;
}

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

<?php if ($_SESSION['usuario']['rol'] === 'Docente' && !empty($id_asignacion)): ?>
    <a href="index.php?c=Tarea&a=crear&id_asignacion=<?= $id_asignacion ?>" style="margin-bottom: 20px; display: inline-block;">+ Crear Nueva Tarea</a>
<?php endif; ?>

<?php
// Agrupar cursos por carrera
$carreras = [];
foreach ($cursos_docente as $curso) {
    $carreras[$curso['id_carrera']][] = $curso;
}
?>

<!-- Scroll horizontal de carreras -->
<?php if (!empty($carreras)): ?>
<div class="scroll-carreras">
    <?php foreach ($carreras as $idCarrera => $cursos): ?>
        <button data-carrera="<?= $idCarrera ?>"><?= htmlspecialchars($cursos[0]['nombre_carrera']) ?></button>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Scroll horizontal de cursos -->
<div class="scroll-cursos">
    <?php foreach ($cursos_docente as $curso): ?>
        <button class="curso-btn" data-carrera="<?= $curso['id_carrera'] ?>" data-asignacion="<?= $curso['id_asignacion'] ?>">
            <?= htmlspecialchars($curso['nombre_curso']) ?>
        </button>
    <?php endforeach; ?>
</div>

<!-- Tarjetas de tareas -->
<div class="cards-container">
<?php 
foreach ($cursos_docente as $curso):
    $tareasCurso = $this->modelo->obtenerTareasPorAsignacion($curso['id_asignacion']);
    foreach ($tareasCurso as $t):
        $conteo = $this->modelo->obtenerConteoEntregasPorTarea($t['id_tarea']);
        $calificadas = (int)($conteo['calificadas'] ?? 0);
        $pendientes = (int)($conteo['pendientes'] ?? 0);
        $clase = $pendientes === 0 && $calificadas > 0 ? 'calificada' : ($pendientes > 0 && $calificadas > 0 ? 'parcial' : 'pendiente');
?>
<div class="card <?= $clase ?>" data-asignacion="<?= $curso['id_asignacion'] ?>" data-carrera="<?= $curso['id_carrera'] ?>">
    <h3><?= htmlspecialchars($t['titulo']) ?></h3>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($t['descripcion']) ?></p>
    <p><strong>Valor:</strong> <?= htmlspecialchars($t['valor_tarea']) ?> pts</p>
    <p><strong>Fecha Entrega:</strong> <?= htmlspecialchars($t['fecha_entrega']) ?></p>
    <p class="estado">Calificadas: <?= $calificadas ?> | Pendientes: <?= $pendientes ?></p>
    <?php if ($_SESSION['usuario']['rol'] === 'Docente'): ?>
        <a href="index.php?c=Tarea&a=calificar&id_tarea=<?= $t['id_tarea'] ?>&id_asignacion=<?= $curso['id_asignacion'] ?>">Calificar</a>
    <?php else: ?>
        <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $t['id_tarea'] ?>&id_asignacion=<?= $curso['id_asignacion'] ?>">Entregar</a>
    <?php endif; ?>
</div>
<?php
    endforeach;
endforeach;
?>
</div>

<script>
// Filtrar cursos por carrera
const botonesCarrera = document.querySelectorAll('.scroll-carreras button');
const botonesCurso = document.querySelectorAll('.curso-btn');
const tarjetas = document.querySelectorAll('.cards-container .card');

function mostrarTarjetas(asignacionId) {
    tarjetas.forEach(t => {
        t.style.display = (t.getAttribute('data-asignacion') == asignacionId) ? 'block' : 'none';
    });
}

// Al hacer click en carrera
botonesCarrera.forEach(btn => {
    btn.addEventListener('click', () => {
        botonesCarrera.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const idCarrera = btn.getAttribute('data-carrera');

        // Mostrar solo cursos de esa carrera
        botonesCurso.forEach(c => {
            c.style.display = c.getAttribute('data-carrera') === idCarrera ? 'inline-block' : 'none';
            c.classList.remove('active');
        });

        // Mostrar tareas del primer curso visible
        const primerCurso = Array.from(botonesCurso).find(c => c.style.display !== 'none');
        if(primerCurso) mostrarTarjetas(primerCurso.getAttribute('data-asignacion'));
    });
});

// Al hacer click en curso
botonesCurso.forEach(btn => {
    btn.addEventListener('click', () => {
        botonesCurso.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        mostrarTarjetas(btn.getAttribute('data-asignacion'));
    });
});

// Mostrar primer carrera y curso al cargar la página
if(botonesCarrera.length > 0){
    botonesCarrera[0].click();
}
</script>

<br>
<a href="index.php">Volver al menú principal</a>
</body>
</html>
