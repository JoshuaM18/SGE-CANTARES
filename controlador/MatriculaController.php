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
        $carreras = $this->modelo->obtenerCarreras(); // obtenemos lista de carreras
        require __DIR__ . '/../vista/matriculas/nuevo.php';
    }

    // Guardar nueva matrícula automática por carrera
    public function guardar($data) {
        $id_estudiante = $data['id_estudiante'];
        $id_carrera = $data['id_carrera'];
        $anio_academico = $data['anio_academico'];
        $estado = $data['estado'];

        // Llamamos al procedimiento almacenado que matricula automáticamente al estudiante en todos los cursos de la carrera
        $this->modelo->insertarMatriculaPorCarrera($id_estudiante, $id_carrera, $anio_academico, $estado);

        header("Location: index.php?c=Matricula&a=index");
        exit;
    }

    // Formulario de edición de matrícula
    public function editar() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "No se recibió ID de matrícula.";
            header("Location: index.php?c=Matricula&a=index");
            exit;
        }

        $matricula = $this->modelo->obtenerMatriculaPorId($id);
        if (!$matricula) {
            $_SESSION['error'] = "No se encontró la matrícula con ID $id";
            header("Location: index.php?c=Matricula&a=index");
            exit;
        }

        $estudiantes = $this->modelo->obtenerEstudiantes();
        $cursos = $this->modelo->obtenerCursosParaMatricula();

        require __DIR__ . '/../vista/matriculas/editar.php';
    }

    // Actualizar matrícula
    public function actualizar($data) {
        $this->modelo->actualizarMatricula($data['id_matricula'], $data['id_estudiante'], $data['id_asignacion'], $data['estado']);
        header("Location: index.php?c=Matricula&a=index");
        exit;
    }

    // Eliminar matrícula
    public function eliminar($id) {
        $this->modelo->eliminarMatricula($id);
        header("Location: index.php?c=Matricula&a=index");
        exit;
    }
}
?>
