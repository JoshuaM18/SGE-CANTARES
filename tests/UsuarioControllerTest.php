<?php
use PHPUnit\Framework\TestCase;

class UsuarioControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
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

        // Capturamos la salida de header()
        ob_start();
        $this->controller->guardar($data);
        $output = ob_get_clean();

        $usuario = $this->controller->modelo->obtenerUsuarioPorNombre('ctrluser');
        $this->assertNotEmpty($usuario);
        $this->assertEquals('ctrluser', $usuario['nombre_usuario']);
    }
}
