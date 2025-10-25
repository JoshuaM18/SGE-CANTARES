<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas</title>
    <link rel="stylesheet" href="css/cards.css">
</head>
<body>
    <h1>Mis Tareas</h1>

    <?php if (!empty($tareas)): ?>
        <div class="cards-container">
            <?php foreach ($tareas as $tarea): ?>
                <?php
                    // Determinar estado y clase para el card
                    if ($tarea['id_entrega'] !== null) {
                        $estado = "Entregado";
                        $class = "entregado";
                    } else {
                        $estado = "Pendiente";
                        $class = "pendiente";
                    }
                ?>
                <div class="card <?= $class ?>">
                    <h3><?= htmlspecialchars($tarea['titulo']) ?></h3>
                    <p><strong>Curso:</strong> <?= htmlspecialchars($tarea['nombre_curso']) ?></p>
                    <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($tarea['fecha_entrega']) ?></p>
                    <p class="estado"><strong>Estado:</strong> <?= $estado ?></p>

                    <?php if ($estado === "Pendiente"): ?>
                        <a href="index.php?c=Tarea&a=entregar&id_tarea=<?= $tarea['id_tarea'] ?>&id_asignacion=<?= $tarea['id_asignacion'] ?>">Entregar</a>
                    <?php else: ?>
                        <a href="index.php?c=Tarea&a=verEntrega&id_tarea=<?= $tarea['id_tarea'] ?>">Ver Entrega</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tienes tareas asignadas.</p>
    <?php endif; ?>
</body>
</html>
