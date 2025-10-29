<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Tareas</title>
<link rel="stylesheet" href="css/cards.css">
<style>
/* Colores de paleta */
:root {
    --fondo: #0C2340; /* azul oscuro */
    --rojo: #D32F2F;
    --amarillo: #140b46ff;
    --blanco: #FFFFFF;
    --negro: #000000;
}

/* Scroll horizontal para cursos */
.scroll-cursos {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding: 1rem 0;
    margin-bottom: 2rem;
}

.scroll-cursos button {
    flex: 0 0 auto;
    padding: 0.6rem 1.2rem;
    border: 2px solid var(--amarillo);
    border-radius: 12px;
    background: var(--blanco);
    color: var(--fondo);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.scroll-cursos button.active,
.scroll-cursos button:hover {
    background: var(--fondo);
    color: var(--blanco);
}

/* Contenedor de tarjetas */
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}

/* Cada tarjeta */
.card {
    display: block;
    background: var(--blanco);
    border-radius: 12px;
    padding: 1.2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* Estado de la tarea */
.card.pendiente {
    border-top: 4px solid var(--amarillo);
}

.card.pasada {
    border-top: 4px solid var(--fondo);
    background: #f0f4f8;
}

/* Enlaces */
.card.pendiente a {
    color: var(--fondo);
    text-decoration: none;
    font-weight: 600;
}

.card.pendiente a:hover {
    text-decoration: underline;
}

.card.pasada a {
    color: var(--rojo);
    text-decoration: none;
    font-weight: 600;
}

.card.pasada a:hover {
    text-decoration: underline;
}

/* Secciones */
.seccion-tareas {
    margin-bottom: 3rem;
}
.seccion-tareas h2 {
    color: var(--fondo);
    margin-bottom: 1rem;
}
</style>
</head>
<body>
<h1>Mis Tareas</h1>

<!-- Scroll cursos -->
<div class="scroll-cursos">
    <?php if (!empty($cursos) && is_array($cursos)): ?>
        <?php foreach ($cursos as $index => $curso): ?>
            <button class="<?= $index === 0 ? 'active' : '' ?>" data-curso="<?= htmlspecialchars($curso['id_curso']) ?>">
                <?= htmlspecialchars($curso['nombre_curso']) ?>
            </button>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No estás asignado a ningún curso.</p>
    <?php endif; ?>
</div>

<!-- Sección Tareas Pendientes -->
<div class="seccion-tareas">
    <h2>Tareas Pendientes</h2>
    <div class="cards-container">
    <?php
        $hoy = date('Y-m-d');
        foreach ($tareas as $tarea):
            $entregado = ($tarea['id_entrega'] ?? null) !== null;
            $vencida = !$entregado && ($tarea['fecha_entrega'] < $hoy);
            if ($entregado || $vencida) continue; // solo pendientes
            $idCursoTarea = $tarea['id_curso'] ?? '';
    ?>
        <div class="card pendiente" data-curso="<?= htmlspecialchars($idCursoTarea) ?>">
            <h3><?= htmlspecialchars($tarea['titulo']) ?></h3>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($tarea['descripcion']) ?></p>
            <p><strong>Valor:</strong> <?= htmlspecialchars($tarea['valor_tarea']) ?> pts</p>
            <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($tarea['fecha_entrega']) ?></p>
            <p class="estado"><strong>Estado:</strong> Pendiente</p>
            <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $tarea['id_tarea'] ?>&id_asignacion=<?= $tarea['id_asignacion'] ?>">Entregar</a>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<!-- Sección Tareas Pasadas -->
<div class="seccion-tareas">
    <h2>Tareas Pasadas</h2>
    <div class="cards-container">
    <?php
        foreach ($tareas as $tarea):
            $entregado = ($tarea['id_entrega'] ?? null) !== null;
            $vencida = !$entregado && ($tarea['fecha_entrega'] < $hoy);
            if (!$entregado && !$vencida) continue; // solo pasadas
            $idCursoTarea = $tarea['id_curso'] ?? '';
            $estado = $entregado ? "Entregado" : "Vencida";
    ?>
        <div class="card pasada" data-curso="<?= htmlspecialchars($idCursoTarea) ?>">
            <h3><?= htmlspecialchars($tarea['titulo']) ?></h3>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($tarea['descripcion']) ?></p>
            <p><strong>Valor:</strong> <?= htmlspecialchars($tarea['valor_tarea']) ?> pts</p>
            <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($tarea['fecha_entrega']) ?></p>
            <p class="estado"><strong>Estado:</strong> <?= $estado ?></p>
            <?php if ($entregado): ?>
                <a href="index.php?c=Tarea&a=verEntrega&id_tarea=<?= $tarea['id_tarea'] ?>">Ver Entrega</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<script>
// Filtrar tarjetas por curso
const botonesCurso = document.querySelectorAll('.scroll-cursos button');
const tarjetas = document.querySelectorAll('.cards-container .card');

botonesCurso.forEach(btn => {
    btn.addEventListener('click', () => {
        botonesCurso.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const cursoId = btn.getAttribute('data-curso');
        tarjetas.forEach(tarjeta => {
            tarjeta.style.display = (tarjeta.getAttribute('data-curso') === cursoId) ? 'block' : 'none';
        });
    });
});

// Mostrar inicialmente tareas del primer curso
if (botonesCurso.length > 0) {
    botonesCurso[0].click();
}
</script>
</body>
</html>
