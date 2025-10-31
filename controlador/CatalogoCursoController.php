<?php
require_once __DIR__ . '/../modelo/CatalogoCursoModelo.php';

class CatalogoCursoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CatalogoCursoModelo();
    }

    // Listar todos los cursos del catálogo
    public function index() {
        $cursos = $this->modelo->obtenerCatalogoCursos();
        require __DIR__ . '/../vista/catalogo_cursos/index.php';
    }

    // Mostrar formulario para agregar nuevo curso
    public function nuevo() {
        require __DIR__ . '/../vista/catalogo_cursos/nuevo.php';
    }

    // Guardar nuevo curso
    public function guardar($data) {
        $this->modelo->insertarCurso($data['nombre_curso'], $data['descripcion']);
        header("Location: index.php?c=CatalogoCurso&a=index");
    }

    // Mostrar formulario para editar curso
    public function editar($id) {
        $curso = $this->modelo->obtenerCursoPorId($id);
        require __DIR__ . '/../vista/catalogo_cursos/editar.php';
    }

    // Actualizar curso
    public function actualizar($data) {
        $this->modelo->actualizarCurso($data['id_catalogo_curso'], $data['nombre_curso'], $data['descripcion']);
        header("Location: index.php?c=CatalogoCurso&a=index");
    }

    // Eliminar curso
    public function eliminar($id) {
        $this->modelo->eliminarCurso($id);
        header("Location: index.php?c=CatalogoCurso&a=index");
    }
}
?>
