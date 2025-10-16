<?php
require_once __DIR__ . '/../modelo/CursoDocenteModelo.php';

class CursoDocenteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CursoDocenteModelo();
    }

    public function index() {
        $asignaciones = $this->modelo->obtenerAsignaciones();
        require __DIR__ . '/../vista/cursos_docentes/index.php';
    }

    public function nuevo() {
        $cursos = $this->modelo->obtenerCursos();
        $docentes = $this->modelo->obtenerDocentes();
        require __DIR__ . '/../vista/cursos_docentes/nuevo.php';
    }

    public function guardar($data) {
        $this->modelo->asignarDocente(
            $data['id_curso'],
            $data['id_docente'],
            $data['anio_academico'],
            $data['semestre']
        );
        header("Location: index.php?c=CursoDocente&a=index");
    }

    public function eliminar($id) {
        $this->modelo->eliminarAsignacion($id);
        header("Location: index.php?c=CursoDocente&a=index");
    }

    public function editar($id) {
    $asignacion = $this->modelo->obtenerAsignacionPorId($id);
    $cursos = $this->modelo->obtenerCursos();
    $docentes = $this->modelo->obtenerDocentes();
    require __DIR__ . '/../vista/cursos_docentes/editar.php';
}

public function actualizar($data) {
    $this->modelo->actualizarAsignacion(
        $data['id_asignacion'],
        $data['id_curso'],
        $data['id_docente'],
        $data['anio_academico'],
        $data['semestre']
    );
    header("Location: index.php?c=CursoDocente&a=index");
}

}
?>
