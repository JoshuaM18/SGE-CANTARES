<h2>Reporte de Docentes por Carrera</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="c" value="Reporte">
    <input type="hidden" name="a" value="docentesPorCarrera">
    
    <label>Seleccionar Carrera (ID):</label><br>
    <input type="number" name="id_carrera" required><br><br>
    
    <button type="submit">Generar PDF</button>
</form>
