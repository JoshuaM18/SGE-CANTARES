<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class UsuarioModeloTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new UsuarioModelo();

        // Limpiar tabla usuarios antes de cada prueba
        $this->modelo->db->conexion->exec("DELETE FROM usuarios");
    }

    public function testInsertarYObtenerUsuario()
    {
        // Insertar un usuario
        $resultado = $this->modelo->insertarUsuario(
            "usuario_test",
            password_hash("1234", PASSWORD_BCRYPT),
            "test@example.com",
            "Administrador",
            "Activo"
        );
        $this->assertTrue($resultado, "No se pudo insertar el usuario");

        // Obtener por nombre
        $usuario = $this->modelo->obtenerUsuarioPorNombre("usuario_test");
        $this->assertIsArray($usuario, "No se obtuvo un array del usuario");
        $this->assertEquals("usuario_test", $usuario['nombre_usuario']);
        $this->assertEquals("test@example.com", $usuario['correo']);
    }

    public function testActualizarUsuario()
    {
        // Insertar usuario
        $this->modelo->insertarUsuario(
            "usuario_update",
            password_hash("1234", PASSWORD_BCRYPT),
            "update@example.com",
            "Docente",
            "Activo"
        );
        $usuario = $this->modelo->obtenerUsuarioPorNombre("usuario_update");

        // Actualizar datos
        $resultado = $this->modelo->actualizarUsuario(
            $usuario['id_usuario'],
            "usuario_modificado",
            "modificado@example.com",
            "Docente",
            "Inactivo"
        );
        $this->assertTrue($resultado, "No se pudo actualizar el usuario");

        $usuarioMod = $this->modelo->obtenerUsuarioPorId($usuario['id_usuario']);
        $this->assertEquals("usuario_modificado", $usuarioMod['nombre_usuario']);
        $this->assertEquals("Inactivo", $usuarioMod['estado']);
    }

    public function testEliminarUsuario()
    {
        // Insertar usuario
        $this->modelo->insertarUsuario(
            "usuario_eliminar",
            password_hash("1234", PASSWORD_BCRYPT),
            "eliminar@example.com",
            "Docente",
            "Activo"
        );
        $usuario = $this->modelo->obtenerUsuarioPorNombre("usuario_eliminar");

        // Eliminar
        $resultado = $this->modelo->eliminarUsuario($usuario['id_usuario']);
        $this->assertTrue($resultado, "No se pudo eliminar el usuario");

        $usuarioEliminado = $this->modelo->obtenerUsuarioPorId($usuario['id_usuario']);
        $this->assertFalse($usuarioEliminado, "El usuario no fue eliminado");
    }
}
