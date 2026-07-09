<?php $titulo = 'Nuevo(a) Sanción - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Registrar sancion</h1>

<form action="index.php?route=sanciones/store" method="POST" class="formulario" novalidate id="form-sancion">

    <div class="campo">
        <label for="estudiante_id">Estudiante *</label>
        <select id="estudiante_id" name="estudiante_id" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($estudiantes as $p): ?>
                <option value="<?= $p['id'] ?>" <?= (isset($datos['estudiante_id']) && $datos['estudiante_id'] == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nombres'] . ' ' . $p['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errores['estudiante_id'])): ?><span class="error"><?= htmlspecialchars($errores['estudiante_id']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="motivo">Motivo *</label>
        <input type="text" id="motivo" name="motivo" required maxlength="200"
               value="<?= htmlspecialchars($datos['motivo'] ?? '') ?>">
        <?php if (!empty($errores['motivo'])): ?><span class="error"><?= htmlspecialchars($errores['motivo']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="monto">Monto ($) *</label>
        <input type="number" id="monto" name="monto" required min="0" step="0.01"
               value="<?= htmlspecialchars($datos['monto'] ?? '') ?>">
        <?php if (!empty($errores['monto'])): ?><span class="error"><?= htmlspecialchars($errores['monto']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="fecha_sancion">Fecha de la sanción *</label>
        <input type="date" id="fecha_sancion" name="fecha_sancion" required 
               value="<?= htmlspecialchars($datos['fecha_sancion'] ?? '') ?>">
        <?php if (!empty($errores['fecha_sancion'])): ?><span class="error"><?= htmlspecialchars($errores['fecha_sancion']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="estado">Estado *</label>
        <select id="estado" name="estado" required>
                <option value="pendiente" <?= (($datos['estado'] ?? '') === 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="pagada" <?= (($datos['estado'] ?? '') === 'pagada') ? 'selected' : '' ?>>Pagada</option>
                <option value="anulada" <?= (($datos['estado'] ?? '') === 'anulada') ? 'selected' : '' ?>>Anulada</option>
        </select>
        <?php if (!empty($errores['estado'])): ?><span class="error"><?= htmlspecialchars($errores['estado']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Guardar sancion</button>
        <a href="index.php?route=sanciones" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>