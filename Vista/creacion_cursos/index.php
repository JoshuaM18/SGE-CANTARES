<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Creación de Cursos</title>
<style>
body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 30px; }
h1 { color: #0C2340; }
table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; border-radius: 8px; overflow: hidden; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
th { background: #0C2340; color: white; }
.btn { padding: 6px 12px; background: #0C2340; color: white; border-radius: 5px; text-decoration: none; }
.btn:hover { background: #1d4ed8; }
</style>
</head>
<body>

<h1>Gestión de Creación de Cursos</h1>

<a href="index.php?c=NuevoCurso&a=nuevo" class="btn">➕ Crear Nuevo Curso</a>
<br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre del Curso</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($cursos as $curso): ?>
    <tr>
        <td><?= $curso['id_catalogo_curso'] ?></td>
        <td><?= htmlspecialchars($curso['nombre_curso']) ?></td>
        <td><?= htmlspecialchars($curso['descripcion']) ?></td>
        <td>
            <a href="index.php?c=NuevoCurso&a=eliminar&id=<?= $curso['id_catalogo_curso'] ?>" onclick="return confirm('¿Deseas eliminar este curso?')">🗑️ Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
