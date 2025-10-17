<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';
require_once __DIR__ . '/../controlador/UsuarioController.php';

class UsuarioControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        // Configurar variables de entorno para CI
        putenv('DB_HOST=127.0.0.1');
        putenv('DB_NAME=sistema_gestion_educativa');
        putenv('DB_USER=ciuser');
        putenv('DB_PASS=ci_pass');

        $this->controller = new UsuarioController();

        // Limpiar tabla usuarios antes de cada prueba
        $this->controller->modelo->db->conexion->exec("DELETE FROM usuarios");
    }

    public function testGuardarYRedirigir()
    {
        $data = [
            'nombre_usuario' => 'ctrluser',
            'contrasena' => '1234',
            'correo' => 'ctrl@example.com',
            'rol' => 'Administrador',
            'estado' => 'Activo'
        ];

        // Capturar salida de header() para CI
        ob_start();
        $this->controller->guardar($data);
        ob_end_clean();

        $usuario = $this->controller->modelo->obtenerUsuarioPorNombre('ctrluser');
        $this->assertNotEmpty($usuario);
        $this->assertEquals('ctrluser', $usuario['nombre_usuario']);
        $this->assertEquals('ctrl@example.com', $usuario['correo']);
        $this->assertEquals('Administrador', $usuario['rol']);
        $this->assertEquals('Activo', $usuario['estado']);
    }

    public function testActualizarUsuario()
    {
        $this->controller->modelo->insertarUsuario('userCtrl', '1234', 'a@b.com', 'Docente', 'Activo');
        $usuario = $this->controller->modelo->obtenerUsuarioPorNombre('userCtrl');
        $this->assertNotEmpty($usuario);

        $data = [
            'id_usuario' => $usuario['id_usuario'],
            'nombre_usuario' => 'userCtrlMod',
            'correo' => 'mod@b.com',
            'rol' => 'Estudiante',
            'estado' => 'Inactivo'
        ];

        ob_start();
        $this->controller->actualizar($data);
        ob_end_clean();

        $usuarioMod = $this->controller->modelo->obtenerUsuarioPorId($usuario['id_usuario']);
        $this->assertEquals('userCtrlMod', $usuarioMod['nombre_usuario']);
        $this->assertEquals('mod@b.com', $usuarioMod['correo']);
        $this->assertEquals('Estudiante', $usuarioMod['rol']);
        $this->assertEquals('Inactivo', $usuarioMod['estado']);
    }

    public function testEliminarUsuario()
    {
        $this->controller->modelo->insertarUsuario('userDelete', '1234', 'del@test.com', 'Personal', 'Activo');
        $usuario = $this->controller->modelo->obtenerUsuarioPorNombre('userDelete');
        $this->assertNotEmpty($usuario);

        ob_start();
        $this->controller->eliminar($usuario['id_usuario']);
        ob_end_clean();

        $usuarioEliminado = $this->controller->modelo->obtenerUsuarioPorId($usuario['id_usuario']);
        $this->assertFalse($usuarioEliminado);
    }
}
?>
