<?php $titulo = 'Libros - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>📖 Catálogo de Libros</h1>
    <a href="index.php?route=libros/create" class="btn btn-primary">+ Nuevo libro</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Libro creado correctamente.', 'actualizado' => 'Libro actualizado correctamente.', 'eliminado' => 'Libro eliminado correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<form action="index.php" method="GET" class="formulario-busqueda">
    <input type="hidden" name="route" value="libros/buscar">
    <input type="text" name="titulo" placeholder="Buscar por título..." value="<?= htmlspecialchars($_GET['titulo'] ?? '') ?>">
    <input type="text" name="autor" placeholder="Buscar por autor..." value="<?= htmlspecialchars($_GET['autor'] ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <a href="index.php?route=libros" class="btn">Limpiar</a>
</form>

<?php if (empty($libros)): ?>
    <p class="empty-state">No se encontraron libros.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Año</th>
                <th>ISBN</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= htmlspecialchars($libro['titulo']) ?></td>
                    <td><?= htmlspecialchars($libro['autor']) ?></td>
                    <td><?= htmlspecialchars($libro['editorial']) ?></td>
                    <td><?= htmlspecialchars($libro['anio_publicacion']) ?></td>
                    <td><?= htmlspecialchars($libro['isbn']) ?></td>
                    <td>
                        <span class="badge <?= $libro['stock'] > 0 ? 'badge-success' : 'badge-danger' ?>">
                            <?= (int) $libro['stock'] ?>
                        </span>
                    </td>
                    <td class="acciones">
                        <a href="index.php?route=libros/edit&id=<?= $libro['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=libros/delete&id=<?= $libro['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar este libro? Esta acción no se puede deshacer.');">
                           Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>