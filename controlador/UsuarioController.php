<?php
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class UsuarioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new UsuarioModelo();
    }

    public function index() {
        $usuarios = $this->modelo->obtenerUsuarios();
        require __DIR__ . '/../vista/usuarios/index.php';
    }

    public function nuevo() {
        require __DIR__ . '/../vista/usuarios/nuevo.php';
    }

    public function guardar($data) {
        $hash = password_hash($data['contrasena'], PASSWORD_BCRYPT);
        $this->modelo->insertarUsuario(
            $data['nombre_usuario'],
            $hash,
            $data['correo'],
            $data['rol'],
            $data['estado']
        );
        header("Location: index.php?c=Usuario&a=index");
    }

    public function editar($id) {
        $usuario = $this->modelo->obtenerUsuarioPorId($id);
        require __DIR__ . '/../vista/usuarios/editar.php';
    }

    public function actualizar($data) {
        $this->modelo->actualizarUsuario(
            $data['id_usuario'],
            $data['nombre_usuario'],
            $data['correo'],
            $data['rol'],
            $data['estado']
        );
        header("Location: index.php?c=Usuario&a=index");
    }

    public function eliminar($id) {
        $this->modelo->eliminarUsuario($id);
        header("Location: index.php?c=Usuario&a=index");
    }
}
?>
