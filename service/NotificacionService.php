<?php
require_once __DIR__ . '/../modelo/UsuarioModelo.php';
require_once __DIR__ . '/../modelo/NotificacionModelo.php';

class NotificacionService {
    private $usuarioModelo;
    private $notificacionModelo;

    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo();
        $this->notificacionModelo = new NotificacionModelo();
    }

    // Notificar a todos los estudiantes de un curso sobre una nueva tarea
    public function notificarNuevaTarea($tituloTarea, $fechaEntrega, $idCurso) {
        $alumnos = $this->usuarioModelo->obtenerAlumnosPorCurso($idCurso);

        foreach ($alumnos as $alumno) {
            $titulo = "Nueva Tarea Asignada";
            $mensaje = "Se ha asignado la tarea '$tituloTarea'. Fecha de entrega: $fechaEntrega";
            $this->notificacionModelo->insertar($alumno['id_usuario'], $titulo, $mensaje);
        }
    }

    // Notificar a un estudiante sobre la calificación de una tarea
    public function notificarCalificacion($idUsuario, $nombreTarea, $calificacion) {
        $titulo = "Tarea Calificada";
        $mensaje = "Tu tarea '$nombreTarea' ha sido calificada con $calificacion puntos.";
        $this->notificacionModelo->insertar($idUsuario, $titulo, $mensaje);
    }

    // 🔹 Método genérico para notificar a cualquier usuario
    public function crearNotificacion($idUsuario, $titulo, $mensaje) {
        $this->notificacionModelo->insertar($idUsuario, $titulo, $mensaje);
    }
}
?>
