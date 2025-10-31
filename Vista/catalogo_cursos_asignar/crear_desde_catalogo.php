<form action="index.php?c=CatalogoCursoAsignar&a=guardar" method="POST">
    <a href="index.php?c=NuevoCurso&a=index">➕ Crear curso individual</a>
    <br>

    <label>Carrera:</label><br>
    <select name="id_carrera" required>
        <option value="">-- Selecciona una carrera --</option>
        <?php foreach($carreras as $c): ?>
            <option value="<?= $c['id_carrera'] ?>"><?= $c['nombre_carrera'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <div class="cursos-lista">
        <?php foreach($cursos_catalogo as $curso): ?>
            <label>
                <input type="checkbox" name="cursos[]" value="<?= $curso['id_catalogo_curso'] ?>">
                <?= htmlspecialchars($curso['nombre_curso']) ?>
            </label>
        <?php endforeach; ?>
    </div><br>

    <button type="submit">Guardar Cursos</button>
    <a href="index.php?c=Curso&a=index">Cancelar</a>
    
</form>
