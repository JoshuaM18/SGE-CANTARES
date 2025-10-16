<?php
require_once __DIR__ . '/../modelo/AsistenciaModelo.php';

class AsistenciaController {
    private $modelo;

    public function __construct() {
        $this->modelo = new AsistenciaModelo();
    }

    // --- Mostrar estudiantes para registrar asistencia y opcional historial ---
    public function index() {
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    // Obtener id_docente
    $stmt = $this->modelo->db->conexion->prepare("SELECT id_docente FROM docentes WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $docente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$docente) {
        echo "No se encontró el docente asociado al usuario.";
        return;
    }

    $id_docente = $docente['id_docente'];
    $cursos = $this->modelo->obtenerCursosDocente($id_docente);

    $id_asignacion = $_GET['id_asignacion'] ?? null;
    $estudiantes = [];

    if ($id_asignacion) {
        $estudiantes = $this->modelo->obtenerEstudiantesPorAsignacion($id_asignacion);
        $cursoSeleccionado = $this->modelo->obtenerCursoPorAsignacion($id_asignacion);
    }

    require __DIR__ . '/../vista/asistencias/index.php';
}


    // --- Guardar asistencia ---
    public function guardar($data) {
        $fecha = $data['fecha'] ?? date('Y-m-d');
        $id_asignacion = $data['id_asignacion'];

        foreach ($data['estado'] as $id_matricula => $estado) {
            $this->modelo->registrarAsistencia($id_matricula, $fecha, $estado);
        }

        // Redirigir al mismo curso para seguir registrando o ver historial
        header("Location: index.php?c=Asistencia&a=index&id_asignacion={$id_asignacion}");
        exit;
    }

    // --- Ver historial completo de un estudiante ---
    public function historial() {
        $id_estudiante = $_GET['id_estudiante'] ?? null;
        $id_asignacion = $_GET['id_asignacion'] ?? null;

        if (!$id_estudiante || !$id_asignacion) {
            echo "Faltan parámetros para ver historial.";
            return;
        }

        $asistencias = $this->modelo->obtenerAsistenciaPorEstudiante($id_estudiante, $id_asignacion);
        require __DIR__ . '/../vista/asistencias/historial.php';
    }

    // --- Ver historial por día (opcional) ---
  public function historialPorDia() {
    $id_asignacion = $_GET['id_asignacion'] ?? null;
    $fecha = $_GET['fecha'] ?? date('Y-m-d');

    if (!$id_asignacion) {
        echo "Debe seleccionar un curso.";
        return;
    }

    $asistencias = $this->modelo->obtenerAsistenciaPorCursoYFecha($id_asignacion, $fecha);
    $cursoSeleccionado = $this->modelo->obtenerCursoPorAsignacion($id_asignacion);

    require __DIR__ . '/../vista/asistencias/historial.php';
}


}
?>
