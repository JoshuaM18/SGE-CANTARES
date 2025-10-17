<?php
use PHPUnit\Framework\TestCase;

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
        $nombre = "testuser";
        $pass = password_hash("1234", PASSWORD_BCRYPT);
        $correo = "test@example.com";
        $rol = "Administrador";
        $estado = "Activo";

        $this->modelo->insertarUsuario($nombre, $pass, $correo, $rol, $estado);
        $usuario = $this->modelo->obtenerUsuarioPorNombre($nombre);

        $this->assertNotEmpty($usuario);
        $this->assertEquals($nombre, $usuario['nombre_usuario']);
        $this->assertEquals($correo, $usuario['correo']);
        $this->assertEquals($rol, $usuario['rol']);
        $this->assertEquals($estado, $usuario['estado']);
    }

    public function testActualizarUsuario()
    {
        $this->modelo->insertarUsuario("testuser", password_hash("1234", PASSWORD_BCRYPT), "t@e.com", "Docente", "Activo");
        $usuario = $this->modelo->obtenerUsuarioPorNombre("testuser");

        $this->modelo->actualizarUsuario($usuario['id_usuario'], "useredit", "edit@e.com", "Estudiante", "Inactivo");
        $usuarioEdit = $this->modelo->obtenerUsuarioPorId($usuario['id_usuario']);

        $this->assertEquals("useredit", $usuarioEdit['nombre_usuario']);
        $this->assertEquals("edit@e.com", $usuarioEdit['correo']);
        $this->assertEquals("Estudiante", $usuarioEdit['rol']);
        $this->assertEquals("Inactivo", $usuarioEdit['estado']);
    }

    public function testEliminarUsuario()
    {
        $this->modelo->insertarUsuario("todelete", password_hash("1234", PASSWORD_BCRYPT), "del@e.com", "Docente", "Activo");
        $usuario = $this->modelo->obtenerUsuarioPorNombre("todelete");

        $this->modelo->eliminarUsuario($usuario['id_usuario']);
        $usuarioEliminado = $this->modelo->obtenerUsuarioPorId($usuario['id_usuario']);

        $this->assertFalse($usuarioEliminado);
    }
}
