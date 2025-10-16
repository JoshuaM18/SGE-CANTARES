<?php
class Conexion {
    private $host = "localhost";
    private $db = "sistema_gestion_educativa";
    private $user = "root";       // Cambia si tu usuario es distinto
    private $pass = "1234";           // Cambia si tu contraseña es distinta
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host=$this->host;dbname=$this->db;charset=utf8",
                $this->user,
                $this->pass
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
