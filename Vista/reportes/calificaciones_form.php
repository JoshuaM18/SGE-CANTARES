<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Calificaciones</title>
<style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    h1 { text-align: center; }
    form { width: 400px; margin: 0 auto; }
    label { display: block; margin-top: 15px; }
    select, button { width: 100%; padding: 8px; margin-top: 5px; }
    button { background-color: #2ecc71; color: white; border: none; cursor: pointer; font-weight: bold; }
    button:hover { background-color: #27ae60; }
</style>
</head>
<body>
<h1>Reporte de Calificaciones</h1>
<form action="index.php?c=Reporte&a=generar" method="post" target="_blank">
    <label for="id_estudiante">Seleccione el alumno:</label>
    <select name="id_estudiante" id="id_estudiante" required>
        <option value="">-- Seleccione --</option>
        <?php foreach($estudiantes as $est): ?>
            <option value="<?= $est['id_estudiante'] ?>"><?= $est['nombres'].' '.$est['apellidos'] ?></option>
        <?php endforeach; ?>
    </select>

    <label for="bimestre">Seleccione el bimestre:</label>
    <select name="bimestre" id="bimestre" required>
        <option value="1">Primer Bimestre</option>
        <option value="2">Segundo Bimestre</option>
        <option value="3">Tercer Bimestre</option>
        <option value="4" selected>Cuarto Bimestre</option>
    </select>

    <label>
        <input type="checkbox" name="mostrar_nota_final" value="1">
        Mostrar Nota Final y Resultado
    </label>

    <label for="conducta">Seleccione Conducta:</label>
    <select name="conducta" id="conducta">
        <option value="EXCELENTE">EXCELENTE</option>
        <option value="BUENA" selected>BUENA</option>
        <option value="REGULAR">REGULAR</option>
        <option value="MALA">MALA</option>
    </select>

    <label for="asistencia">Seleccione Asistencia:</label>
    <select name="asistencia" id="asistencia">
        <option value="25%">25%</option>
        <option value="50%">50%</option>
        <option value="75%">75%</option>
        <option value="100%" selected>100%</option>
    </select>

    <button type="submit">Generar PDF</button>
</form>
</body>
</html>
