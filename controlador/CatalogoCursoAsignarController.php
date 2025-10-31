<?php
require_once __DIR__ . '/../modelo/CatalogoCursoModelo.php';
require_once __DIR__ . '/../modelo/CarreraModelo.php';
require_once __DIR__ . '/../modelo/CursoModelo.php';

class CatalogoCursoAsignarController {
    private $catalogoModelo;
    private $carreraModelo;
    private $cursoModelo;

    public function __construct() {
        $this->catalogoModelo = new CatalogoCursoModelo();
        $this->carreraModelo = new CarreraModelo();
        $this->cursoModelo = new CursoModelo();
    }

    public function nuevo() {
        $carreras = $this->carreraModelo->obtenerCarreras();
        $cursos_catalogo = $this->catalogoModelo->obtenerCatalogoCursos();
        require __DIR__ . '/../vista/catalogo_cursos_asignar/crear_desde_catalogo.php';
    }

    public function guardar($data) {
        if (!empty($data['id_carrera']) && !empty($data['cursos'])) {
            $this->cursoModelo->insertarCursosDesdeCatalogo($data['id_carrera'], $data['cursos']);
        }
        header("Location: index.php?c=Curso&a=index");
    }
}
?>
