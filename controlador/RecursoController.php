<?php
require_once __DIR__ . '/../modelo/RecursoModelo.php';

class RecursoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new RecursoModelo();
    }

    // Mostrar todos los recursos según rol
    public function index() {
        $rol = $_SESSION['usuario']['rol'];
        $id_usuario = $_SESSION['usuario']['id_usuario'];

        $vista_recursos = [];
        $vista_asignaciones = [];

        if ($rol === 'Docente') {
            // Obtener id_docente
            $stmt = $this->modelo->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            $id_docente = $stmt->fetchColumn();

            if (!$id_docente) {
                echo "<p>No tienes cursos asignados.</p>";
                return;
            }

            $asignaciones = $this->modelo->obtenerAsignacionesDocente($id_docente);

            if (empty($asignaciones)) {
                echo "<p>No tienes cursos asignados.</p>";
                return;
            }

            foreach ($asignaciones as $a) {
                $vista_recursos[$a['id_asignacion']] = $this->modelo->obtenerRecursosPorAsignacion($a['id_asignacion']);
            }

            $vista_asignaciones = $asignaciones;
            require __DIR__ . '/../vista/recurso/index.php';

        } elseif ($rol === 'Estudiante') {
            // Obtener id_estudiante
            $stmt = $this->modelo->db->conexion->prepare("SELECT id_estudiante FROM estudiantes WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            $id_estudiante = $stmt->fetchColumn();

            if (!$id_estudiante) {
                echo "<p>No estás matriculado en ningún curso.</p>";
                return;
            }

            // Obtener cursos matriculados
            $stmt = $this->modelo->db->conexion->prepare("
                SELECT a.id_asignacion, c.nombre_curso
                FROM matriculas m
                JOIN cursos_docentes a ON m.id_asignacion = a.id_asignacion
                JOIN cursos c ON a.id_curso = c.id_curso
                WHERE m.id_estudiante = ?
            ");
            $stmt->execute([$id_estudiante]);
            $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($asignaciones)) {
                echo "<p>No estás matriculado en ningún curso.</p>";
                return;
            }

            foreach ($asignaciones as $a) {
                $vista_recursos[$a['id_asignacion']] = $this->modelo->obtenerRecursosPorAsignacion($a['id_asignacion']);
            }

            $vista_asignaciones = $asignaciones;
            require __DIR__ . '/../vista/recurso/index_estudiantes.php';
        } else {
            echo "<p>No tienes permisos para ver este módulo.</p>";
        }
    }

    // Listar recursos de una asignación
    public function listar($id_asignacion) {
        $recursos = $this->modelo->obtenerRecursosPorAsignacion($id_asignacion);
        require __DIR__ . '/../vista/recurso/listar.php';
    }

    // Formulario para agregar recurso
    public function nuevo($id_asignacion) {
        require __DIR__ . '/../vista/recurso/nuevo.php';
    }

    // Guardar recurso
    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_asignacion = $_POST['id_asignacion'];
            $titulo = $_POST['titulo'];
            $link_recurso = $_POST['link_recurso'];

            $this->modelo->insertarRecurso($id_asignacion, $titulo, $link_recurso);

            header("Location: index.php?c=Recurso&a=listar&id_asignacion=$id_asignacion");
            exit;
        }
    }

    // Formulario para editar recurso
    public function editar($id_recurso) {
        $recurso = $this->modelo->obtenerRecursoPorId($id_recurso);
        require __DIR__ . '/../vista/recurso/editar.php';
    }

    // Actualizar recurso
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_recurso = $_POST['id_recurso'];
            $titulo = $_POST['titulo'];
            $link_recurso = $_POST['link_recurso'];
            $id_asignacion = $_POST['id_asignacion'];

            $this->modelo->actualizarRecurso($id_recurso, $titulo, $link_recurso);

            header("Location: index.php?c=Recurso&a=listar&id_asignacion=$id_asignacion");
            exit;
        }
    }

    // Eliminar recurso
    public function eliminar($id_recurso, $id_asignacion) {
        $this->modelo->eliminarRecurso($id_recurso);
        header("Location: index.php?c=Recurso&a=listar&id_asignacion=$id_asignacion");
        exit;
    }

    public function index_estudiantes() {
    $rol = $_SESSION['usuario']['rol'];
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    if ($rol !== 'Estudiante') {
        echo "<p>No tienes permisos para ver este módulo.</p>";
        return;
    }

    // Obtener id_estudiante del usuario logueado
    $stmt = $this->modelo->db->conexion->prepare("SELECT id_estudiante FROM estudiantes WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $id_estudiante = $stmt->fetchColumn();

    if (!$id_estudiante) {
        echo "<p>No estás matriculado en ningún curso.</p>";
        return;
    }

    // Obtener asignaciones/cursos del estudiante
    $stmt = $this->modelo->db->conexion->prepare("
        SELECT a.id_asignacion, c.nombre_curso
        FROM matriculas m
        JOIN cursos_docentes a ON m.id_asignacion = a.id_asignacion
        JOIN cursos c ON a.id_curso = c.id_curso
        WHERE m.id_estudiante = ?
    ");
    $stmt->execute([$id_estudiante]);
    $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($asignaciones)) {
        echo "<p>No estás matriculado en ningún curso.</p>";
        return;
    }

    // Obtener recursos de cada asignación
    $vista_recursos = [];
    foreach ($asignaciones as $a) {
        $vista_recursos[$a['id_asignacion']] = $this->modelo->obtenerRecursosPorAsignacion($a['id_asignacion']);
    }

    // Para la vista
    $vista_asignaciones = $asignaciones;
    require __DIR__ . '/../vista/recurso/index_estudiantes.php';
}


}
?>
