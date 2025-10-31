<h2>Comentarios de la tarea</h2>

<a href="index.php?c=Comentario&a=nuevo&id_tarea=<?= $id_tarea ?>">Agregar nuevo comentario</a>

<?php if (!empty($comentarios)): ?>
    <ul>
        <?php foreach ($comentarios as $c): ?>
            <?php
                $prefijo = ($c['rol'] === 'Docente') ? 'Profesor' : 'Alumno';
                $nombreMostrar = "$prefijo " . htmlspecialchars($c['nombre']);
            ?>
            <li>
                <strong><?= $nombreMostrar ?></strong> (<?= $c['fecha'] ?>):
                <p><?= htmlspecialchars($c['comentario']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay comentarios aún.</p>
<?php endif; ?>

<?php if ($_SESSION['usuario']['rol'] === 'Docente'): ?>
    <a href="index.php?c=Tarea&a=listar">Volver a tareas</a>
<?php else: ?>
    <a href="index.php?c=Tarea&a=misTareas">Volver a tareas</a>
<?php endif; ?>



