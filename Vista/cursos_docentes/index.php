<head>
     <link rel="stylesheet" href="css/cdocente.css">
</head>

<h1>Asignaciones de Docentes a Cursos</h1>
<a href="index.php?c=CursoDocente&a=nuevo">Nueva Asignación</a>
<br><br>

<?php
$ultimaCarrera = null;

if (!empty($asignaciones)) {
    foreach ($asignaciones as $a) {

        // Si cambia la carrera, cerramos la tabla anterior y abrimos nueva
        if ($ultimaCarrera !== $a['nombre_carrera']) {
            // Cerrar tabla anterior solo si existía
            if ($ultimaCarrera !== null) {
                echo "</table><br>";
            }

            $ultimaCarrera = $a['nombre_carrera'];
            $idCarrera = preg_replace('/\s+/', '_', $ultimaCarrera); // id seguro para HTML

            // Título de carrera clicable
            echo "<h2 style='cursor:pointer;' onclick=\"toggleTabla('$idCarrera')\">";
            echo htmlspecialchars($ultimaCarrera);
            echo "</h2>";

            // Abrir nueva tabla
            echo "<table border='1' id='$idCarrera' style='display:none;'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Docente</th>
                    <th>Año Académico</th>
                    <th>Acciones</th>
                  </tr>";
        }

        // Fila de asignación
        echo "<tr>
                <td>{$a['id_asignacion']}</td>
                <td>" . htmlspecialchars($a['nombre_curso']) . "</td>
                <td>" . htmlspecialchars($a['nombres'] . ' ' . $a['apellidos']) . "</td>
                <td>{$a['anio_academico']}</td>
                <td>
                    <a href='index.php?c=CursoDocente&a=editar&id={$a['id_asignacion']}'>Editar</a> |
                    <a href='index.php?c=CursoDocente&a=eliminar&id={$a['id_asignacion']}' onclick=\"return confirm('¿Eliminar esta asignación?')\">Eliminar</a>
                </td>
              </tr>";
    }

    // Cerrar la última tabla después del bucle
    echo "</table>";
} else {
    echo "<p>No hay asignaciones registradas.</p>";
}
?>

<script>
function toggleTabla(id) {
    var tabla = document.getElementById(id);
    tabla.style.display = (tabla.style.display === 'none') ? 'table' : 'none';
}
</script>
