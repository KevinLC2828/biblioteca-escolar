<?php $titulo = 'Nuevo(a) Sala - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Registrar sala</h1>

<form action="index.php?route=salas/store" method="POST" class="formulario" novalidate id="form-sala">

    <div class="campo">
        <label for="nombre">Nombre de la sala *</label>
        <input type="text" id="nombre" name="nombre" required maxlength="100"
               value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>">
        <?php if (!empty($errores['nombre'])): ?><span class="error"><?= htmlspecialchars($errores['nombre']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="capacidad">Capacidad (personas) *</label>
        <input type="number" id="capacidad" name="capacidad" required min="1"
               value="<?= htmlspecialchars($datos['capacidad'] ?? '') ?>">
        <?php if (!empty($errores['capacidad'])): ?><span class="error"><?= htmlspecialchars($errores['capacidad']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="ubicacion">Ubicación *</label>
        <input type="text" id="ubicacion" name="ubicacion" required maxlength="120"
               value="<?= htmlspecialchars($datos['ubicacion'] ?? '') ?>">
        <?php if (!empty($errores['ubicacion'])): ?><span class="error"><?= htmlspecialchars($errores['ubicacion']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="estado">Estado *</label>
        <select id="estado" name="estado" required>
                <option value="disponible" <?= (($datos['estado'] ?? '') === 'disponible') ? 'selected' : '' ?>>Disponible</option>
                <option value="mantenimiento" <?= (($datos['estado'] ?? '') === 'mantenimiento') ? 'selected' : '' ?>>En mantenimiento</option>
        </select>
        <?php if (!empty($errores['estado'])): ?><span class="error"><?= htmlspecialchars($errores['estado']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Guardar sala</button>
        <a href="index.php?route=salas" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>