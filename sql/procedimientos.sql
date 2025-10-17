
-- =========================
-- MODULO USUARIOS
-- =========================

DROP PROCEDURE IF EXISTS sp_insertar_usuario;
DELIMITER $$
CREATE PROCEDURE sp_insertar_usuario(
    IN p_nombre_usuario VARCHAR(50),
    IN p_contrasena VARCHAR(255),
    IN p_correo VARCHAR(100),
    IN p_rol ENUM('Administrador','Docente','Estudiante','Padre','Personal'),
    IN p_estado ENUM('Activo','Inactivo')
)
BEGIN
    INSERT INTO usuarios(nombre_usuario, contrasena, correo, rol, estado)
    VALUES (p_nombre_usuario, p_contrasena, p_correo, p_rol, p_estado);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_usuarios;
DELIMITER $$
CREATE PROCEDURE sp_obtener_usuarios()
BEGIN
    SELECT * FROM usuarios;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_usuario_por_id;
DELIMITER $$
CREATE PROCEDURE sp_obtener_usuario_por_id(IN p_id INT)
BEGIN
    SELECT * FROM usuarios WHERE id_usuario = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_actualizar_usuario;
DELIMITER $$
CREATE PROCEDURE sp_actualizar_usuario(
    IN p_id_usuario INT,
    IN p_nombre_usuario VARCHAR(50),
    IN p_contrasena VARCHAR(255),
    IN p_correo VARCHAR(100),
    IN p_rol ENUM('Administrador','Docente','Estudiante','Padre','Personal'),
    IN p_estado ENUM('Activo','Inactivo')
)
BEGIN
    UPDATE usuarios
    SET nombre_usuario = p_nombre_usuario,
        contrasena = p_contrasena,
        correo = p_correo,
        rol = p_rol,
        estado = p_estado
    WHERE id_usuario = p_id_usuario;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_eliminar_usuario;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_usuario(IN p_id_usuario INT)
BEGIN
    DELETE FROM usuarios WHERE id_usuario = p_id_usuario;
END$$
DELIMITER ;



-- =========================
-- MODULO DOCENTES
-- =========================

DROP PROCEDURE IF EXISTS sp_insertar_docente;
DELIMITER $$
CREATE PROCEDURE sp_insertar_docente(
    IN p_id_usuario INT,
    IN p_nombres VARCHAR(100),
    IN p_apellidos VARCHAR(100),
    IN p_especialidad VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_correo_institucional VARCHAR(100),
    IN p_fecha_contratacion DATE
)
BEGIN
    INSERT INTO docentes(id_usuario, nombres, apellidos, especialidad, telefono, correo_institucional, fecha_contratacion)
    VALUES (p_id_usuario, p_nombres, p_apellidos, p_especialidad, p_telefono, p_correo_institucional, p_fecha_contratacion);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_actualizar_docente;
DELIMITER $$
CREATE PROCEDURE sp_actualizar_docente(
    IN p_id_docente INT,
    IN p_nombres VARCHAR(100),
    IN p_apellidos VARCHAR(100),
    IN p_especialidad VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_correo_institucional VARCHAR(100),
    IN p_fecha_contratacion DATE
)
BEGIN
    UPDATE docentes
    SET nombres = p_nombres,
        apellidos = p_apellidos,
        especialidad = p_especialidad,
        telefono = p_telefono,
        correo_institucional = p_correo_institucional,
        fecha_contratacion = p_fecha_contratacion
    WHERE id_docente = p_id_docente;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_eliminar_docente;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_docente(IN p_id_docente INT)
BEGIN
    DELETE FROM docentes WHERE id_docente = p_id_docente;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_docentes;
DELIMITER $$
CREATE PROCEDURE sp_obtener_docentes()
BEGIN
    SELECT d.*, u.nombre_usuario, u.correo
    FROM docentes d
    JOIN usuarios u ON d.id_usuario = u.id_usuario;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_docente_por_id;
DELIMITER $$
CREATE PROCEDURE sp_obtener_docente_por_id(IN p_id_docente INT)
BEGIN
    SELECT d.*, u.nombre_usuario, u.correo
    FROM docentes d
    JOIN usuarios u ON d.id_usuario = u.id_usuario
    WHERE d.id_docente = p_id_docente;
END$$
DELIMITER ;



-- =========================
-- MODULO PADRES
-- =========================

DROP PROCEDURE IF EXISTS sp_insertar_padre;
DELIMITER $$
CREATE PROCEDURE sp_insertar_padre(
    IN p_id_usuario INT,
    IN p_nombres VARCHAR(100),
    IN p_apellidos VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_correo VARCHAR(100),
    IN p_direccion VARCHAR(200)
)
BEGIN
    INSERT INTO padres(id_usuario, nombres, apellidos, telefono, correo, direccion)
    VALUES (p_id_usuario, p_nombres, p_apellidos, p_telefono, p_correo, p_direccion);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_padres;
DELIMITER $$
CREATE PROCEDURE sp_obtener_padres()
BEGIN
    SELECT p.*, u.nombre_usuario, u.correo AS correo_usuario
    FROM padres p
    JOIN usuarios u ON p.id_usuario = u.id_usuario;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_padre_por_id;
DELIMITER $$
CREATE PROCEDURE sp_obtener_padre_por_id(IN p_id_padre INT)
BEGIN
    SELECT p.*, u.nombre_usuario, u.correo AS correo_usuario
    FROM padres p
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    WHERE p.id_padre = p_id_padre;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_actualizar_padre;
DELIMITER $$
CREATE PROCEDURE sp_actualizar_padre(
    IN p_id_padre INT,
    IN p_nombres VARCHAR(100),
    IN p_apellidos VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_correo VARCHAR(100),
    IN p_direccion VARCHAR(200)
)
BEGIN
    UPDATE padres
    SET nombres = p_nombres,
        apellidos = p_apellidos,
        telefono = p_telefono,
        correo = p_correo,
        direccion = p_direccion
    WHERE id_padre = p_id_padre;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_eliminar_padre;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_padre(IN p_id_padre INT)
BEGIN
    DELETE FROM padres WHERE id_padre = p_id_padre;
END$$
DELIMITER ;

-- =========================
-- MODULO CARRERAS
-- =========================

DROP PROCEDURE IF EXISTS sp_insertar_carrera;
DELIMITER $$
CREATE PROCEDURE sp_insertar_carrera(
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT
)
BEGIN
    INSERT INTO carreras(nombre_carrera, descripcion)
    VALUES(p_nombre, p_descripcion);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_actualizar_carrera;
DELIMITER $$
CREATE PROCEDURE sp_actualizar_carrera(
    IN p_id INT,
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT
)
BEGIN
    UPDATE carreras
    SET nombre_carrera = p_nombre,
        descripcion = p_descripcion
    WHERE id_carrera = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_eliminar_carrera;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_carrera(
    IN p_id INT
)
BEGIN
    DELETE FROM carreras WHERE id_carrera = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_carreras;
DELIMITER $$
CREATE PROCEDURE sp_obtener_carreras()
BEGIN
    SELECT * FROM carreras;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_carrera_por_id;
DELIMITER $$
CREATE PROCEDURE sp_obtener_carrera_por_id(
    IN p_id INT
)
BEGIN
    SELECT * FROM carreras WHERE id_carrera = p_id;
END$$
DELIMITER ;



-- =========================
-- MODULO CURSOS
-- =========================

DROP PROCEDURE IF EXISTS sp_insertar_curso;
DELIMITER $$
CREATE PROCEDURE sp_insertar_curso(
    IN p_id_carrera INT,
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_creditos INT
)
BEGIN
    INSERT INTO cursos(id_carrera, nombre_curso, descripcion, creditos)
    VALUES(p_id_carrera, p_nombre, p_descripcion, p_creditos);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_actualizar_curso;
DELIMITER $$
CREATE PROCEDURE sp_actualizar_curso(
    IN p_id INT,
    IN p_id_carrera INT,
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_creditos INT
)
BEGIN
    UPDATE cursos
    SET id_carrera = p_id_carrera,
        nombre_curso = p_nombre,
        descripcion = p_descripcion,
        creditos = p_creditos
    WHERE id_curso = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_eliminar_curso;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_curso(
    IN p_id INT
)
BEGIN
    DELETE FROM cursos WHERE id_curso = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_cursos;
DELIMITER $$
CREATE PROCEDURE sp_obtener_cursos()
BEGIN
    SELECT c.*, ca.nombre_carrera
    FROM cursos c
    LEFT JOIN carreras ca ON c.id_carrera = ca.id_carrera;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_curso_por_id;
DELIMITER $$
CREATE PROCEDURE sp_obtener_curso_por_id(
    IN p_id INT
)
BEGIN
    SELECT c.*, ca.nombre_carrera
    FROM cursos c
    LEFT JOIN carreras ca ON c.id_carrera = ca.id_carrera
    WHERE c.id_curso = p_id;
END$$
DELIMITER ;



-- =========================
-- MODULO ASIGNACIONES DOCENTE-CURSO
-- =========================

DROP PROCEDURE IF EXISTS sp_asignar_docente_a_curso;
DELIMITER $$
CREATE PROCEDURE sp_asignar_docente_a_curso(
    IN p_id_curso INT,
    IN p_id_docente INT,
    IN p_anio_academico YEAR,
    IN p_semestre ENUM('1','2')
)
BEGIN
    -- Evitar duplicados
    IF NOT EXISTS (
        SELECT 1 
        FROM cursos_docentes
        WHERE id_curso = p_id_curso 
          AND id_docente = p_id_docente
          AND anio_academico = p_anio_academico
          AND semestre = p_semestre
    ) THEN
        INSERT INTO cursos_docentes (id_curso, id_docente, anio_academico, semestre)
        VALUES (p_id_curso, p_id_docente, p_anio_academico, p_semestre);
    END IF;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_asignaciones;
DELIMITER $$
CREATE PROCEDURE sp_obtener_asignaciones()
BEGIN
    SELECT cd.id_asignacion, c.nombre_curso, d.nombres, d.apellidos, cd.anio_academico, cd.semestre
    FROM cursos_docentes cd
    JOIN cursos c ON cd.id_curso = c.id_curso
    JOIN docentes d ON cd.id_docente = d.id_docente;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_eliminar_asignacion;
DELIMITER $$
CREATE PROCEDURE sp_eliminar_asignacion(IN p_id_asignacion INT)
BEGIN
    DELETE FROM cursos_docentes WHERE id_asignacion = p_id_asignacion;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_actualizar_asignacion;
DELIMITER $$
CREATE PROCEDURE sp_actualizar_asignacion(
    IN p_id_asignacion INT,
    IN p_id_curso INT,
    IN p_id_docente INT,
    IN p_anio_academico YEAR,
    IN p_semestre ENUM('1','2')
)
BEGIN
    UPDATE cursos_docentes
    SET id_curso = p_id_curso,
        id_docente = p_id_docente,
        anio_academico = p_anio_academico,
        semestre = p_semestre
    WHERE id_asignacion = p_id_asignacion;
END$$
DELIMITER ;

-- =========================
-- MODULO MATRICULAS
-- =========================

DROP PROCEDURE IF EXISTS sp_matricular_estudiante;
DELIMITER $$
CREATE PROCEDURE sp_matricular_estudiante(
    IN p_id_estudiante INT,
    IN p_id_asignacion INT,
    IN p_estado ENUM('Inscrito','Retirado','Aprobado','Reprobado')
)
BEGIN
    -- Insertar matrícula
    INSERT INTO matriculas (id_estudiante, id_asignacion, fecha_matricula, estado)
    VALUES (p_id_estudiante, p_id_asignacion, CURDATE(), p_estado);
END$$
DELIMITER ;


-- =========================
-- MODULO CALIFICACIONES
-- =========================

DROP PROCEDURE IF EXISTS sp_insertar_calificacion;
DELIMITER $$
CREATE PROCEDURE sp_insertar_calificacion(
    IN p_id_matricula INT,
    IN p_nota DECIMAL(5,2),
    IN p_observaciones TEXT
)
BEGIN
    -- Insertar o actualizar calificación
    INSERT INTO calificaciones(id_matricula, nota, observaciones)
    VALUES (p_id_matricula, p_nota, p_observaciones)
    ON DUPLICATE KEY UPDATE
        nota = p_nota,
        observaciones = p_observaciones;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_notas_por_estudiante;
DELIMITER $$
CREATE PROCEDURE sp_obtener_notas_por_estudiante(
    IN p_id_estudiante INT
)
BEGIN
    SELECT cal.id_calificacion, c.nombre_curso, cd.anio_academico, cd.semestre, cal.nota, cal.observaciones
    FROM calificaciones cal
    JOIN matriculas m ON cal.id_matricula = m.id_matricula
    JOIN cursos_docentes cd ON m.id_asignacion = cd.id_asignacion
    JOIN cursos c ON cd.id_curso = c.id_curso
    WHERE m.id_estudiante = p_id_estudiante;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_notas_por_docente;
DELIMITER $$
CREATE PROCEDURE sp_obtener_notas_por_docente(
    IN p_id_docente INT,
    IN p_id_asignacion INT
)
BEGIN
    SELECT m.id_matricula,
           e.nombres AS estudiante_nombres,
           e.apellidos AS estudiante_apellidos,
           c.nombre_curso,
           cd.anio_academico,
           cd.semestre,
           IFNULL(cal.nota, '') AS nota,
           IFNULL(cal.observaciones, '') AS observaciones
    FROM matriculas m
    JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
    JOIN cursos_docentes cd ON m.id_asignacion = cd.id_asignacion
    JOIN cursos c ON cd.id_curso = c.id_curso
    LEFT JOIN calificaciones cal ON cal.id_matricula = m.id_matricula
    WHERE cd.id_docente = p_id_docente
      AND cd.id_asignacion = p_id_asignacion;
END$$
DELIMITER ;


-- =========================
-- MODULO ASISTENCIAS
-- =========================

DROP PROCEDURE IF EXISTS sp_registrar_asistencia;
DELIMITER $$
CREATE PROCEDURE sp_registrar_asistencia(
    IN p_id_matricula INT,
    IN p_fecha DATE,
    IN p_estado ENUM('Presente','Ausente','Justificado')
)
BEGIN
    INSERT INTO asistencias(id_matricula, fecha, estado)
    VALUES(p_id_matricula, p_fecha, p_estado)
    ON DUPLICATE KEY UPDATE
        estado = p_estado;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_obtener_asistencia_por_estudiante;
DELIMITER $$
CREATE PROCEDURE sp_obtener_asistencia_por_estudiante(
    IN p_id_estudiante INT,
    IN p_id_asignacion INT
)
BEGIN
    SELECT a.id_asistencia, m.id_matricula, e.nombres, e.apellidos, a.fecha, a.estado
    FROM asistencias a
    JOIN matriculas m ON a.id_matricula = m.id_matricula
    JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
    WHERE m.id_estudiante = p_id_estudiante
      AND m.id_asignacion = p_id_asignacion
    ORDER BY a.fecha DESC;
END$$
DELIMITER ;


-- =========================
-- MODULO TAREAS Y ENTREGAS
-- =========================

DROP PROCEDURE IF EXISTS sp_crear_tarea;
DELIMITER $$
CREATE PROCEDURE sp_crear_tarea(
    IN p_id_asignacion INT,
    IN p_titulo VARCHAR(150),
    IN p_descripcion TEXT,
    IN p_fecha_entrega DATE
)
BEGIN
    INSERT INTO tareas (id_asignacion, titulo, descripcion, fecha_entrega)
    VALUES (p_id_asignacion, p_titulo, p_descripcion, p_fecha_entrega);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_registrar_entrega;
DELIMITER $$
CREATE PROCEDURE sp_registrar_entrega(
    IN p_id_tarea INT,
    IN p_id_estudiante INT,
    IN p_link_drive VARCHAR(500)
)
BEGIN
    INSERT INTO entregas_tareas (id_tarea, id_estudiante, link_drive)
    VALUES (p_id_tarea, p_id_estudiante, p_link_drive);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_calificar_entrega;
DELIMITER $$
CREATE PROCEDURE sp_calificar_entrega(
    IN p_id_entrega INT,
    IN p_calificacion DECIMAL(5,2),
    IN p_observaciones TEXT
)
BEGIN
    UPDATE entregas_tareas
    SET calificacion = p_calificacion,
        observaciones = p_observaciones
    WHERE id_entrega = p_id_entrega;
END$$
DELIMITER ;
