<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
    <link rel="stylesheet" href="css/estilos_tareas.css">
</head>
<body>
<h1>Crear Tarea</h1>

<form method="post">
    <label for="id_asignacion">Curso / Carrera:
        <select id="id_asignacion" name="id_asignacion" required>
            <option value="">-- Seleccionar Curso --</option>
            <?php foreach($cursos as $c): ?>
                <option value="<?= $c['id_asignacion'] ?>">
                    <?= htmlspecialchars($c['nombre_curso'] . " - " . $c['nombre_carrera'] . " (Año " . $c['anio_academico'] . ", Sem " . $c['semestre'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label for="titulo">Título: 
        <input type="text" id="titulo" name="titulo" required>
    </label>

    <label for="descripcion">Descripción: 
        <textarea id="descripcion" name="descripcion"></textarea>
    </label>

    <label for="fecha_entrega">Fecha de entrega: 
        <input type="date" id="fecha_entrega" name="fecha_entrega" required>
    </label>

    <!-- 🔹 Nuevo campo para el valor de la tarea -->
    <label for="valor_tarea">Valor de la tarea (puntos):
        <input type="number" id="valor_tarea" name="valor_tarea" min="0" step="0.01" required>
    </label>

    <button type="submit">Crear Tarea</button>
</form>

<a href="index.php?c=Tarea&a=listar&id_asignacion=<?= $cursos[0]['id_asignacion'] ?? '' ?>">Volver a Lista de Tareas</a>
</body>
</html>
