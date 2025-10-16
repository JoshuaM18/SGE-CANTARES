<?php
require_once __DIR__ . '/../modelo/CarreraModelo.php';

class CarreraController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CarreraModelo();
    }

    public function index() {
        $carreras = $this->modelo->obtenerCarreras();
        require __DIR__ . '/../vista/carreras/index.php';
    }

    public function nuevo() {
        require __DIR__ . '/../vista/carreras/nuevo.php';
    }

    public function guardar($data) {
        $this->modelo->insertarCarrera($data['nombre_carrera'], $data['descripcion']);
        header("Location: index.php?c=Carrera&a=index");
    }

    public function editar($id) {
        $carrera = $this->modelo->obtenerCarreraPorId($id);
        require __DIR__ . '/../vista/carreras/editar.php';
    }

    public function actualizar($data) {
        $this->modelo->actualizarCarrera($data['id_carrera'], $data['nombre_carrera'], $data['descripcion']);
        header("Location: index.php?c=Carrera&a=index");
    }

    public function eliminar($id) {
        $this->modelo->eliminarCarrera($id);
        header("Location: index.php?c=Carrera&a=index");
    }
}
?>
