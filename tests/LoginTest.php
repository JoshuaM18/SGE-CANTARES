<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../modelo/UsuarioModelo.php';
require_once __DIR__ . '/../controlador/LoginController.php';

class LoginTest extends TestCase {
    private $modelo;
    private $controller;

    protected function setUp(): void {
        $this->modelo = new UsuarioModelo();
        $this->controller = new LoginController();
    }

    public function testAutenticarUsuarioValido() {
        // Crear un usuario temporal para el test
        $nombre = 'testuser';
        $pass = password_hash('12345', PASSWORD_DEFAULT);
        $correo = 'test@example.com';
        $rol = 'Estudiante';
        $estado = 'Activo';

        $this->modelo->insertarUsuario($nombre, $pass, $correo, $rol, $estado);

        $data = ['nombre_usuario' => $nombre, 'contrasena' => '12345'];

        // Capturar salida del login (redirección)
        ob_start();
        $this->controller->autenticar($data);
        $output = ob_get_clean();

        $usuario = $this->modelo->obtenerUsuarioPorNombre($nombre);

        $this->assertNotEmpty($usuario, "El usuario debería existir después de insertarlo.");
        $this->assertEquals($nombre, $usuario['nombre_usuario']);
    }

    public function testAutenticarUsuarioInvalido() {
        $data = ['nombre_usuario' => 'usuario_no_existe', 'contrasena' => '12345'];

        ob_start();
        $this->controller->autenticar($data);
        $output = ob_get_clean();

        $this->assertStringContainsString('Usuario o contraseña incorrectos', $output);
    }
}
