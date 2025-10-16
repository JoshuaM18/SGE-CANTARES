<?php
require_once __DIR__ . '/../modelo/CalificacionModelo.php';

class CalificacionController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CalificacionModelo();
    }

    // Lista de cursos asignados al docente
    public function index() {
        // Obtener id_docente desde el id_usuario de sesión
        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocente($id_usuario);

        if (!$id_docente) {
            echo "No se encontró el docente asociado al usuario.";
            return;
        }

        $cursos = $this->modelo->obtenerCursosDocente($id_docente);
        require __DIR__ . '/../vista/calificaciones/index.php';
    }

    // Mostrar estudiantes para ingresar notas
    public function ingresarNotas() {
        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $id_docente = $this->modelo->obtenerIdDocente($id_usuario);

        if (!$id_docente) {
            echo "No se encontró el docente asociado al usuario.";
            return;
        }

        $id_asignacion = $_GET['id_asignacion'] ?? null;
        if (!$id_asignacion) {
            echo "Debe seleccionar un curso.";
            return;
        }

        $notas = $this->modelo->obtenerNotasPorCurso($id_docente, $id_asignacion);
        require __DIR__ . '/../vista/calificaciones/ingresar.php';
    }

    // Guardar notas
    public function guardar($data) {
        foreach($data['id_matricula'] as $key => $id_matricula) {
            $nota = $data['nota'][$key];
            $obs = $data['observaciones'][$key];
            $this->modelo->guardarCalificacion($id_matricula, $nota, $obs);
        }
        header("Location: index.php?c=Calificacion&a=index");
        exit;
    }
}
?>
