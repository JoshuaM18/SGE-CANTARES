<?php
require_once __DIR__ . '/../modelo/CarreraCursoModelo.php';

class CarreraCursoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CarreraCursoModelo();
    }

    // Listado de asignaciones
    public function index() {
        $asignaciones = $this->modelo->obtenerAsignaciones();
        require __DIR__ . '/../vista/carrera_curso/index.php';
    }

    // Formulario nuevo
    public function nuevo() {
        $carreras = $this->modelo->obtenerCarreras(); // Para dropdown si lo necesitas
        // Obtener cursos ya con el nombre de la carrera
        $cursos = $this->modelo->obtenerCursosConCarrera(); 
        $docentes = $this->modelo->obtenerDocentes();
        require __DIR__ . '/../vista/carrera_curso/nuevo.php';
    }

    // Guardar nuevas asignaciones
    public function guardar($data) {
        if (empty($data['id_curso'])) {
            die("No se seleccionaron cursos.");
        }

        $anio = $data['anio_academico'];
        $cursos_docentes = [];
        foreach ($data['id_curso'] as $id_curso) {
            $docenteId = $data['docente_'.$id_curso] ?? null;
            if ($docenteId) {
                $cursos_docentes[$id_curso] = $docenteId;
            }
        }

        $this->modelo->guardarAsignaciones($anio, $cursos_docentes);
        header("Location: index.php?c=CarreraCurso&a=index");
        exit;
    }

    // Formulario editar
    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) die("No se recibió ID");

        $asignacion = $this->modelo->obtenerAsignacionPorId($id);
        // Obtener cursos con nombre de carrera
        $cursos = $this->modelo->obtenerCursosConCarrera();
        $docentes = $this->modelo->obtenerDocentes();
        require __DIR__ . '/../vista/carrera_curso/editar.php';
    }

    // Actualizar asignación
    public function actualizar($data) {
        $this->modelo->actualizarAsignacion(
            $data['id_asignacion'],
            $data['id_curso'],
            $data['id_docente'],
            $data['anio_academico']
        );
        header("Location: index.php?c=CarreraCurso&a=index");
        exit;
    }

    // Eliminar asignación
    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarAsignacion($id);
        }
        header("Location: index.php?c=CarreraCurso&a=index");
        exit;
    }
}
?>
