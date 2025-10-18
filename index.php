<?php
session_start();

require_once __DIR__ . '/controlador/LoginController.php';

$controlador = $_GET['c'] ?? 'Login';
$accion = $_GET['a'] ?? 'index';

// --- Instanciar controlador de login ---
$loginController = new LoginController();

// --- Logout ---
if ($controlador === 'Login' && $accion === 'logout') {
    $loginController->logout();
    exit;
}

// --- Si no hay sesión ---
if (!isset($_SESSION['usuario'])) {
    // Si se envió el formulario de login
    if ($controlador === 'Login' && $accion === 'autenticar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $loginController->autenticar($_POST);
        exit;
    } else {
        $loginController->index();
        exit;
    }
}

// --- Si hay sesión, mostrar menú ---
$rol = $_SESSION['usuario']['rol'];
$nombre_usuario = $_SESSION['usuario']['nombre_usuario'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión Educativa</title>
    <link rel="stylesheet" href="css/estilos_index.css">
</head>
<body>

<header>
    <h2>Liceo Cristiano Cantares</h2>
    <div class="usuario">
        Usuario: <?= htmlspecialchars($nombre_usuario) ?> (<?= $rol ?>)
    </div>
</header>

<?php
// Mostrar mensaje de bienvenida si existe
if (isset($_SESSION['mensaje_login'])) {
    echo "<div class='mensaje-bienvenida'>" . htmlspecialchars($_SESSION['mensaje_login']) . "</div>";
    unset($_SESSION['mensaje_login']);
}
?>

<nav>
    <a href="index.php?c=Estudiante&a=index">Estudiantes</a>
    <a href="index.php?c=Usuario&a=index">Usuarios</a>
    <a href="index.php?c=Docente&a=index">Docentes</a>
    <a href="index.php?c=Padre&a=index">Padres</a>
    <a href="index.php?c=Curso&a=index">Cursos</a>
    <a href="index.php?c=Carrera&a=index">Carreras</a>
    <a href="index.php?c=Matricula&a=index">Matrículas</a>

    <?php if ($rol === 'Administrador'): ?>
        <a href="index.php?c=CursoDocente&a=index">Asignar Docente a Curso</a>
    <?php endif; ?>

    <?php if ($rol === 'Docente'): ?>
        <a href="index.php?c=Tarea&a=listar&id_asignacion=1">Tareas</a>
    <?php elseif ($rol === 'Estudiante'): ?>
        <a href="index.php?c=Tarea&a=misTareas">Mis Tareas</a>
    <?php endif; ?>

    <?php if ($rol === 'Docente' || $rol === 'Administrador'): ?>
        <a href="index.php?c=Calificacion&a=index">Calificaciones</a>
        <a href="index.php?c=Asistencia&a=index">Asistencias</a>
    <?php endif; ?>

    <a href="index.php?c=Login&a=logout">Salir</a>
</nav>

<main>
<?php
// --- Cargar controlador dinámico ---
if ($controlador !== 'Login') {
    $archivo_controlador = __DIR__ . "/controlador/{$controlador}Controller.php";
    if (file_exists($archivo_controlador)) {
        require_once $archivo_controlador;
        $nombreClase = $controlador . "Controller";
        $controller = new $nombreClase();

        if (method_exists($controller, $accion)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->$accion($_POST);
            } else {
                $id = $_GET['id'] ?? null;
                if (in_array($accion, ['editar', 'eliminar'])) {
                    if ($id !== null) {
                        $controller->$accion($id);
                    } else {
                        echo "<p>Error: No se proporcionó ID para la acción '$accion'.</p>";
                    }
                } else {
                    $controller->$accion();
                }
            }
        } else {
            echo "<p>Acción '$accion' no válida.</p>";
        }
    } else {
        echo "<p>El controlador '$controlador' no existe.</p>";
    }
}
?>
</main>

<footer>
    © <?= date('Y') ?> Liceo Cristiano Cantares | Sistema de Gestión Educativa
</footer>

</body>
</html>
