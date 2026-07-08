<?php $titulo = 'Editar Préstamo - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Gestionar préstamo</h1>
<p class="nota-info">
    Este formulario solo permite actualizar el <strong>estado</strong> y la
    <strong>fecha real de devolución</strong>, tal como lo define
    <code>prestamos::actualizar()</code>. Los demás datos del préstamo no son editables.
</p>

<form action="index.php?route=prestamos/update&id=<?= $datos['id'] ?>" method="POST" class="formulario" novalidate id="form-prestamo-edit">

    <div class="campo">
        <label>Libro</label>
        <input type="text" value="<?= htmlspecialchars($datos['titulo']) ?>" disabled>
    </div>

    <div class="campo">
        <label>Prestatario</label>
        <input type="text" value="<?= htmlspecialchars($datos['nombre_prestatario']) ?>" disabled>
    </div>

    <div class="campo">
        <label>Curso / Grado</label>
        <input type="text" value="<?= htmlspecialchars($datos['curso_grado']) ?>" disabled>
    </div>

    <div class="campo">
        <label>Fecha de préstamo</label>
        <input type="text" value="<?= htmlspecialchars($datos['fecha_prestamo']) ?>" disabled>
    </div>

    <div class="campo">
        <label>Fecha de devolución esperada</label>
        <input type="text" value="<?= htmlspecialchars($datos['fecha_devolucion_esperada']) ?>" disabled>
    </div>

    <div class="campo">
        <label for="fecha_devolucion_real">Fecha de devolución real</label>
        <input type="date" id="fecha_devolucion_real" name="fecha_devolucion_real"
               value="<?= htmlspecialchars($datos['fecha_devolucion_real'] ?? '') ?>">
        <?php if (!empty($errores['fecha_devolucion_real'])): ?><span class="error"><?= htmlspecialchars($errores['fecha_devolucion_real']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="estado">Estado *</label>
        <select id="estado" name="estado" required>
            <?php foreach (['prestado' => 'Prestado', 'devuelto' => 'Devuelto', 'atrasado' => 'Atrasado'] as $valor => $texto): ?>
                <option value="<?= $valor ?>" <?= ($datos['estado'] ?? '') === $valor ? 'selected' : '' ?>><?= $texto ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errores['estado'])): ?><span class="error"><?= htmlspecialchars($errores['estado']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Actualizar préstamo</button>
        <a href="index.php?route=prestamos" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>