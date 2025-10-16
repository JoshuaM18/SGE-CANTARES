<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entregar Tarea</title>
    <link rel="stylesheet" href="css/estilos_tareas.css">
</head>
<body>
<h1>Entregar Tarea</h1>

<?php if (!empty($curso)): ?>
    <div class="info-curso">
        <strong>Curso:</strong> <?= htmlspecialchars($curso['nombre_curso']) ?><br>
        <strong>Carrera:</strong> <?= htmlspecialchars($curso['nombre_carrera']) ?><br>
        <strong>Año:</strong> <?= htmlspecialchars($curso['anio_academico']) ?><br>
        <strong>Semestre:</strong> <?= htmlspecialchars($curso['semestre']) ?>
    </div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="id_tarea" value="<?= $id_tarea ?>">
    <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">
    
    <label for="link_drive">Enlace de entrega (Drive, etc.): 
        <input type="url" id="link_drive" name="link_drive" required placeholder="https://drive.google.com/...">
    </label>
    
    <button type="submit">Subir Entrega</button>
</form>

<a href="index.php?c=Tarea&a=listar&id_asignacion=<?= $id_asignacion ?>">Volver a Lista de Tareas</a>
</body>
</html>