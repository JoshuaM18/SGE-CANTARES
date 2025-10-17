<?php
class Conexion {
    private $host;
    private $db;
    private $user;
    private $pass;
    public $conexion;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: '127.0.0.1';
        $this->db   = getenv('DB_NAME') ?: 'sistema_gestion_educativa';
        $this->user = getenv('DB_USER') ?: 'root';
        $this->pass = getenv('DB_PASS') ?: '1234';

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
