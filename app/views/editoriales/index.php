<?php $titulo = 'Editoriales - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>🏢 Editoriales</h1>
    <a href="index.php?route=editoriales/create" class="btn btn-primary">+ Nuevo(a) editorial</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Editorial creado(a) correctamente.', 'actualizado' => 'Editorial actualizado(a) correctamente.', 'eliminado' => 'Editorial eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<form action="index.php" method="GET" class="formulario-busqueda">
    <input type="hidden" name="route" value="editoriales/buscar">
    <input type="text" name="nombre" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
    <input type="text" name="pais" placeholder="Buscar por pais..." value="<?= htmlspecialchars($_GET['pais'] ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <a href="index.php?route=editoriales" class="btn">Limpiar</a>
</form>

<?php if (empty($editoriales)): ?>
    <p class="empty-state">No se encontraron registros.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre de la editorial</th>
                <th>País</th>
                <th>Teléfono</th>
                <th>Correo electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($editoriales as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombre']) ?></td>
                    <td><?= htmlspecialchars($reg['pais']) ?></td>
                    <td><?= htmlspecialchars($reg['telefono']) ?></td>
                    <td><?= htmlspecialchars($reg['email']) ?></td>
                    <td class="acciones">
                        <a href="index.php?route=editoriales/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=editoriales/delete&id=<?= $reg['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar este registro? Esta acción no se puede deshacer.');">
                           Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>