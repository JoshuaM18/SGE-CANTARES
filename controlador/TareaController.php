<?php
require_once __DIR__ . '/../modelo/TareaModelo.php';
require_once __DIR__ . '/../modelo/ComentarioModelo.php';
require_once __DIR__ . '/../service/NotificacionService.php';

class TareaController {
    private $modelo;
    private $modeloComentario;
    private $notificacionService;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->modelo = new TareaModelo();
        $this->modeloComentario = new ComentarioModelo();
        $this->notificacionService = new NotificacionService();
    }

    // --- Crear tarea (Docente) ---
    public function crear() {
        if ($_SESSION['usuario']['rol'] !== 'Docente') {
            $_SESSION['mensaje_error'] = "No tiene permisos para crear tareas.";
            header("Location: index.php");
            exit;
        }

        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocentePorUsuario($id_usuario);
        if (!$id_docente) {
            $_SESSION['mensaje_error'] = "No se encontró el docente.";
            header("Location: index.php");
            exit;
        }

        $cursos = $this->modelo->obtenerCursosPorDocente($id_docente);
        if (empty($cursos)) {
            $_SESSION['mensaje_error'] = "No tiene cursos asignados.";
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_asignacion = $_POST['id_asignacion'] ?? null;
            $titulo = $_POST['titulo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $fecha_entrega = $_POST['fecha_entrega'] ?? '';
            $valor_tarea = $_POST['valor_tarea'] ?? 0;

            if (!$id_asignacion || !$titulo || !$fecha_entrega) {
                $_SESSION['mensaje_error'] = "Datos incompletos para crear la tarea.";
                header("Location: index.php?c=Tarea&a=crear");
                exit;
            }

            $id_tarea = $this->modelo->insertarTarea($id_asignacion, $titulo, $descripcion, $fecha_entrega, $valor_tarea);

            $id_curso = $this->modelo->obtenerIdCursoPorAsignacion($id_asignacion);
            if ($id_curso) {
                $this->notificacionService->notificarNuevaTarea($titulo, $fecha_entrega, $id_curso);
            }

            header("Location: index.php?c=Tarea&a=listar&id_asignacion=" . $id_asignacion);
            exit;
        }

        require __DIR__ . '/../vista/tareas/crear.php';
    }

    // --- Listar tareas (Docente) ---
    public function listar() {
        if ($_SESSION['usuario']['rol'] !== 'Docente') {
            $_SESSION['mensaje_error'] = "No tiene permisos para listar tareas.";
            header("Location: index.php");
            exit;
        }

        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocentePorUsuario($id_usuario);
        $cursos_docente = $this->modelo->obtenerCursosPorDocente($id_docente);

        if (empty($cursos_docente)) {
            $_SESSION['mensaje_error'] = "No tiene cursos asignados.";
            header("Location: index.php");
            exit;
        }

        $id_asignacion = $_GET['id_asignacion'] ?? ($cursos_docente[0]['id_asignacion'] ?? null);

        $tareasPorCurso = [];
        foreach ($cursos_docente as $curso) {
            $idAsignacion = $curso['id_asignacion'];
            $tareas = $this->modelo->obtenerTareasPorAsignacion($idAsignacion);
            foreach ($tareas as &$tarea) {
                $conteo = $this->modelo->obtenerConteoEntregasPorTarea($tarea['id_tarea']);
                $tarea['calificadas'] = (int)($conteo['calificadas'] ?? 0);
                $tarea['pendientes'] = (int)($conteo['pendientes'] ?? 0);
            }
            $tareasPorCurso[$idAsignacion] = $tareas;
        }

        require __DIR__ . '/../vista/tareas/listar.php';
    }

    // --- Ver tareas del estudiante ---
    public function misTareas() {
        if ($_SESSION['usuario']['rol'] !== 'Estudiante') {
            $_SESSION['mensaje_error'] = "No tiene permisos para ver las tareas.";
            header("Location: index.php");
            exit;
        }

        $id_estudiante = $_SESSION['usuario']['id_estudiante'] ?? null;
        if (!$id_estudiante) {
            $_SESSION['mensaje_error'] = "No se encontró el estudiante en sesión.";
            header("Location: index.php");
            exit;
        }

        $cursos = $this->modelo->obtenerCursosPorEstudiante($id_estudiante);
        $tareas = $this->modelo->obtenerTareasConEstado($id_estudiante);

        $comentarios_tareas = [];
        foreach ($tareas as $tarea) {
            $comentarios_tareas[$tarea['id_tarea']] = $this->modeloComentario->obtenerComentariosPorTarea($tarea['id_tarea']);
        }

        if (empty($tareas)) {
            $mensaje = "No tienes tareas asignadas.";
            require __DIR__ . '/../vista/tareas/mis_tareas.php';
            return;
        }

        if (empty($cursos)) {
            $cursos = [];
        }

        require __DIR__ . '/../vista/tareas/mis_tareas.php';
    }

    // --- Subir entrega (Estudiante) ---
    public function entregar() {
        if ($_SESSION['usuario']['rol'] !== 'Estudiante') {
            $_SESSION['mensaje_error'] = "No tiene permisos para entregar tareas.";
            header("Location: index.php");
            exit;
        }

        $id_tarea = $_GET['id_tarea'] ?? null;
        $id_asignacion = $_GET['id_asignacion'] ?? null;

        if (!$id_tarea || !$id_asignacion) {
            $_SESSION['mensaje_error'] = "Datos incompletos.";
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $link_drive = $_POST['link_drive'] ?? '';
            if (!$link_drive) {
                $_SESSION['mensaje_error'] = "Debe proporcionar el link de la entrega.";
                header("Location: index.php?c=Tarea&a=entregar&id_tarea=$id_tarea&id_asignacion=$id_asignacion");
                exit;
            }

            $id_estudiante = $_SESSION['usuario']['id_estudiante'];
            $this->modelo->registrarEntrega($id_tarea, $id_estudiante, $link_drive);

            $info = $this->modelo->obtenerInfoEntrega($id_tarea, $id_estudiante);
            if ($info) {
                $id_docente = $info['id_docente'];
                $id_usuario_docente = $this->modelo->obtenerIdUsuarioDocente($id_docente);
                if ($id_usuario_docente) {
                    $titulo = "Nueva tarea entregada";
                    $mensaje = "El estudiante {$info['nombre_estudiante']} ha subido una tarea en la materia {$info['nombre_curso']} de la carrera {$info['nombre_carrera']}.";
                    $this->notificacionService->crearNotificacion($id_usuario_docente, $titulo, $mensaje);
                }
            }

            header("Location: index.php?c=Tarea&a=misTareas");
            exit;
        }

        require __DIR__ . '/../vista/tareas/entregar.php';
    }

    // --- Calificar entrega (Docente) ---
    public function calificar() {
        if ($_SESSION['usuario']['rol'] !== 'Docente') {
            $_SESSION['mensaje_error'] = "No tiene permisos para calificar entregas.";
            header("Location: index.php");
            exit;
        }

        $id_tarea = $_GET['id_tarea'] ?? null;
        $id_asignacion = $_GET['id_asignacion'] ?? null;

        if (!$id_tarea || !$id_asignacion) {
            $_SESSION['mensaje_error'] = "Datos incompletos para calificar.";
            header("Location: index.php");
            exit;
        }

        $curso = $this->modelo->obtenerCursoPorAsignacion($id_asignacion);
        if (!$curso) {
            $_SESSION['mensaje_error'] = "No se encontró el curso para esta asignación.";
            header("Location: index.php");
            exit;
        }

        $entregas = $this->modelo->obtenerEntregasPorTarea($id_tarea);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_entrega = $_POST['id_entrega'] ?? null;
            $calificacion = $_POST['calificacion'] ?? null;

            if ($id_entrega && $calificacion !== null) {
                $this->modelo->calificarEntrega($id_entrega, $calificacion, $_POST['observaciones'] ?? '');

                $id_alumno = $this->modelo->obtenerIdEstudiantePorEntrega($id_entrega);
                $nombre_tarea = $this->modelo->obtenerNombreTarea($id_tarea);

                $this->notificacionService->notificarCalificacion($id_alumno, $nombre_tarea, $calificacion);

                header("Location: index.php?c=Tarea&a=listar&id_asignacion=" . $_POST['id_asignacion']);
                exit();
            } else {
                $_SESSION['mensaje_error'] = "Datos de calificación incompletos.";
                header("Location: index.php?c=Tarea&a=calificar&id_tarea=$id_tarea&id_asignacion=$id_asignacion");
                exit;
            }
        }

        $mensaje = empty($entregas) ? "No hay entregas para esta tarea, o todas ya fueron calificadas." : '';
        require __DIR__ . '/../vista/tareas/calificar.php';
    }

    // --- Ver detalle de entrega (Estudiante) ---
    public function verEntrega() {
        if ($_SESSION['usuario']['rol'] !== 'Estudiante') {
            $_SESSION['mensaje_error'] = "No tiene permisos para ver la entrega.";
            header("Location: index.php");
            exit;
        }

        $id_tarea = $_GET['id_tarea'] ?? null;
        $id_estudiante = $_SESSION['usuario']['id_estudiante'] ?? null;

        if (!$id_tarea || !$id_estudiante) {
            $_SESSION['mensaje_error'] = "Datos incompletos para ver la entrega.";
            header("Location: index.php");
            exit;
        }

        $entrega = $this->modelo->obtenerEntregaPorTareaYEstudiante($id_tarea, $id_estudiante);
        if (!$entrega || empty($entrega['link_drive'])) {
            $_SESSION['mensaje_error'] = "No se encontró la entrega o aún no has entregado.";
            header("Location: index.php?c=Tarea&a=misTareas");
            exit;
        }

        require __DIR__ . '/../vista/tareas/verEntrega.php';
    }

    // --- Redirección según rol ---
    public function index() {
        if ($_SESSION['usuario']['rol'] === 'Docente') {
            header("Location: index.php?c=Tarea&a=listar");
        } else {
            header("Location: index.php?c=Tarea&a=misTareas");
        }
        exit;
    }
}
?>
