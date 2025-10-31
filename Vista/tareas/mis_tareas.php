<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Tareas</title>
<link rel="stylesheet" href="css/cards.css">
<style>
:root {
    --fondo: #0C2340;
    --rojo: #D32F2F;
    --amarillo: #FBC02D;
    --blanco: #FFFFFF;
}

/* Scroll horizontal para cursos */
.scroll-cursos {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding: 1rem 0;
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
}
.scroll-cursos button.active,
.scroll-cursos button:hover {
    background: var(--fondo);
    color: var(--blanco);
}

/* Tarjetas */
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}
.card {
    display: block;
    background: var(--blanco);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.card.pendiente {
    border-top: 4px solid var(--amarillo);
}
.card.pasada {
    border-top: 4px solid var(--fondo);
    background: #f0f4f8;
}

/* Comentarios */
.comentarios {
    display: none;
    margin-top: 1rem;
    border-top: 1px solid #ccc;
    padding-top: 0.5rem;
}
.comentario {
    margin-bottom: 0.5rem;
}
.comentario p {
    margin: 0.2rem 0;
}
textarea {
    width: 100%;
    resize: vertical;
}
</style>
</head>
<body>
<h1>Mis Tareas</h1>

<!-- Cursos -->
<div class="scroll-cursos">
    <?php if (!empty($cursos)): ?>
        <?php foreach ($cursos as $index => $curso): ?>
            <button class="<?= $index === 0 ? 'active' : '' ?>" data-curso="<?= $curso['id_curso'] ?>">
                <?= htmlspecialchars($curso['nombre_curso']) ?>
            </button>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No estás asignado a ningún curso.</p>
    <?php endif; ?>
</div>

<!-- Tareas Pendientes -->
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
<div class="card pendiente" data-curso="<?= $idCursoTarea ?>">
    <h3><?= htmlspecialchars($tarea['titulo']) ?></h3>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($tarea['descripcion']) ?></p>
    <p><strong>Valor:</strong> <?= htmlspecialchars($tarea['valor_tarea']) ?> pts</p>
    <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($tarea['fecha_entrega']) ?></p>
    <p class="estado"><strong>Estado:</strong> Pendiente</p>
    <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $tarea['id_tarea'] ?>&id_asignacion=<?= $tarea['id_asignacion'] ?>">Entregar</a>

    <!-- Botón mostrar comentarios -->
    <button class="toggle-comentarios" data-tarea="<?= $tarea['id_tarea'] ?>">Ver comentarios</button>
    <div class="comentarios" id="comentarios-<?= $tarea['id_tarea'] ?>">
        <?php 
        $comentarios = $comentarios_tareas[$tarea['id_tarea']] ?? [];
        if (!empty($comentarios)): ?>
            <?php foreach ($comentarios as $c): ?>
                <div class="comentario">
                    <strong>
                        <?php 
                        // Mostrar nombre según rol: profesor o alumno
                        if ($c['rol'] === 'Docente') {
                            echo htmlspecialchars($c['nombre'] ?? 'Profesor');
                        } else {
                            echo htmlspecialchars($c['nombre'] ?? 'Alumno');
                        }
                        ?>
                    </strong> (<?= $c['fecha'] ?>):
                    <p><?= htmlspecialchars($c['comentario']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay comentarios.</p>
        <?php endif; ?>

        <!-- Formulario agregar comentario -->
        <form method="POST" action="index.php?c=Comentario&a=guardar">
            <input type="hidden" name="id_tarea" value="<?= $tarea['id_tarea'] ?>">
            <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario']['id_usuario'] ?>">
            <textarea name="comentario" rows="2" placeholder="Escribe un comentario..." required></textarea>
            <button type="submit">Agregar comentario</button>
        </form>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- Tareas Pasadas -->
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
<div class="card pasada" data-curso="<?= $idCursoTarea ?>">
    <h3><?= htmlspecialchars($tarea['titulo']) ?></h3>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($tarea['descripcion']) ?></p>
    <p><strong>Valor:</strong> <?= htmlspecialchars($tarea['valor_tarea']) ?> pts</p>
    <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($tarea['fecha_entrega']) ?></p>
    <p class="estado"><strong>Estado:</strong> <?= $estado ?></p>
    <?php if ($entregado): ?>
        <a href="index.php?c=Tarea&a=verEntrega&id_tarea=<?= $tarea['id_tarea'] ?>">Ver Entrega</a>
    <?php endif; ?>

    <!-- Botón mostrar comentarios -->
    <button class="toggle-comentarios" data-tarea="<?= $tarea['id_tarea'] ?>">Ver comentarios</button>
    <div class="comentarios" id="comentarios-<?= $tarea['id_tarea'] ?>">
        <?php 
        $comentarios = $comentarios_tareas[$tarea['id_tarea']] ?? [];
        if (!empty($comentarios)): ?>
            <?php foreach ($comentarios as $c): ?>
                <div class="comentario">
                    <strong>
                        <?php 
                        if ($c['rol'] === 'Docente') {
                            echo htmlspecialchars($c['nombre'] ?? 'Profesor');
                        } else {
                            echo htmlspecialchars($c['nombre'] ?? 'Alumno');
                        }
                        ?>
                    </strong> (<?= $c['fecha'] ?>):
                    <p><?= htmlspecialchars($c['comentario']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay comentarios.</p>
        <?php endif; ?>

        <form method="POST" action="index.php?c=Comentario&a=guardar">
            <input type="hidden" name="id_tarea" value="<?= $tarea['id_tarea'] ?>">
            <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario']['id_usuario'] ?>">
            <textarea name="comentario" rows="2" placeholder="Escribe un comentario..." required></textarea>
            <button type="submit">Agregar comentario</button>
        </form>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>

<script>
// Filtrar tareas por curso
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

// Inicialmente mostrar tareas del primer curso
if (botonesCurso.length > 0) botonesCurso[0].click();

// Toggle comentarios
const btnComentarios = document.querySelectorAll('.toggle-comentarios');
btnComentarios.forEach(btn => {
    btn.addEventListener('click', () => {
        const tareaId = btn.getAttribute('data-tarea');
        const div = document.getElementById('comentarios-' + tareaId);
        div.style.display = div.style.display === 'block' ? 'none' : 'block';
    });
});
</script>
</body>
</html>
