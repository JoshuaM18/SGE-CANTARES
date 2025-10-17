<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class UsuarioModeloTest extends TestCase {
    private $modelo;

    protected function setUp(): void {
        $this->modelo = new UsuarioModelo();
        // Usar usuario CI
        $this->modelo->db = new Conexion('ciuser', 'ci_pass');
        // Limpiar tabla usuarios antes de cada prueba
        $this->modelo->db->conexion->exec("DELETE FROM usuarios");
    }

    public function testInsertarUsuario() {
        $resultado = $this->modelo->insertarUsuario('testuser', '1234', 'test@test.com', 'Administrador', 'Activo');
        $this->assertTrue($resultado);

        $usuario = $this->modelo->obtenerUsuarioPorNombre('testuser');
        $this->assertEquals('testuser', $usuario['nombre_usuario']);
    }

    public function testObtenerUsuarios() {
        $this->modelo->insertarUsuario('user1', '1234', 'a@test.com', 'Docente', 'Activo');
        $usuarios = $this->modelo->obtenerUsuarios();
        $this->assertCount(1, $usuarios);
    }
}
?>
