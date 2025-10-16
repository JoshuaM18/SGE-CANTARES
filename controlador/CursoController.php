<?php
require_once __DIR__ . '/../modelo/CursoModelo.php';
require_once __DIR__ . '/../modelo/CarreraModelo.php';

class CursoController {
    private $modelo;
    private $modeloCarrera;

    public function __construct() {
        $this->modelo = new CursoModelo();
        $this->modeloCarrera = new CarreraModelo();
    }

    public function index() {
        $cursos = $this->modelo->obtenerCursos();
        require __DIR__ . '/../vista/cursos/index.php';
    }

    public function nuevo() {
        $carreras = $this->modeloCarrera->obtenerCarreras();
        require __DIR__ . '/../vista/cursos/nuevo.php';
    }

    public function guardar($data) {
        $this->modelo->insertarCurso($data['id_carrera'], $data['nombre_curso'], $data['descripcion'], $data['creditos']);
        header("Location: index.php?c=Curso&a=index");
    }

    public function editar($id) {
        $curso = $this->modelo->obtenerCursoPorId($id);
        $carreras = $this->modeloCarrera->obtenerCarreras();
        require __DIR__ . '/../vista/cursos/editar.php';
    }

    public function actualizar($data) {
        $this->modelo->actualizarCurso($data['id_curso'], $data['id_carrera'], $data['nombre_curso'], $data['descripcion'], $data['creditos']);
        header("Location: index.php?c=Curso&a=index");
    }

    public function eliminar($id) {
        $this->modelo->eliminarCurso($id);
        header("Location: index.php?c=Curso&a=index");
    }
}
?>
