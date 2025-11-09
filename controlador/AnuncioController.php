<?php
require_once __DIR__ . '/NotificacionController.php';
require_once __DIR__ . '/../modelo/AnuncioModelo.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class AnuncioController {
    private $modelo;
    private $notificacionController;
    private $usuarioModelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new AnuncioModelo();
        $this->notificacionController = new NotificacionController();
        $this->usuarioModelo = new UsuarioModelo();
    }

    // --- Mostrar anuncios por curso (Docente) ---
    public function index() {
        $id_usuario = $_SESSION['usuario']['id_usuario'];

        // Obtener id_docente del usuario logueado
        $stmt = $this->modelo->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $docente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$docente) {
            echo "No se encontró el docente asociado al usuario.";
            return;
        }

        $id_docente = $docente['id_docente'];
        $cursos = $this->modelo->obtenerCursosDocente($id_docente);

        $id_curso = $_GET['id_curso'] ?? null;
        $anuncios = [];
        $cursoSeleccionado = null;

        if ($id_curso) {
            $anuncios = $this->modelo->obtenerAnunciosPorCurso($id_curso);
            $cursoSeleccionado = $this->modelo->obtenerCursoPorId($id_curso);
        }

        // Obtener anuncios generales visibles para todos
        $anunciosGenerales = $this->modelo->obtenerAnunciosGenerales();

        require __DIR__ . '/../vista/anuncio/index.php';
    }

    // --- Mostrar formulario para crear un anuncio ---
    public function nuevo() {
        $id_curso = $_GET['id_curso'] ?? null;

        $cursoSeleccionado = null;
        if ($id_curso) {
            $cursoSeleccionado = $this->modelo->obtenerCursoPorId($id_curso);
        }

        $id_usuario = $_SESSION['usuario']['id_usuario'] ?? null;
        $docente = null;
        if ($id_usuario) {
            $stmt = $this->modelo->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            $docente = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $cursos = $this->modelo->obtenerCursosDocente($docente['id_docente'] ?? 0);

        require __DIR__ . '/../vista/anuncio/nuevo.php';
    }

   // --- Guardar anuncio nuevo y crear notificaciones ---
public function guardar() {
    $titulo = $_POST['titulo'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $id_curso = $_POST['id_curso'] ?? null;

    // Si no hay curso seleccionado, es un anuncio general
    $es_general = empty($id_curso) ? 1 : 0;

    $id_usuario = $_SESSION['usuario']['id_usuario'];
    $stmt = $this->modelo->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $docente = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_docente = $docente['id_docente'] ?? null;

    if (!$titulo || !$descripcion) {
        echo "Faltan datos para guardar el anuncio.";
        return;
    }

    // Guardar anuncio
    $stmt = $this->modelo->db->conexion->prepare("
        INSERT INTO anuncios (id_curso, id_docente, titulo, descripcion, fecha_publicacion, estado, es_general)
        VALUES (?, ?, ?, ?, NOW(), 'Activo', ?)
    ");
    $stmt->execute([$id_curso ?: null, $id_docente, $titulo, $descripcion, $es_general]);

    // 🔹 Crear notificaciones
    if ($es_general) {
        $alumnos = $this->usuarioModelo->obtenerTodosEstudiantes();
    } else {
        $alumnos = $this->usuarioModelo->obtenerAlumnosPorCurso($id_curso);
    }

    foreach ($alumnos as $alumno) {
        // Ajuste importante: determinar correctamente el ID de usuario
        $id_usuario_destino = $alumno['id_usuario'] ?? $alumno['id_estudiante'];
        if ($id_usuario_destino) {
            $titulo_notif = "Nuevo anuncio";
            $mensaje_notif = "Se ha publicado un nuevo anuncio: '{$titulo}'. {$descripcion}";
            $this->notificacionController->crearNotificacion($id_usuario_destino, $titulo_notif, $mensaje_notif);
        }
    }

    // Redirigir
    if ($id_curso && !$es_general) {
        header("Location: index.php?c=Anuncio&a=index&id_curso={$id_curso}");
    } else {
        header("Location: index.php?c=Anuncio&a=index");
    }
    exit();
}


    // --- Archivar un anuncio ---
    public function archivar() {
        $id_anuncio = $_GET['id_anuncio'] ?? null;
        $id_curso = $_GET['id_curso'] ?? null;

        if (!$id_anuncio) {
            echo "Falta el parámetro id_anuncio.";
            return;
        }

        $this->modelo->archivarAnuncio($id_anuncio);

        if ($id_curso) {
            header("Location: index.php?c=Anuncio&a=index&id_curso={$id_curso}");
        } else {
            header("Location: index.php?c=Anuncio&a=index");
        }
        exit();
    }

    // --- Mostrar anuncios para estudiantes ---
    public function verPorEstudiante() {
        $id_estudiante = $_SESSION['usuario']['id_estudiante'] ?? null;

        if (!$id_estudiante) {
            echo "No se encontró el estudiante logueado.";
            return;
        }

        $stmt = $this->modelo->db->conexion->prepare("
            SELECT c.id_curso, c.nombre_curso, ca.nombre_carrera
            FROM matriculas m
            JOIN cursos_docentes cd ON m.id_asignacion = cd.id_asignacion
            JOIN cursos c ON cd.id_curso = c.id_curso
            JOIN carreras ca ON c.id_carrera = ca.id_carrera
            WHERE m.id_estudiante = ?
            GROUP BY c.id_curso
        ");
        $stmt->execute([$id_estudiante]);
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $id_curso = $_GET['id_curso'] ?? ($cursos[0]['id_curso'] ?? null);
        $anuncios = $id_curso ? $this->modelo->obtenerAnunciosPorCurso($id_curso) : [];

        // Anuncios generales visibles para todos
        $anunciosGenerales = $this->modelo->obtenerAnunciosGenerales();

        require __DIR__ . '/../vista/anuncio/ver_estudiante.php';
    }
}
?>
