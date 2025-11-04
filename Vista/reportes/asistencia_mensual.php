<h2>Reporte de Asistencia Mensual</h2>
<form method="GET" action="index.php">
    <input type="hidden" name="c" value="Reporte">
    <input type="hidden" name="a" value="asistenciaMensual">
    
    <label>Mes (1-12):</label><br>
    <input type="number" name="mes" min="1" max="12" required><br><br>
    
    <label>Año:</label><br>
    <input type="number" name="anio" min="2000" max="<?= date('Y') ?>" required><br><br>
    
    <button type="submit">Generar PDF</button>
</form>
