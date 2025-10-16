<?php
require_once __DIR__ . '/../modelo/DocenteModelo.php';

class DocenteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new DocenteModelo();
    }

    public function index() {
        $docentes = $this->modelo->obtenerDocentes();
        require __DIR__ . '/../vista/docentes/index.php';
    }

    public function nuevo() {
        $usuarios = $this->modelo->obtenerUsuariosDisponibles();
        require __DIR__ . '/../vista/docentes/nuevo.php';
    }

    public function guardar($data) {
        $this->modelo->insertarDocente(
            $data['id_usuario'],
            $data['nombres'],
            $data['apellidos'],
            $data['especialidad'],
            $data['telefono'],
            $data['correo_institucional'],
            $data['fecha_contratacion']
        );
        header("Location: index.php?c=Docente&a=index");
    }

    public function editar($id) {
        $docente = $this->modelo->obtenerDocentePorId($id);
        require __DIR__ . '/../vista/docentes/editar.php';
    }

    public function actualizar($data) {
        $this->modelo->actualizarDocente(
            $data['id_docente'],
            $data['nombres'],
            $data['apellidos'],
            $data['especialidad'],
            $data['telefono'],
            $data['correo_institucional'],
            $data['fecha_contratacion']
        );
        header("Location: index.php?c=Docente&a=index");
    }

    public function eliminar($id) {
        $this->modelo->eliminarDocente($id);
        header("Location: index.php?c=Docente&a=index");
    }
}
?>
