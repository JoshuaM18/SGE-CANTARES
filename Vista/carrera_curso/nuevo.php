<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Cursos a Carrera</title>
    <link rel="stylesheet" href="css/carrera.css">
    <style>
        /* General */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* Formulario */
        form {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: 20px auto;
        }

        /* Acordeón */
        .accordion {
            cursor: pointer;
            padding: 10px 15px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: background-color 0.3s;
            font-size: 18px;
            background-color: #0066cc;
            color: #fff;
            border-radius: 5px;
            margin-top: 15px;
        }

        .accordion:hover {
            background-color: #004a99;
        }

        .panel {
            padding: 10px 15px;
            display: none;
            background-color: #f1f1f1;
            border-radius: 0 0 5px 5px;
            margin-bottom: 10px;
        }

        /* Labels e Inputs */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="number"], select {
            padding: 8px 10px;
            margin-bottom: 15px;
            width: 100%;
            max-width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="checkbox"] {
            margin-right: 8px;
        }

        .curso-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .curso-item label {
            flex: 1;
        }

        .curso-item select {
            flex: 1;
            max-width: 200px;
        }

        /* Botón */
        button {
            padding: 10px 20px;
            background-color: #0066cc;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004a99;
        }

        /* Enlaces */
        a {
            color: #0066cc;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Asignar Cursos a Carrera</h1>

<form action="index.php?c=CarreraCurso&a=guardar" method="POST">

    <label>Año Académico:</label>
    <input type="number" name="anio_academico" min="2000" max="2100" required><br><br>

    <?php
    // Agrupar cursos por carrera
    $cursosPorCarrera = [];
    if (!empty($cursos)) {
        foreach ($cursos as $c) {
            $idCarrera = $c['id_carrera'] ?? 0;
            $nombreCarrera = $c['nombre_carrera'] ?? 'Carrera desconocida';
            $cursosPorCarrera[$idCarrera]['nombre_carrera'] = $nombreCarrera;
            $cursosPorCarrera[$idCarrera]['cursos'][] = $c;
        }
    }
    ?>

    <?php if (!empty($cursosPorCarrera)): ?>
        <?php foreach ($cursosPorCarrera as $carrera): ?>
            <button type="button" class="accordion"><?= htmlspecialchars($carrera['nombre_carrera']) ?></button>
            <div class="panel">
                <?php foreach ($carrera['cursos'] as $curso): ?>
                    <div class="curso-item">
                        <label>
                            <input type="checkbox" name="id_curso[]" value="<?= $curso['id_curso'] ?>">
                            <?= htmlspecialchars($curso['nombre_curso'] ?? 'Curso desconocido') ?>
                        </label>
                        <label>
                            Docente:
                            <select name="docente_<?= $curso['id_curso'] ?>">
                                <?php foreach($docentes as $d): ?>
                                    <option value="<?= $d['id_docente'] ?>"><?= htmlspecialchars($d['nombres'].' '.$d['apellidos']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay cursos disponibles.</p>
    <?php endif; ?>

    <br>
    <button type="submit">Guardar Asignaciones</button>
</form>

<a href="index.php?c=CarreraCurso&a=index">Volver al listado</a>

<script>
    // Script para el acordeón
    var acc = document.getElementsByClassName("accordion");
    for (var i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>

</body>
</html>
