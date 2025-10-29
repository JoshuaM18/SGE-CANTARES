<?php 
require_once __DIR__ . '/../modelo/TareaModelo.php';

class TareaController {
    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new TareaModelo();
    }

    // --- Crear tarea (Docente) ---
    public function crear() {
        if ($_SESSION['usuario']['rol'] !== 'Docente') {
            echo "No tiene permisos para crear tareas.";
            return;
        }

        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocentePorUsuario($id_usuario);

        if (!$id_docente) {
            echo "No se encontró el docente.";
            return;
        }

        $cursos = $this->modelo->obtenerCursosPorDocente($id_docente);

        if (empty($cursos)) {
            echo "No tiene cursos asignados.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_asignacion = $_POST['id_asignacion'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha_entrega = $_POST['fecha_entrega'];
            $valor_tarea = $_POST['valor_tarea'];

            $this->modelo->insertarTarea($id_asignacion, $titulo, $descripcion, $fecha_entrega, $valor_tarea);

            header("Location: index.php?c=Tarea&a=listar&id_asignacion=" . $id_asignacion);
            exit;
        }

        require __DIR__ . '/../vista/tareas/crear.php';
    }

    // --- Listar tareas de un curso ---
    public function listar() {
        $id_asignacion = $_GET['id_asignacion'] ?? null;

        // Para docentes, obtener todos los cursos asignados
        $cursos_docente = [];
        if ($_SESSION['usuario']['rol'] === 'Docente') {
            $id_usuario = $_SESSION['usuario']['id_usuario'];
            $id_docente = $this->modelo->obtenerIdDocentePorUsuario($id_usuario);
            $cursos_docente = $this->modelo->obtenerCursosPorDocente($id_docente);
            if (!$id_asignacion && !empty($cursos_docente)) {
                $id_asignacion = $cursos_docente[0]['id_asignacion'];
            }
        }

        if (!$id_asignacion) {
            echo "No se ha seleccionado un curso.";
            return;
        }

        $tareas = $this->modelo->obtenerTareasPorAsignacion($id_asignacion);
        $curso = $this->modelo->obtenerCursoPorAsignacion($id_asignacion);

        foreach ($tareas as &$tarea) {
            $conteo = $this->modelo->obtenerConteoEntregasPorTarea($tarea['id_tarea']);
            $tarea['calificadas'] = (int)($conteo['calificadas'] ?? 0);
            $tarea['pendientes'] = (int)($conteo['pendientes'] ?? 0);
        }

        require __DIR__ . '/../vista/tareas/listar.php';
    }

    // --- Subir entrega (Estudiante) ---
    public function entregar() {
        if ($_SESSION['usuario']['rol'] !== 'Estudiante') {
            echo "No tiene permisos para entregar tareas.";
            return;
        }

        $id_tarea = $_GET['id_tarea'] ?? null;
        $id_asignacion = $_GET['id_asignacion'] ?? null;

        if (!$id_tarea || !$id_asignacion) {
            echo "Datos incompletos.";
            return;
        }

        $curso = $this->modelo->obtenerCursoPorAsignacion($id_asignacion);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->registrarEntrega(
                $_POST['id_tarea'],
                $_SESSION['usuario']['id_estudiante'],
                $_POST['link_drive']
            );
            header("Location: index.php?c=Tarea&a=misTareas");
            exit;
        }

        require __DIR__ . '/../vista/tareas/entregar.php';
    }

    // --- Calificar entrega (Docente) ---
    public function calificar() {
        if ($_SESSION['usuario']['rol'] !== 'Docente') {
            echo "No tiene permisos para calificar entregas.";
            return;
        }

        $id_tarea = $_GET['id_tarea'] ?? null;
        $id_asignacion = $_GET['id_asignacion'] ?? null;

        if (!$id_tarea || !$id_asignacion) {
            echo "Datos incompletos.";
            return;
        }

        $curso = $this->modelo->obtenerCursoPorAsignacion($id_asignacion);
        $entregas = $this->modelo->obtenerEntregasPorTarea($id_tarea);
        $valor_tarea = $this->modelo->obtenerValorTarea($id_tarea);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->calificarEntrega(
                $_POST['id_entrega'],
                $_POST['calificacion'],
                $_POST['observaciones']
            );
            header("Location: index.php?c=Tarea&a=listar&id_asignacion=" . $_POST['id_asignacion']);
            exit;
        }

        require __DIR__ . '/../vista/tareas/calificar.php';
    }

    // --- Ver tareas del estudiante ---
    public function misTareas() {
        if ($_SESSION['usuario']['rol'] !== 'Estudiante') {
            echo "No tiene permisos para ver las tareas.";
            return;
        }

        $id_estudiante = $_SESSION['usuario']['id_estudiante'];

        $cursos = $this->modelo->obtenerCursosPorEstudiante($id_estudiante);
        $tareas = $this->modelo->obtenerTareasConEstado($id_estudiante);

        require __DIR__ . '/../vista/tareas/mis_tareas.php';
    }

    // --- Ver detalle de una entrega ---
    public function verEntrega() {
        if ($_SESSION['usuario']['rol'] !== 'Estudiante') {
            echo "No tiene permisos para ver la entrega.";
            return;
        }

        $id_tarea = $_GET['id_tarea'] ?? null;
        $id_estudiante = $_SESSION['usuario']['id_estudiante'];

        if (!$id_tarea) {
            echo "No se especificó la tarea.";
            return;
        }

        $entrega = $this->modelo->obtenerEntregaPorTareaYEstudiante($id_tarea, $id_estudiante);

        if (!$entrega || !$entrega['link_drive']) {
            echo "No se encontró la entrega o aún no has entregado.";
            return;
        }

        require __DIR__ . '/../vista/tareas/verEntrega.php';
    }
}
?>
