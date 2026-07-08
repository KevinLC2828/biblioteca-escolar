<?php $titulo = 'Editar Libro - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<h1>Editar libro</h1>

<form action="index.php?route=libros/update&id=<?= $datos['id'] ?>" method="POST" class="formulario" novalidate id="form-libro">

    <div class="campo">
        <label for="titulo">Título *</label>
        <input type="text" id="titulo" name="titulo" required minlength="2" maxlength="150"
               value="<?= htmlspecialchars($datos['titulo'] ?? '') ?>">
        <?php if (!empty($errores['titulo'])): ?><span class="error"><?= htmlspecialchars($errores['titulo']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="autor">Autor *</label>
        <input type="text" id="autor" name="autor" required minlength="2" maxlength="120"
               value="<?= htmlspecialchars($datos['autor'] ?? '') ?>">
        <?php if (!empty($errores['autor'])): ?><span class="error"><?= htmlspecialchars($errores['autor']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="editorial">Editorial *</label>
        <input type="text" id="editorial" name="editorial" required maxlength="120"
               value="<?= htmlspecialchars($datos['editorial'] ?? '') ?>">
        <?php if (!empty($errores['editorial'])): ?><span class="error"><?= htmlspecialchars($errores['editorial']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="anio_publicacion">Año de publicación *</label>
        <input type="number" id="anio_publicacion" name="anio_publicacion" required min="1400" max="<?= date('Y') ?>"
               value="<?= htmlspecialchars($datos['anio_publicacion'] ?? '') ?>">
        <?php if (!empty($errores['anio_publicacion'])): ?><span class="error"><?= htmlspecialchars($errores['anio_publicacion']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="isbn">ISBN *</label>
        <input type="text" id="isbn" name="isbn" required maxlength="20" placeholder="Ej: 978-3-16-148410-0"
               value="<?= htmlspecialchars($datos['isbn'] ?? '') ?>">
        <?php if (!empty($errores['isbn'])): ?><span class="error"><?= htmlspecialchars($errores['isbn']) ?></span><?php endif; ?>
    </div>

    <div class="campo">
        <label for="stock">Ejemplares disponibles (stock) *</label>
        <input type="number" id="stock" name="stock" required min="0"
               value="<?= htmlspecialchars($datos['stock'] ?? '1') ?>">
        <?php if (!empty($errores['stock'])): ?><span class="error"><?= htmlspecialchars($errores['stock']) ?></span><?php endif; ?>
    </div>

    <div class="acciones-form">
        <button type="submit" class="btn btn-primary">Actualizar libro</button>
        <a href="index.php?route=libros" class="btn">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>