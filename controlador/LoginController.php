<?php
require_once __DIR__ . '/../modelo/UsuarioModelo.php';

class LoginController {
    private $modelo;

    public function __construct() {
        $this->modelo = new UsuarioModelo();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Mostrar formulario de login
    public function index($error = '') {
        require __DIR__ . '/../vista/login/index.php';
    }

    // Procesar login
    public function autenticar($data) {
        $usuario = $this->modelo->obtenerUsuarioPorNombre($data['nombre_usuario']);

        if ($usuario && password_verify($data['contrasena'], $usuario['contrasena'])) {
            // Guardar datos básicos del usuario en sesión
            $_SESSION['usuario'] = [
                'id_usuario'    => $usuario['id_usuario'],
                'nombre_usuario'=> $usuario['nombre_usuario'],
                'rol'           => $usuario['rol']
            ];

            // Si el usuario es estudiante, obtener y guardar id_estudiante
            if ($usuario['rol'] === 'Estudiante') {
                $stmt = $this->modelo->db->conexion->prepare(
                    "SELECT id_estudiante FROM estudiantes WHERE id_usuario = ?"
                );
                $stmt->execute([$usuario['id_usuario']]);
                $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($estudiante) {
                    $_SESSION['usuario']['id_estudiante'] = $estudiante['id_estudiante'];
                }
            }

            // Mensaje temporal de bienvenida
            $_SESSION['mensaje_login'] = "¡Inicio de sesión exitoso! Bienvenido, " . $usuario['nombre_usuario'];

            // Redirigir al menú principal
            header("Location: index.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
            require __DIR__ . '/../vista/login/index.php';
        }
    }

    // Cerrar sesión
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?logout=1");
        exit;
    }
}
?>
