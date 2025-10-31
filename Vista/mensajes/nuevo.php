<h2>Nuevo Mensaje</h2>
<form method="POST" action="index.php?c=Mensaje&a=nuevo">
    <input type="hidden" name="id_remitente" value="1"> <!-- Cambiar por usuario en sesión -->
    <label>Destinatario (ID Usuario):</label>
    <input type="number" name="id_destinatario" required><br>
    <label>Asunto:</label>
    <input type="text" name="asunto" required><br>
    <label>Contenido:</label>
    <textarea name="contenido" required></textarea><br>
    <button type="submit">Enviar</button>
</form>
