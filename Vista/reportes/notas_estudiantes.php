<h2>Reporte de Notas por Estudiante</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="c" value="Reporte">
    <input type="hidden" name="a" value="notasPorEstudiante">
    
    <label>Seleccionar Estudiante (ID):</label><br>
    <input type="number" name="id_estudiante" required><br><br>
    
    <button type="submit">Generar PDF</button>
</form>
