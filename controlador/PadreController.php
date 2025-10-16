<?php
require_once __DIR__ . '/../modelo/PadreModelo.php';

class PadreController {
    private $modelo;

    public function __construct() {
        $this->modelo = new PadreModelo();
    }

    public function index() {
        $padres = $this->modelo->obtenerPadres();
        require __DIR__ . '/../vista/padres/index.php';
    }

    public function nuevo() {
        $usuarios = $this->modelo->obtenerUsuariosDisponibles();
        require __DIR__ . '/../vista/padres/nuevo.php';
    }

    public function guardar($data) {
        $this->modelo->insertarPadre(
            $data['id_usuario'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['correo'],
            $data['direccion']
        );
        header("Location: index.php?c=Padre&a=index");
    }

    public function editar($id) {
        $padre = $this->modelo->obtenerPadrePorId($id);
        require __DIR__ . '/../vista/padres/editar.php';
    }

    public function actualizar($data) {
        $this->modelo->actualizarPadre(
            $data['id_padre'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['correo'],
            $data['direccion']
        );
        header("Location: index.php?c=Padre&a=index");
    }

    public function eliminar($id) {
        $this->modelo->eliminarPadre($id);
        header("Location: index.php?c=Padre&a=index");
    }
}
?>
