<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestión Educativa</title>
    <link rel="stylesheet" href="css/estilos_login.css">
</head>
<body>
    <!-- Contenedor Izquierdo: Formulario -->
    <div class="login-container">
        <form action="index.php?c=Login&a=autenticar" method="POST">
            <h2>Iniciar sesión</h2>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            
            <label for="nombre_usuario">Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required autocomplete="username">
            
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required autocomplete="current-password">
            
            <button type="submit">Ingresar</button>
        </form>
    </div>

    <!-- Contenedor Derecho: Slideshow -->
    <div class="slideshow-container">
        <div class="background-slideshow">
            <div class="bg-slide-1"></div>
            <div class="bg-slide-2"></div>
            <div class="bg-slide-3"></div>
            <div class="bg-slide-4"></div>
            <div class="bg-slide-5"></div>
            <div class="bg-slide-6"></div>
            <div class="bg-slide-7"></div>
            <div class="bg-slide-8"></div>
            <div class="bg-slide-9"></div>
        </div>
        
        <!-- Overlay decorativo -->
        <div class="background-overlay"></div>
        
        <!-- Círculos decorativos -->
        <div class="circle-decoration"></div>
        <div class="circle-decoration"></div>
    </div>
</body>
</html>