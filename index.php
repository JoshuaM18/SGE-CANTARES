<?php
ob_start();
session_start();

require_once __DIR__ . '/controlador/LoginController.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/controlador/NotificacionController.php';

// --- Obtener controlador y acción ---
$controlador = $_GET['c'] ?? 'Login';
$accion = $_GET['a'] ?? 'index';

// --- Instanciar controladores ---
$loginController = new LoginController();
$notificacionController = new NotificacionController();

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

// --- Datos de sesión ---
$rol = $_SESSION['usuario']['rol'];
$id_usuario = $_SESSION['usuario']['id_usuario'];
$nombre_usuario = $_SESSION['usuario']['nombre_usuario'];

// --- Obtener asignaciones/cursos ---
$asignaciones = [];
$db = new Conexion();
$pdo = $db->conexion;

if ($rol === 'Docente') {
    $stmt = $pdo->prepare("
        SELECT cd.id_asignacion, c.nombre_curso 
        FROM cursos_docentes cd
        JOIN cursos c ON cd.id_curso = c.id_curso
        WHERE cd.id_docente = ?
    ");
    $stmt->execute([$id_usuario]);
    $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($rol === 'Estudiante') {
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

// --- Contar notificaciones no leídas ---
$totalNoLeidas = $notificacionController->contarNoLeidas($id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema de Gestión Educativa</title>
<link rel="stylesheet" href="css/estilos_index.css">
<style>
.campana { position: relative; cursor: pointer; font-size: 24px; display: inline-block; margin-left: 10px; }
.campana .contador { position: absolute; top: -8px; right: -10px; background: red; color: white; font-size: 12px; padding: 2px 6px; border-radius: 50%; font-weight: bold; }
@keyframes campanaTimbra { 0% { transform: rotate(0deg); } 15% { transform: rotate(15deg); } 30% { transform: rotate(-10deg); } 45% { transform: rotate(10deg); } 60% { transform: rotate(-5deg); } 75% { transform: rotate(5deg); } 100% { transform: rotate(0deg); } }
.campana.nueva { animation: campanaTimbra 1s ease-in-out 3; }

#dropdownNotificaciones { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 1000; }
#dropdownNotificaciones .contenido { position: absolute; top: 80px; right: 20px; width: 320px; max-height: 80%; background: #fff; border-radius: 6px; overflow-y: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.3); padding: 10px; }
#dropdownNotificaciones .item { padding: 10px; border-bottom: 1px solid #eee; }
#dropdownNotificaciones .item:last-child { border-bottom: none; }
#dropdownNotificaciones .item a { text-decoration: none; color: #333; display: block; }
#dropdownNotificaciones .item a:hover { background: #f0f0f0; }
#dropdownNotificaciones .item.no-leida a { font-weight: bold; background: #f9f9f9; }
</style>
</head>
<body>

<header>
<h2>Liceo Cristiano Cantares</h2>
<div class="usuario">
    Usuario: <?= htmlspecialchars($nombre_usuario) ?> (<?= $rol ?>)
    <div class="campana <?= $totalNoLeidas > 0 ? 'nueva' : '' ?>" onclick="toggleDropdown();">
        🔔
        <?php if ($totalNoLeidas > 0): ?>
            <span class="contador"><?= $totalNoLeidas ?></span>
        <?php endif; ?>
    </div>
</div>
</header>

<!-- Dropdown Notificaciones -->
<div id="dropdownNotificaciones">
    <div class="contenido">
        <?php
        $notificaciones = $notificacionController->verNotificaciones($id_usuario);
        if (!empty($notificaciones)):
            foreach ($notificaciones as $notif):
        ?>
            <div class="item <?= $notif['leido'] ? '' : 'no-leida' ?>">
                <a href="index.php?c=Notificacion&a=leerNotificacion&id_notificacion=<?= $notif['id_notificacion'] ?>">
                    <strong><?= htmlspecialchars($notif['titulo']) ?></strong><br>
                    <small><?= htmlspecialchars($notif['mensaje']) ?></small>
                </a>
            </div>
        <?php endforeach; else: ?>
            <div class="item">No hay notificaciones</div>
        <?php endif; ?>
    </div>
</div>

<nav>
    <?php if ($rol === 'Administrador'): ?>
        <a href="index.php?c=Estudiante&a=index">Estudiantes</a>
        <a href="index.php?c=Usuario&a=index">Usuarios</a>
        <a href="index.php?c=Docente&a=index">Docentes</a>
        <a href="index.php?c=Padre&a=index">Padres</a>
        <a href="index.php?c=Curso&a=index">Cursos</a>
        <a href="index.php?c=CatalogoCursoAsignar&a=nuevo">Catálogo</a>
        <a href="index.php?c=Carrera&a=index">Carreras</a>
        <a href="index.php?c=Matricula&a=index">Matrículas</a>
        <a href="index.php?c=CursoDocente&a=index">Asignar Docentes</a>
        <a href="index.php?c=CarreraCurso&a=index">Cursos-Carrera</a>
        <a href="index.php?c=Tarea&a=index">Tareas</a>
        <a href="index.php?c=Calificacion&a=index">Calificaciones</a>
        <a href="index.php?c=Asistencia&a=index">Asistencias</a>
        <a href="index.php?c=Recurso&a=index">📚 Material Didáctico</a>
        <a href="index.php?c=Anuncio&a=index">📢 Anuncios</a>
        <a href="index.php?c=Reporte&a=index">📊 Reportes</a>

    <?php elseif ($rol === 'Docente'): ?>
        <a href="index.php?c=Tarea&a=index">Tareas</a>
        <a href="index.php?c=Calificacion&a=index">Calificaciones</a>
        <a href="index.php?c=Asistencia&a=index">Asistencias</a>
        <a href="index.php?c=Recurso&a=index">📚 Material Didáctico</a>
        <a href="index.php?c=Anuncio&a=index">📢 Anuncios</a>

    <?php elseif ($rol === 'Estudiante'): ?>
        <a href="index.php?c=Tarea&a=misTareas">Mis Tareas</a>
        <a href="index.php?c=Recurso&a=index_estudiantes">📚 Mis Recursos</a>
        <a href="index.php?c=Anuncio&a=verPorEstudiante">📢 Anuncios</a>
    <?php endif; ?>

    <a href="index.php?c=Mensaje&a=bandejaEntrada&id_usuario=<?= $id_usuario ?>">📥 Mensajes</a>
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
                // Control exacto para evitar confusión de controladores
                switch ($controlador) {
                    case 'Asistencia':
                    case 'Tarea':
                    case 'Calificacion':
                        $controller->$accion();
                        break;
                    case 'Mensaje':
                        $id_param = $_GET['id_usuario'] ?? $id_usuario;
                        $controller->$accion($id_param);
                        break;
                    case 'Reporte':
                        $data = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
                        $controller->$accion($data);
                        break;
                    default:
                        $controller->$accion();
                        break;
                }
            }
        } else {
            echo "<p>Acción '$accion' no válida en '$controlador'.</p>";
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

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownNotificaciones');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('dropdownNotificaciones');
    const campana = document.querySelector('.campana');
    const contenido = document.querySelector('#dropdownNotificaciones .contenido');
    if (dropdown.style.display === 'block' &&
        !campana.contains(event.target) &&
        !contenido.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script>

</body>
</html>

<?php ob_end_flush(); ?>
