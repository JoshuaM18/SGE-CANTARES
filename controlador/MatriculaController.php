<?php
require_once __DIR__ . '/../modelo/MatriculaModelo.php';

class MatriculaController {
    private $modelo;

    public function __construct() {
        $this->modelo = new MatriculaModelo();
    }

    // Mostrar todas las matrículas
    public function index() {
        $matriculas = $this->modelo->obtenerMatriculas();
        require __DIR__ . '/../vista/matriculas/index.php';
    }

    // Formulario de nueva matrícula
    public function nuevo() {
        $estudiantes = $this->modelo->obtenerEstudiantes();
        $cursos = $this->modelo->obtenerCursosParaMatricula(); // ahora trae carrera y docente
        require __DIR__ . '/../vista/matriculas/nuevo.php';
    }

    // Guardar nueva matrícula
    public function guardar($data) {
        $this->modelo->insertarMatricula($data['id_estudiante'], $data['id_asignacion'], $data['estado']);
        header("Location: index.php?c=Matricula&a=index");
    }

    // Formulario de edición de matrícula
    public function editar($id) {
        $matricula = $this->modelo->obtenerMatriculaPorId($id);
        $estudiantes = $this->modelo->obtenerEstudiantes();
        $cursos = $this->modelo->obtenerCursosParaMatricula(); // ahora trae carrera y docente
        require __DIR__ . '/../vista/matriculas/editar.php';
    }

    // Actualizar matrícula
    public function actualizar($data) {
        $this->modelo->actualizarMatricula($data['id_matricula'], $data['id_estudiante'], $data['id_asignacion'], $data['estado']);
        header("Location: index.php?c=Matricula&a=index");
    }

    // Eliminar matrícula
    public function eliminar($id) {
        $this->modelo->eliminarMatricula($id);
        header("Location: index.php?c=Matricula&a=index");
    }
}
?>
