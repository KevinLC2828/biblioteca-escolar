<?php $titulo = 'Nuevo(a) Empleado - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Registrar empleado</h1>

<form action="index.php?route=empleados/store" method="POST" class="formulario" novalidate id="form-empleado">

    <div class="campo">
        <label for="nombres">Nombres *</label>
        <input type="text" id="nombres" name="nombres" required maxlength="100"
               value="<?= htmlspecialchars($datos['nombres'] ?? '') ?>">
        <?php if (!empty($errores['nombres'])): ?><span class="error"><?= htmlspecialchars($errores['nombres']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="apellidos">Apellidos *</label>
        <input type="text" id="apellidos" name="apellidos" required maxlength="100"
               value="<?= htmlspecialchars($datos['apellidos'] ?? '') ?>">
        <?php if (!empty($errores['apellidos'])): ?><span class="error"><?= htmlspecialchars($errores['apellidos']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="cargo">Cargo *</label>
        <input type="text" id="cargo" name="cargo" required maxlength="80"
               value="<?= htmlspecialchars($datos['cargo'] ?? '') ?>">
        <?php if (!empty($errores['cargo'])): ?><span class="error"><?= htmlspecialchars($errores['cargo']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="telefono">Teléfono *</label>
        <input type="text" id="telefono" name="telefono" required maxlength="20"
               value="<?= htmlspecialchars($datos['telefono'] ?? '') ?>">
        <?php if (!empty($errores['telefono'])): ?><span class="error"><?= htmlspecialchars($errores['telefono']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="email">Correo electrónico *</label>
        <input type="email" id="email" name="email" required maxlength="150"
               value="<?= htmlspecialchars($datos['email'] ?? '') ?>">
        <?php if (!empty($errores['email'])): ?><span class="error"><?= htmlspecialchars($errores['email']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Guardar empleado</button>
        <a href="index.php?route=empleados" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>