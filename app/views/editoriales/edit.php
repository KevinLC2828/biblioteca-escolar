<?php $titulo = 'Editar Editorial - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Editar editorial</h1>

<form action="index.php?route=editoriales/update&id=<?= $datos['id'] ?>" method="POST" class="formulario" novalidate id="form-editorial">

    <div class="campo">
        <label for="nombre">Nombre de la editorial *</label>
        <input type="text" id="nombre" name="nombre" required maxlength="150"
               value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>">
        <?php if (!empty($errores['nombre'])): ?><span class="error"><?= htmlspecialchars($errores['nombre']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="pais">País *</label>
        <input type="text" id="pais" name="pais" required maxlength="80"
               value="<?= htmlspecialchars($datos['pais'] ?? '') ?>">
        <?php if (!empty($errores['pais'])): ?><span class="error"><?= htmlspecialchars($errores['pais']) ?></span><?php endif; ?>
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
        <button type="submit" class="btn btn-primary">Actualizar editorial</button>
        <a href="index.php?route=editoriales" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>