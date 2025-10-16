<?php
require_once __DIR__ . '/../modelo/EstudianteModelo.php';

class EstudianteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new EstudianteModelo();
    }

    // Listar estudiantes
    public function index() {
        $estudiantes = $this->modelo->obtenerEstudiantes();
        require __DIR__ . '/../vista/estudiantes/index.php';
    }

    // Formulario de nuevo estudiante
    public function nuevo() {
        $usuarios = $this->modelo->obtenerUsuariosDisponibles();
        require __DIR__ . '/../vista/estudiantes/nuevo.php';
    }

    // Guardar estudiante
    public function guardar($data) {
        $this->modelo->insertarEstudiante(
            $data['id_usuario'],
            $data['nombres'],
            $data['apellidos'],
            $data['fecha_nacimiento'],
            $data['genero'],
            $data['direccion'],
            $data['telefono'],
            $data['fecha_ingreso']
        );
        header("Location: index.php?c=Estudiante&a=index");
    }

    // Formulario de editar estudiante
    public function editar($id) {
        $estudiante = $this->modelo->obtenerEstudiantePorId($id);
        require __DIR__ . '/../vista/estudiantes/editar.php';
    }

    // Actualizar estudiante
    public function actualizar($data) {
        $this->modelo->actualizarEstudiante(
            $data['id_estudiante'],
            $data['nombres'],
            $data['apellidos'],
            $data['fecha_nacimiento'],
            $data['genero'],
            $data['direccion'],
            $data['telefono'],
            $data['fecha_ingreso']
        );
        header("Location: index.php?c=Estudiante&a=index");
    }

    // Eliminar estudiante
    public function eliminar($id) {
        $this->modelo->eliminarEstudiante($id);
        header("Location: index.php?c=Estudiante&a=index");
    }
}
?>
