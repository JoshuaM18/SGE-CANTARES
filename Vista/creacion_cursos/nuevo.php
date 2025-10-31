<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nuevo Curso</title>
<style>
body { font-family: Arial, sans-serif; background: #f5f6f8; padding: 30px; }
form { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
input, textarea { width: 100%; padding: 10px; margin: 8px 0; }
button { background: #0C2340; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; }
button:hover { background: #1d4ed8; }
a { text-decoration: none; color: #0C2340; }
</style>
</head>
<body>

<h1>Crear Nuevo Curso</h1>

<form action="index.php?c=NuevoCurso&a=guardar" method="POST">
    <label>Nombre del Curso:</label>
    <input type="text" name="nombre_curso" required>

    <label>Descripción:</label>
    <textarea name="descripcion" rows="4"></textarea>

    <button type="submit">Guardar Curso</button>
    <a href="index.php?c=NuevoCurso&a=index">Cancelar</a>
</form>

</body>
</html>
