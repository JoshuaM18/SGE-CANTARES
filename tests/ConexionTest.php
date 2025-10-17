<?php
use PHPUnit\Framework\TestCase;

// Ajusta la ruta si tu test está en tests/
require_once __DIR__ . '/../conexion.php';

final class ConexionTest extends TestCase
{
    public function testConexionPDO(): void
    {
        $db = new Conexion();
        $this->assertInstanceOf(PDO::class, $db->conexion, "La conexión debe ser un objeto PDO");

        // Opcional: prueba simple de consulta
        $stmt = $db->conexion->query("SELECT 1");
        $this->assertEquals(1, $stmt->fetchColumn(), "La consulta de prueba debe retornar 1");
    }
}
