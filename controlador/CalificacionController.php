<?php
require_once __DIR__ . '/../modelo/CalificacionModelo.php';

class CalificacionController {
    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new CalificacionModelo();
    }

    // --- Lista de cursos asignados al docente ---
    public function index() {
        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocente($id_usuario);

        if (!$id_docente) {
            echo "No se encontró el docente asociado al usuario.";
            return;
        }

        $cursos = $this->modelo->obtenerCursosDocente($id_docente);
        require __DIR__ . '/../vista/calificaciones/index.php';
    }

    // --- Mostrar estudiantes y calificaciones para un curso ---
    public function ingresarNotas() {
        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocente($id_usuario);

        $id_asignacion = $_GET['id_asignacion'] ?? null;
        if (!$id_asignacion) {
            echo "Debe seleccionar un curso.";
            return;
        }

        // Validar que el curso pertenece al docente
        $cursos_docente = $this->modelo->obtenerCursosDocente($id_docente);
        $curso_valido = false;
        foreach ($cursos_docente as $curso) {
            if ($curso['id_asignacion'] == $id_asignacion) {
                $curso_valido = true;
                break;
            }
        }

        if (!$curso_valido) {
            echo "No tienes permiso para este curso.";
            return;
        }

        // Traer las notas de los estudiantes (procedimiento almacenado)
        $notas = $this->modelo->obtenerNotasPorCurso($id_asignacion);
        require __DIR__ . '/../vista/calificaciones/ingresar.php';
    }

    // --- Guardar calificación general ---
    public function guardar($data) {
        if (isset($data['id_matricula'])) {
            foreach ($data['id_matricula'] as $key => $id_matricula) {
                $nota = $data['nota'][$key] ?? 0;
                $obs = $data['observaciones'][$key] ?? '';
                $this->modelo->guardarCalificacion($id_matricula, $nota, $obs);
            }
        }
        header("Location: index.php?c=Calificacion&a=index");
        exit;
    }

    // --- Guardar calificación por bimestre ---
    public function guardarBimestre($data) {
        $bimestre = $data['bimestre'] ?? 1;
        if (isset($data['id_matricula'])) {
            foreach ($data['id_matricula'] as $key => $id_matricula) {
                $nota = $data['nota'][$key] ?? 0;
                $obs = $data['observaciones'][$key] ?? '';
                $this->modelo->guardarCalificacionBimestre($id_matricula, $bimestre, $nota, $obs);
            }
        }
        header("Location: index.php?c=Calificacion&a=index");
        exit;
    }
}
?>
