<?php $titulo = 'Nuevo(a) Estudiante - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Registrar estudiante</h1>

<form action="index.php?route=estudiantes/store" method="POST" class="formulario" novalidate id="form-estudiante">

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
        <label for="curso_grado">Curso / Grado *</label>
        <input type="text" id="curso_grado" name="curso_grado" required maxlength="50"
               value="<?= htmlspecialchars($datos['curso_grado'] ?? '') ?>">
        <?php if (!empty($errores['curso_grado'])): ?><span class="error"><?= htmlspecialchars($errores['curso_grado']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="cedula">Cédula *</label>
        <input type="text" id="cedula" name="cedula" required maxlength="15"
               value="<?= htmlspecialchars($datos['cedula'] ?? '') ?>">
        <?php if (!empty($errores['cedula'])): ?><span class="error"><?= htmlspecialchars($errores['cedula']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="email">Correo electrónico *</label>
        <input type="email" id="email" name="email" required maxlength="150"
               value="<?= htmlspecialchars($datos['email'] ?? '') ?>">
        <?php if (!empty($errores['email'])): ?><span class="error"><?= htmlspecialchars($errores['email']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Guardar estudiante</button>
        <a href="index.php?route=estudiantes" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>