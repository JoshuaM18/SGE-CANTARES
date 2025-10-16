<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresar Notas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        input[type="number"] { width: 60px; }
        textarea { width: 100%; height: 40px; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
        button { padding: 5px 10px; margin-top: 10px; }
        .info-curso { font-weight: bold; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Ingresar Notas</h1>

    <?php if(!empty($notas)): ?>
        <?php 
            // Tomamos la información del primer registro para mostrar curso y semestre
            $curso_nombre = $notas[0]['nombre_curso'];
            $anio_academico = $notas[0]['anio_academico'];
            $semestre = $notas[0]['semestre'];
            // Si tienes carrera en el SP, también podrías mostrar $notas[0]['nombre_carrera']
        ?>
        <div class="info-curso">
            Curso: <?= htmlspecialchars($curso_nombre) ?> - Año: <?= $anio_academico ?> - Semestre: <?= $semestre ?>
        </div>

        <form action="index.php?c=Calificacion&a=guardar" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Nota</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($notas as $n): ?>
                        <tr>
                            <td><?= htmlspecialchars($n['estudiante_nombres'] . ' ' . $n['estudiante_apellidos']) ?></td>
                            <td>
                                <input type="hidden" name="id_matricula[]" value="<?= $n['id_matricula'] ?>">
                                <input type="number" step="0.01" name="nota[]" value="<?= htmlspecialchars($n['nota']) ?>">
                            </td>
                            <td>
                                <textarea name="observaciones[]"><?= htmlspecialchars($n['observaciones']) ?></textarea>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="hidden" name="id_asignacion" value="<?= $id_asignacion ?>">
            <button type="submit">Guardar Notas</button>
        </form>
    <?php else: ?>
        <p>No hay estudiantes asignados a este curso.</p>
    <?php endif; ?>

    <br>
    <a href="index.php?c=Calificacion&a=index">Volver a Cursos Asignados</a>
</body>
</html>
