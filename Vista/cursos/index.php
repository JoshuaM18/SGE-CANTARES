<!DOCTYPE html>
<html>
<head>
    <title>Cursos por Carrera</title>
</head>
<body>
    <h1>Cursos</h1>

    <a href="index.php?c=Curso&a=nuevo">Agregar Nuevo Curso</a>
    <a href="index.php">Volver al menú</a>

    <?php
    // Agrupar cursos por carrera
    $carreras = [];
    foreach ($cursos as $c) {
        $carreras[$c['nombre_carrera']][] = $c;
    }
    ?>

    <?php if (!empty($carreras)): ?>
        <?php foreach ($carreras as $nombreCarrera => $cursosCarrera): ?>
            <details>
                <summary><b><?= $nombreCarrera ?></b></summary>
                <table border="1" cellpadding="5" cellspacing="0" style="margin-top:5px; margin-bottom:10px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursosCarrera as $c): ?>
                            <tr>
                                <td><?= $c['id_curso'] ?></td>
                                <td><?= $c['nombre_curso'] ?></td>
                                <td><?= $c['descripcion'] ?></td>
                                <td>
                                    <a href="index.php?c=Curso&a=editar&id=<?= $c['id_curso'] ?>">Editar</a> |
                                    <a href="index.php?c=Curso&a=eliminar&id=<?= $c['id_curso'] ?>" onclick="return confirm('¿Eliminar curso?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay cursos registrados.</p>
    <?php endif; ?>
</body>
</html>
