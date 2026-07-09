<?php $titulo = 'Nuevo(a) Turno - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Registrar turno</h1>

<form action="index.php?route=turnos/store" method="POST" class="formulario" novalidate id="form-turno">

    <div class="campo">
        <label for="empleado_id">Empleado *</label>
        <select id="empleado_id" name="empleado_id" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($empleados as $p): ?>
                <option value="<?= $p['id'] ?>" <?= (isset($datos['empleado_id']) && $datos['empleado_id'] == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nombres'] . ' ' . $p['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errores['empleado_id'])): ?><span class="error"><?= htmlspecialchars($errores['empleado_id']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="dia_semana">Día de la semana *</label>
        <select id="dia_semana" name="dia_semana" required>
                <option value="Lunes" <?= (($datos['dia_semana'] ?? '') === 'Lunes') ? 'selected' : '' ?>>Lunes</option>
                <option value="Martes" <?= (($datos['dia_semana'] ?? '') === 'Martes') ? 'selected' : '' ?>>Martes</option>
                <option value="Miercoles" <?= (($datos['dia_semana'] ?? '') === 'Miercoles') ? 'selected' : '' ?>>Miércoles</option>
                <option value="Jueves" <?= (($datos['dia_semana'] ?? '') === 'Jueves') ? 'selected' : '' ?>>Jueves</option>
                <option value="Viernes" <?= (($datos['dia_semana'] ?? '') === 'Viernes') ? 'selected' : '' ?>>Viernes</option>
                <option value="Sabado" <?= (($datos['dia_semana'] ?? '') === 'Sabado') ? 'selected' : '' ?>>Sábado</option>
        </select>
        <?php if (!empty($errores['dia_semana'])): ?><span class="error"><?= htmlspecialchars($errores['dia_semana']) ?></span><?php endif; ?>
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
        <label for="area">Área asignada *</label>
        <input type="text" id="area" name="area" required maxlength="80"
               value="<?= htmlspecialchars($datos['area'] ?? '') ?>">
        <?php if (!empty($errores['area'])): ?><span class="error"><?= htmlspecialchars($errores['area']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Guardar turno</button>
        <a href="index.php?route=turnos" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>