<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Entrega</title>
    <link rel="stylesheet" href="css/verEntrega.css">
</head>
<body>
    <div class="ver-entrega-container">
        <h1>Detalle de la Entrega</h1>

        <?php if (!empty($entrega)): ?>
            <div class="fila-titulo">
                <p><strong>Título:</strong> <?= htmlspecialchars($entrega['titulo']) ?></p>
                <p class="estado-entregado">Entregado ✅</p>
                <?php if (!empty($entrega['calificacion'])): ?>
                    <p class="calificacion">Calificación: <?= htmlspecialchars($entrega['calificacion']) ?></p>
                <?php endif; ?>
            </div>

            <p><strong>Fecha de Entrega:</strong> <?= htmlspecialchars($entrega['fecha_entrega']) ?></p>
           
            <?php if (!empty($entrega['link_drive'])): ?>
                <p><strong>Enlace de Entrega:</strong> 
                    <a href="<?= htmlspecialchars($entrega['link_drive']) ?>" target="_blank">Ver archivo</a>
                </p>
            <?php endif; ?>

            <?php if (!empty($entrega['observaciones'])): ?>
                <p><strong>Observaciones:</strong> <?= htmlspecialchars($entrega['observaciones']) ?></p>
            <?php endif; ?>

            <a class="boton-volver" href="index.php?c=Tarea&a=misTareas">Volver a Mis Tareas</a>
        <?php else: ?>
            <p>No se encontró la entrega o aún no has entregado la tarea.</p>
            <a class="boton-volver" href="index.php?c=Tarea&a=misTareas">Volver a Mis Tareas</a>
        <?php endif; ?>
    </div>
</body>
</html>
