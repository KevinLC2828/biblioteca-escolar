<?php $titulo = 'Editar Reserva - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Editar reserva</h1>

<form action="index.php?route=reservas/update&id=<?= $datos['id'] ?>" method="POST" class="formulario" novalidate id="form-reserva">

    <div class="campo">
        <label for="sala_id">Sala *</label>
        <select id="sala_id" name="sala_id" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($salas as $p): ?>
                <option value="<?= $p['id'] ?>" <?= (isset($datos['sala_id']) && $datos['sala_id'] == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errores['sala_id'])): ?><span class="error"><?= htmlspecialchars($errores['sala_id']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="nombre_solicitante">Nombre del solicitante *</label>
        <input type="text" id="nombre_solicitante" name="nombre_solicitante" required maxlength="120"
               value="<?= htmlspecialchars($datos['nombre_solicitante'] ?? '') ?>">
        <?php if (!empty($errores['nombre_solicitante'])): ?><span class="error"><?= htmlspecialchars($errores['nombre_solicitante']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="fecha_reserva">Fecha de la reserva *</label>
        <input type="date" id="fecha_reserva" name="fecha_reserva" required 
               value="<?= htmlspecialchars($datos['fecha_reserva'] ?? '') ?>">
        <?php if (!empty($errores['fecha_reserva'])): ?><span class="error"><?= htmlspecialchars($errores['fecha_reserva']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="hora_inicio">Hora de inicio *</label>
        <input type="time" id="hora_inicio" name="hora_inicio" required 
               value="<?= htmlspecialchars($datos['hora_inicio'] ?? '') ?>">
        <?php if (!empty($errores['hora_inicio'])): ?><span class="error"><?= htmlspecialchars($errores['hora_inicio']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="hora_fin">Hora de fin *</label>
        <input type="time" id="hora_fin" name="hora_fin" required 
               value="<?= htmlspecialchars($datos['hora_fin'] ?? '') ?>">
        <?php if (!empty($errores['hora_fin'])): ?><span class="error"><?= htmlspecialchars($errores['hora_fin']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="motivo">Motivo de la reserva *</label>
        <input type="text" id="motivo" name="motivo" required maxlength="150"
               value="<?= htmlspecialchars($datos['motivo'] ?? '') ?>">
        <?php if (!empty($errores['motivo'])): ?><span class="error"><?= htmlspecialchars($errores['motivo']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="estado">Estado *</label>
        <select id="estado" name="estado" required>
                <option value="confirmada" <?= (($datos['estado'] ?? '') === 'confirmada') ? 'selected' : '' ?>>Confirmada</option>
                <option value="cancelada" <?= (($datos['estado'] ?? '') === 'cancelada') ? 'selected' : '' ?>>Cancelada</option>
        </select>
        <?php if (!empty($errores['estado'])): ?><span class="error"><?= htmlspecialchars($errores['estado']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Actualizar reserva</button>
        <a href="index.php?route=reservas" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>