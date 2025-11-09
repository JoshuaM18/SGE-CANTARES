<head>
    <link rel="stylesheet" href="css/matriculas.css">
</head>
<h1>Matrículas de Estudiantes</h1>

<a href="index.php?c=Matricula&a=nuevo">Nueva Matrícula</a>
<br><br>

<?php
if (!empty($matriculas)):

    // Agrupar matrículas por carrera y curso
    $grupos = [];
    foreach ($matriculas as $m) {
        $grupos[$m['nombre_carrera']][$m['nombre_curso']][] = $m;
    }

    foreach ($grupos as $carrera => $cursos):
        $idCarrera = "carrera_" . md5($carrera);

        // Encabezado de carrera clicable
        echo "<h2 style='cursor:pointer; color:green;' onclick=\"document.getElementById('$idCarrera').classList.toggle('hidden');\">";
        echo htmlspecialchars($carrera);
        echo "</h2>";

        // Div oculto para cursos
        echo "<div id='$idCarrera' class='hidden'>";

        foreach ($cursos as $curso => $listaMatriculas):
            $idCurso = "curso_" . md5($carrera . '_' . $curso);

            // Encabezado de curso clicable
            echo "<h3 style='cursor:pointer; color:blue; margin-left:20px;' onclick=\"document.getElementById('$idCurso').classList.toggle('hidden');\">";
            echo "Curso: " . htmlspecialchars($curso);
            echo "</h3>";

            // Tabla oculta de matrículas
            echo "<table id='$idCurso' border='1' class='hidden' style='margin-left:40px;'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Docente</th>
                    <th>Año Académico</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>";

            foreach ($listaMatriculas as $m):
                ?>
                <tr>
                    <td><?= $m['id_matricula'] ?></td>
                    <td><?= htmlspecialchars($m['estudiante_nombres'].' '.$m['estudiante_apellidos']) ?></td>
                    <td><?= htmlspecialchars($m['docente_nombres'].' '.$m['docente_apellidos']) ?></td>
                    <td><?= $m['anio_academico'] ?></td>
                    <td><?= $m['estado'] ?></td>
                    <td>
                        <a href="index.php?c=Matricula&a=editar&id=<?= $m['id_matricula'] ?>">Editar</a> |
                        <a href="index.php?c=Matricula&a=eliminar&id=<?= $m['id_matricula'] ?>" onclick="return confirm('¿Eliminar esta matrícula?')">Eliminar</a>
                    </td>
                </tr>
            <?php
            endforeach;

            echo "</table><br>";

        endforeach;

        echo "</div>"; // cerrar div de cursos

    endforeach;

else:
?>
<p>No hay matrículas registradas.</p>
<?php endif; ?>

<style>
    .hidden { display: none; }
</style>
