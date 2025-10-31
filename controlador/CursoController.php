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

    // Listar todos los cursos
    public function index() {
        $cursos = $this->modelo->obtenerCursos();
        require __DIR__ . '/../vista/cursos/index.php';
    }

    // Mostrar formulario para agregar nuevo curso
    public function nuevo() {
    $carreras = $this->modeloCarrera->obtenerCarreras();

    require_once __DIR__ . '/../modelo/CatalogoCursoModelo.php';
    $catalogoModelo = new CatalogoCursoModelo();
    $cursos_catalogo = $catalogoModelo->obtenerCatalogoCursos();

    require __DIR__ . '/../vista/cursos/nuevo.php';
}


    // Guardar nuevo curso
    public function guardar($data) {
        $this->modelo->insertarCurso($data['id_carrera'], $data['nombre_curso'], $data['descripcion']);
        header("Location: index.php?c=Curso&a=index");
    }

    // Mostrar formulario para editar curso existente
    public function editar($id) {
        $curso = $this->modelo->obtenerCursoPorId($id);
        $carreras = $this->modeloCarrera->obtenerCarreras();
        require __DIR__ . '/../vista/cursos/editar.php';
    }

    // Actualizar curso
    public function actualizar($data) {
        $this->modelo->actualizarCurso($data['id_curso'], $data['id_carrera'], $data['nombre_curso'], $data['descripcion']);
        header("Location: index.php?c=Curso&a=index");
    }

    // Eliminar curso
    public function eliminar($id) {
        $this->modelo->eliminarCurso($id);
        header("Location: index.php?c=Curso&a=index");
    }

    
 public function crearDesdeCatalogo() {
    // Obtener carreras
    $carreras = $this->modeloCarrera->obtenerCarreras();

    // Cargar modelo de catálogo de cursos
    require_once __DIR__ . '/../modelo/CatalogoCursoModelo.php';
    $catalogoModelo = new CatalogoCursoModelo();

    // Obtener cursos del catálogo
    $cursos_catalogo = $catalogoModelo->obtenerCatalogoCursos();

    // Depuración opcional
   
    // Llamar a la vista correcto
    require __DIR__ . '/../vista/cursos/nuevo.php';
}




    // Guardar cursos seleccionados desde el catálogo a una carrera
    public function guardarDesdeCatalogo($data) {
        if (!empty($data['id_carrera']) && !empty($data['cursos'])) {
            $this->modelo->insertarCursosDesdeCatalogo($data['id_carrera'], $data['cursos']);
        }
        header("Location: index.php?c=Curso&a=index");
    }

    // Listar todos los cursos del catálogo
    public function catalogoIndex() {
        require_once __DIR__ . '/../modelo/CatalogoCursoModelo.php';
        $catalogoModelo = new CatalogoCursoModelo();
        $cursos_catalogo = $catalogoModelo->obtenerCatalogoCursos();
        require __DIR__ . '/../vista/catalogo_cursos/index.php';
    }
}
?>
