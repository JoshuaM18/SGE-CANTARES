<?php
require_once __DIR__ . '/../modelo/ComentarioModelo.php';

class ComentarioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new ComentarioModelo();
    }

    // Listar comentarios de una tarea
    public function index($id_tarea) {
        $comentarios = $this->modelo->obtenerComentariosPorTarea($id_tarea);
        require __DIR__ . '/../vista/comentarios/index.php';
    }

    // Formulario para nuevo comentario
    public function nuevo($id_tarea) {
        require __DIR__ . '/../vista/comentarios/nuevo.php';
    }

    // Guardar comentario
    public function guardar($data) {
        $this->modelo->insertarComentario($data['id_tarea'], $data['id_usuario'], $data['comentario']);
        header("Location: index.php?c=Comentario&a=index&id_tarea=" . $data['id_tarea']);
    }
}
?>
