<?php $titulo = 'Editar Adquisición - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Editar adquisicion</h1>

<form action="index.php?route=adquisiciones/update&id=<?= $datos['id'] ?>" method="POST" class="formulario" novalidate id="form-adquisicion">

    <div class="campo">
        <label for="editorial_id">Editorial *</label>
        <select id="editorial_id" name="editorial_id" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($editoriales as $p): ?>
                <option value="<?= $p['id'] ?>" <?= (isset($datos['editorial_id']) && $datos['editorial_id'] == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errores['editorial_id'])): ?><span class="error"><?= htmlspecialchars($errores['editorial_id']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="titulo_obra">Título de la obra *</label>
        <input type="text" id="titulo_obra" name="titulo_obra" required maxlength="150"
               value="<?= htmlspecialchars($datos['titulo_obra'] ?? '') ?>">
        <?php if (!empty($errores['titulo_obra'])): ?><span class="error"><?= htmlspecialchars($errores['titulo_obra']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="cantidad">Cantidad *</label>
        <input type="number" id="cantidad" name="cantidad" required min="1"
               value="<?= htmlspecialchars($datos['cantidad'] ?? '') ?>">
        <?php if (!empty($errores['cantidad'])): ?><span class="error"><?= htmlspecialchars($errores['cantidad']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="fecha_adquisicion">Fecha de adquisición *</label>
        <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" required 
               value="<?= htmlspecialchars($datos['fecha_adquisicion'] ?? '') ?>">
        <?php if (!empty($errores['fecha_adquisicion'])): ?><span class="error"><?= htmlspecialchars($errores['fecha_adquisicion']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="costo_unitario">Costo unitario ($) *</label>
        <input type="number" id="costo_unitario" name="costo_unitario" required min="0" step="0.01"
               value="<?= htmlspecialchars($datos['costo_unitario'] ?? '') ?>">
        <?php if (!empty($errores['costo_unitario'])): ?><span class="error"><?= htmlspecialchars($errores['costo_unitario']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="estado">Estado *</label>
        <select id="estado" name="estado" required>
                <option value="pendiente" <?= (($datos['estado'] ?? '') === 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="recibido" <?= (($datos['estado'] ?? '') === 'recibido') ? 'selected' : '' ?>>Recibido</option>
                <option value="cancelado" <?= (($datos['estado'] ?? '') === 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
        </select>
        <?php if (!empty($errores['estado'])): ?><span class="error"><?= htmlspecialchars($errores['estado']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Actualizar adquisicion</button>
        <a href="index.php?route=adquisiciones" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>