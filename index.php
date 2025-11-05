<?php
session_start();

require_once __DIR__ . '/controlador/LoginController.php';
require_once __DIR__ . '/conexion.php';

// Obtener controlador y acción de la URL
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
    if ($controlador === 'Login' && $accion === 'autenticar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $loginController->autenticar($_POST);
        exit;
    } else {
        $loginController->index();
        exit;
    }
}

// --- Si hay sesión ---
$rol = $_SESSION['usuario']['rol'];
$id_usuario = $_SESSION['usuario']['id_usuario'];
$nombre_usuario = $_SESSION['usuario']['nombre_usuario'];

// --- Obtener asignaciones/cursos del usuario ---
$asignaciones = [];
$db = new Conexion();
$pdo = $db->conexion;

// Docentes: cursos que imparte
if ($rol === 'Docente') {
    $stmt = $pdo->prepare("
        SELECT cd.id_asignacion, c.nombre_curso 
        FROM cursos_docentes cd
        JOIN cursos c ON cd.id_curso = c.id_curso
        WHERE cd.id_docente = ?
    ");
    $stmt->execute([$id_usuario]);
    $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Estudiantes: cursos en los que está matriculado
elseif ($rol === 'Estudiante') {
    $stmt = $pdo->prepare("SELECT id_estudiante FROM estudiantes WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $id_estudiante = $stmt->fetchColumn();

    if ($id_estudiante) {
        $stmt = $pdo->prepare("
            SELECT a.id_asignacion, c.nombre_curso
            FROM matriculas m
            JOIN cursos_docentes a ON m.id_asignacion = a.id_asignacion
            JOIN cursos c ON a.id_curso = c.id_curso
            WHERE m.id_estudiante = ?
        ");
        $stmt->execute([$id_estudiante]);
        $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
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
    <a href="index.php?c=CatalogoCursoAsignar&a=nuevo">Agregar cursos catálogo</a>
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

    <?php if ($rol === 'Docente' || $rol === 'Administrador'): ?>
        <a href="index.php?c=Recurso&a=index">📚 Material Didáctico</a>
    <?php elseif ($rol === 'Estudiante'): ?>
        <a href="index.php?c=Recurso&a=index_estudiantes">📚 Mis Recursos</a>
    <?php endif; ?>

    <!-- Mensajes -->
    <a href="index.php?c=Mensaje&a=bandejaEntrada&id_usuario=<?= $id_usuario ?>">📥 Mensajes</a>

    <!-- Anuncios -->
    <?php if ($rol === 'Docente'): ?>
        <a href="index.php?c=Anuncio&a=index">📢 Anuncios</a>
    <?php elseif ($rol === 'Estudiante'): ?>
        <a href="index.php?c=Anuncio&a=verPorEstudiante">📢 Anuncios</a>
    <?php endif; ?>

    <?php if ($rol === 'Administrador'): ?>
    <a href="index.php?c=Reporte&a=index">📊 Reportes</a>
    <?php endif; ?>


    <a href="index.php?c=Login&a=logout">Salir</a>
</nav>

<main>
<?php
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
                switch ($controlador) {
                    case 'Mensaje':
                        $id_usuario_get = $_GET['id_usuario'] ?? $id_usuario;
                        $controller->$accion($id_usuario_get);
                        break;

                    case 'Tarea':
                        $id = $_GET['id'] ?? $_GET['id_asignacion'] ?? null;
                        $controller->$accion($id);
                        break;

                    case 'Calificacion':
                    case 'Asistencia':
                        $id_asignacion = $_GET['id_asignacion'] ?? null;
                        $controller->$accion($id_asignacion);
                        break;

                    case 'Recurso':
                    case 'Estudiante':
                    case 'Usuario':
                    case 'Docente':
                    case 'Padre':
                    case 'Curso':
                    case 'CatalogoCursoAsignar':
                    case 'Carrera':
                    case 'Matricula':
                        $controller->$accion();
                        break;

                    case 'Anuncio':
                        require_once __DIR__ . '/controlador/AnuncioController.php';
                        $controller = new AnuncioController();
                        if ($rol === 'Docente') {
                            $accionDocente = $_GET['a'] ?? 'index';
                            if (in_array($accionDocente, ['index','nuevo','guardar','archivar'])) {
                                $controller->$accionDocente();
                            } else {
                                echo "<p>Acción '$accionDocente' no válida para docente.</p>";
                            }
                        } elseif ($rol === 'Estudiante') {
                            $controller->verPorEstudiante();
                        }
                        break;

                    default:
                        $controller->$accion();
                        break;
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