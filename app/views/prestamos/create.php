<?php $titulo = 'Nuevo Préstamo - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Registrar nuevo préstamo</h1>

<form action="index.php?route=prestamos/store" method="POST" class="formulario" novalidate id="form-prestamo">

    <div class="campo">
        <label for="libro_id">Libro *</label>
        <select id="libro_id" name="libro_id" required>
            <option value="">-- Seleccione un libro --</option>
            <?php foreach ($libros as $l): ?>
                <option value="<?= $l['id'] ?>"
                    <?= (isset($datos['libro_id']) && $datos['libro_id'] == $l['id']) ? 'selected' : '' ?>
                    <?= $l['stock'] <= 0 ? 'disabled' : '' ?>>
                    <?= htmlspecialchars($l['titulo']) ?> (<?= (int) $l['stock'] ?> disponibles)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errores['libro_id'])): ?><span class="error"><?= htmlspecialchars($errores['libro_id']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="nombre_prestatario">Nombre del estudiante *</label>
        <input type="text" id="nombre_prestatario" name="nombre_prestatario" required minlength="2" maxlength="120"
               value="<?= htmlspecialchars($datos['nombre_prestatario'] ?? '') ?>">
        <?php if (!empty($errores['nombre_prestatario'])): ?><span class="error"><?= htmlspecialchars($errores['nombre_prestatario']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="curso_grado">Curso / Grado *</label>
        <input type="text" id="curso_grado" name="curso_grado" required maxlength="50"
               placeholder="Ej: 3ro Bachillerato"
               value="<?= htmlspecialchars($datos['curso_grado'] ?? '') ?>">
        <?php if (!empty($errores['curso_grado'])): ?><span class="error"><?= htmlspecialchars($errores['curso_grado']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="fecha_prestamo">Fecha de préstamo *</label>
        <input type="date" id="fecha_prestamo" name="fecha_prestamo" required
               value="<?= htmlspecialchars($datos['fecha_prestamo'] ?? date('Y-m-d')) ?>">
        <?php if (!empty($errores['fecha_prestamo'])): ?><span class="error"><?= htmlspecialchars($errores['fecha_prestamo']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="fecha_devolucion_esperada">Fecha de devolución esperada *</label>
        <input type="date" id="fecha_devolucion_esperada" name="fecha_devolucion_esperada" required
               value="<?= htmlspecialchars($datos['fecha_devolucion_esperada'] ?? '') ?>">
        <?php if (!empty($errores['fecha_devolucion_esperada'])): ?><span class="error"><?= htmlspecialchars($errores['fecha_devolucion_esperada']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Guardar préstamo</button>
        <a href="index.php?route=prestamos" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>