<h2>Reporte de Matrículas por Curso</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="c" value="Reporte">
    <input type="hidden" name="a" value="matriculasPorCurso">
    
    <label>Seleccionar Curso (ID):</label><br>
    <input type="number" name="id_curso" required><br><br>
    
    <button type="submit">Generar PDF</button>
</form>
