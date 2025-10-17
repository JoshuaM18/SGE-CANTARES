<?php
use PHPUnit\Framework\TestCase;

// Asegúrate de que las rutas coincidan con tu proyecto
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class UsuarioModeloTest extends TestCase {
    private $modelo;

    protected function setUp(): void {
        // Configurar variables de entorno para CI
        putenv('DB_HOST=127.0.0.1');
        putenv('DB_NAME=sistema_gestion_educativa');
        putenv('DB_USER=ciuser');
        putenv('DB_PASS=ci_pass');

        // Inicializar modelo
        $this->modelo = new UsuarioModelo();

        // Limpiar tabla usuarios antes de cada prueba
        $this->modelo->db->conexion->exec("DELETE FROM usuarios");
    }

    public function testInsertarUsuario() {
        $resultado = $this->modelo->insertarUsuario(
            'testuser', '1234', 'test@test.com', 'Administrador', 'Activo'
        );
        $this->assertTrue($resultado, "El usuario debería insertarse correctamente");

        $usuario = $this->modelo->obtenerUsuarioPorNombre('testuser');
        $this->assertEquals('testuser', $usuario['nombre_usuario']);
        $this->assertEquals('test@test.com', $usuario['correo']);
        $this->assertEquals('Administrador', $usuario['rol']);
        $this->assertEquals('Activo', $usuario['estado']);
    }

    public function testObtenerUsuarios() {
        $this->modelo->insertarUsuario('user1', '1234', 'a@test.com', 'Docente', 'Activo');
        $usuarios = $this->modelo->obtenerUsuarios();
        $this->assertCount(1, $usuarios, "Debe haber un usuario en la tabla");
        $this->assertEquals('user1', $usuarios[0]['nombre_usuario']);
    }

    public function testActualizarUsuario() {
        $this->modelo->insertarUsuario('user2', '1234', 'b@test.com', 'Estudiante', 'Activo');
        $usuario = $this->modelo->obtenerUsuarioPorNombre('user2');

        $this->modelo->actualizarUsuario($usuario['id_usuario'], 'user2mod', 'bmod@test.com', 'Docente', 'Inactivo');
        $usuarioMod = $this->modelo->obtenerUsuarioPorId($usuario['id_usuario']);

        $this->assertEquals('user2mod', $usuarioMod['nombre_usuario']);
        $this->assertEquals('bmod@test.com', $usuarioMod['correo']);
        $this->assertEquals('Docente', $usuarioMod['rol']);
        $this->assertEquals('Inactivo', $usuarioMod['estado']);
    }

    public function testEliminarUsuario() {
        $this->modelo->insertarUsuario('user3', '1234', 'c@test.com', 'Personal', 'Activo');
        $usuario = $this->modelo->obtenerUsuarioPorNombre('user3');

        $resultado = $this->modelo->eliminarUsuario($usuario['id_usuario']);
        $this->assertTrue($resultado, "El usuario debería eliminarse correctamente");

        $usuarioEliminado = $this->modelo->obtenerUsuarioPorId($usuario['id_usuario']);
        $this->assertFalse($usuarioEliminado, "El usuario debería estar eliminado");
    }

    public function testObtenerUsuarioPorNombreNoExiste() {
        $usuario = $this->modelo->obtenerUsuarioPorNombre('noexiste');
        $this->assertFalse($usuario, "Debe retornar false si el usuario no existe");
    }

    public function testObtenerUsuarioPorIdNoExiste() {
        $usuario = $this->modelo->obtenerUsuarioPorId(999999);
        $this->assertFalse($usuario, "Debe retornar false si el ID no existe");
    }
}
?>
