<?php
require_once __DIR__ . '/../modelo/CursoDocenteModelo.php';

class CursoDocenteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CursoDocenteModelo();
    }

    // Mostrar listado de asignaciones
    public function index() {
        $asignaciones = $this->modelo->obtenerAsignaciones();
        require __DIR__ . '/../vista/cursos_docentes/index.php';
    }

    // Mostrar formulario para nueva asignación (con checkboxes)
    public function nuevo() {
        $cursos = $this->modelo->obtenerCursos();
        $docentes = $this->modelo->obtenerDocentes();
        require __DIR__ . '/../vista/cursos_docentes/nuevo.php';
    }

    // Guardar una sola asignación (si se usa el formulario original)
    public function guardar($data) {
        $this->modelo->asignarDocente(
            $data['id_curso'],
            $data['id_docente'],
            $data['anio_academico']
        );
        header("Location: index.php?c=CursoDocente&a=index");
    }

    // ✅ Nuevo método: guardar múltiples asignaciones desde checkboxes
    public function guardarMultiple($data) {
        $id_docente = $data['id_docente'];
        $anio_academico = $data['anio_academico'];
        $cursos = isset($data['id_curso']) ? $data['id_curso'] : [];

        if (!empty($cursos)) {
            foreach ($cursos as $id_curso) {
                $this->modelo->asignarDocente($id_curso, $id_docente, $anio_academico);
            }
        }

        header("Location: index.php?c=CursoDocente&a=index");
    }

    // Eliminar una asignación
    public function eliminar($id) {
        $this->modelo->eliminarAsignacion($id);
        header("Location: index.php?c=CursoDocente&a=index");
    }

    // Mostrar formulario de edición
    public function editar($id) {
        $asignacion = $this->modelo->obtenerAsignacionPorId($id);
        $cursos = $this->modelo->obtenerCursos();
        $docentes = $this->modelo->obtenerDocentes();
        require __DIR__ . '/../vista/cursos_docentes/editar.php';
    }

    // Actualizar una asignación existente
    public function actualizar($data) {
        $this->modelo->actualizarAsignacion(
            $data['id_asignacion'],
            $data['id_curso'],
            $data['id_docente'],
            $data['anio_academico']
        );
        header("Location: index.php?c=CursoDocente&a=index");
    }
}
?>
