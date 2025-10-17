-- Crear base de datos
CREATE DATABASE IF NOT EXISTS sistema_gestion_educativa;
USE sistema_gestion_educativa;

-- =====================
-- USUARIOS Y ROLES
-- =====================
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE,
    rol ENUM('Administrador','Docente','Estudiante','Padre','Personal') NOT NULL,
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================
-- ESTUDIANTES / DOCENTES / PADRES
-- =====================
CREATE TABLE IF NOT EXISTS estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    genero ENUM('M','F','Otro'),
    direccion VARCHAR(200),
    telefono VARCHAR(20),
    fecha_ingreso DATE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS docentes (
    id_docente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100),
    telefono VARCHAR(20),
    correo_institucional VARCHAR(100),
    fecha_contratacion DATE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS padres (
    id_padre INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion VARCHAR(200),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS estudiantes_padres (
    id_relacion INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    id_padre INT,
    parentesco VARCHAR(50),
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante),
    FOREIGN KEY (id_padre) REFERENCES padres(id_padre)
);

-- =====================
-- CARRERAS Y CURSOS
-- =====================
CREATE TABLE IF NOT EXISTS carreras (
    id_carrera INT AUTO_INCREMENT PRIMARY KEY,
    nombre_carrera VARCHAR(100) NOT NULL,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    id_carrera INT,
    nombre_curso VARCHAR(100) NOT NULL,
    descripcion TEXT,
    creditos INT,
    FOREIGN KEY (id_carrera) REFERENCES carreras(id_carrera)
);

CREATE TABLE IF NOT EXISTS cursos_docentes (
    id_asignacion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    id_docente INT,
    anio_academico YEAR,
    semestre ENUM('1','2'),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_docente) REFERENCES docentes(id_docente)
);

-- =====================
-- MATRÍCULAS, NOTAS, ASISTENCIA
-- =====================
CREATE TABLE IF NOT EXISTS matriculas (
    id_matricula INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    id_asignacion INT,
    fecha_matricula DATE,
    estado ENUM('Inscrito','Retirado','Aprobado','Reprobado') DEFAULT 'Inscrito',
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante),
    FOREIGN KEY (id_asignacion) REFERENCES cursos_docentes(id_asignacion)
);

CREATE TABLE IF NOT EXISTS calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_matricula INT,
    nota DECIMAL(5,2),
    observaciones TEXT,
    FOREIGN KEY (id_matricula) REFERENCES matriculas(id_matricula)
);

CREATE TABLE IF NOT EXISTS asistencias (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    id_matricula INT,
    fecha DATE,
    estado ENUM('Presente','Ausente','Justificado'),
    FOREIGN KEY (id_matricula) REFERENCES matriculas(id_matricula)
);

-- =====================
-- TAREAS Y ENTREGAS
-- =====================
CREATE TABLE IF NOT EXISTS tareas (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    id_asignacion INT,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_entrega DATE,
    FOREIGN KEY (id_asignacion) REFERENCES cursos_docentes(id_asignacion)
);

CREATE TABLE IF NOT EXISTS entregas_tareas (
    id_entrega INT AUTO_INCREMENT PRIMARY KEY,
    id_tarea INT,
    id_estudiante INT,
    link_drive VARCHAR(500) NOT NULL,
    fecha_entrega TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    calificacion DECIMAL(5,2) NULL,
    observaciones TEXT,
    FOREIGN KEY (id_tarea) REFERENCES tareas(id_tarea),
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante)
);

-- =====================
-- COMENTARIOS EN TAREAS
-- =====================
CREATE TABLE IF NOT EXISTS comentarios_tareas (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_tarea INT,
    id_usuario INT,
    comentario TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tarea) REFERENCES tareas(id_tarea),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- =====================
-- MENSAJERÍA INTERNA
-- =====================
CREATE TABLE IF NOT EXISTS mensajes (
    id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
    id_remitente INT,
    id_destinatario INT,
    asunto VARCHAR(150),
    contenido TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_remitente) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_destinatario) REFERENCES usuarios(id_usuario)
);

-- =====================
-- RECURSOS DEL CURSO
-- =====================
CREATE TABLE IF NOT EXISTS recursos (
    id_recurso INT AUTO_INCREMENT PRIMARY KEY,
    id_asignacion INT,
    titulo VARCHAR(150),
    link_recurso VARCHAR(500) NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_asignacion) REFERENCES cursos_docentes(id_asignacion)
);

-- =====================
-- CONDUCTA / DISCIPLINA
-- =====================
CREATE TABLE IF NOT EXISTS conducta (
    id_conducta INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    tipo ENUM('Positiva','Negativa'),
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante)
);

-- =====================
-- EVENTOS ACADÉMICOS
-- =====================
CREATE TABLE IF NOT EXISTS eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150),
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    publico ENUM('Todos','Estudiantes','Docentes','Padres')
);

-- =====================
-- NOTIFICACIONES
-- =====================
CREATE TABLE IF NOT EXISTS notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    titulo VARCHAR(100),
    mensaje TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS estudiantes_docentes (
    id_estudiante INT,
    id_docente INT,
    PRIMARY KEY (id_estudiante, id_docente),
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante),
    FOREIGN KEY (id_docente) REFERENCES docentes(id_docente)
);
