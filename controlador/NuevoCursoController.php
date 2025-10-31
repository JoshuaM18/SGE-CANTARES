<?php
require_once __DIR__ . '/../modelo/NuevoCursoModelo.php';

class NuevoCursoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new NuevoCursoModelo();
    }

    // Mostrar todos los cursos creados
    public function index() {
        $cursos = $this->modelo->obtenerCursos();
        require __DIR__ . '/../vista/creacion_cursos/index.php';
    }

    // Mostrar formulario de creación
    public function nuevo() {
        require __DIR__ . '/../vista/creacion_cursos/nuevo.php';
    }

    // Guardar curso en la base de datos
    public function guardar($data) {
        $nombre = $data['nombre_curso'];
        $descripcion = $data['descripcion'];

        $this->modelo->insertarCurso($nombre, $descripcion);
        header("Location: index.php?c=NuevoCurso&a=index");
        exit();
    }

    // Eliminar curso (opcional)
    public function eliminar($id) {
        $this->modelo->eliminarCurso($id);
        header("Location: index.php?c=NuevoCurso&a=index");
        exit();
    }
}
?>
