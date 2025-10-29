<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Entregas</title>
    <link rel="stylesheet" href="css/estilos_tareas.css">
    <style>
        .calificacion-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Espacio entre input y texto */
            margin-bottom: 10px;
        }
        .entrega-form {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>Calificar Entregas</h1>

<?php if (!empty($entregas)): ?>
    <?php foreach ($entregas as $e): ?>
        <form method="post" class="entrega-form">
            <input type="hidden" name="id_entrega" value="<?= $e['id_entrega'] ?>">
            <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">

            <p><strong>Estudiante:</strong> <?= htmlspecialchars($e['nombres'] . ' ' . $e['apellidos']) ?></p>
            <p><strong>Enlace:</strong> <a href="<?= htmlspecialchars($e['link_drive']) ?>" target="_blank">Ver entrega</a></p>

            <div class="calificacion-container">
                <label>Calificación:</label>
                <input type="number" name="calificacion" value="<?= $e['calificacion'] ?>" step="0.01" min="0" max="<?= $valor_tarea ?>">
                <span style="font-weight:bold;">/ <?= $valor_tarea ?></span>
            </div>

            <label>Observaciones: 
                <textarea name="observaciones"><?= $e['observaciones'] ?></textarea>
            </label>

            <button type="submit">Guardar Calificación</button>
        </form>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay entregas para esta tarea.</p>
<?php endif; ?>

<a href="index.php?c=Tarea&a=listar&id_asignacion=<?= $id_asignacion ?>">Volver a Tareas</a>
</body>
</html>
