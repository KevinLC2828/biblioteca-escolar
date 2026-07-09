<?php $titulo = 'Salas - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>🚪 Salas</h1>
    <a href="index.php?route=salas/create" class="btn btn-primary">+ Nuevo(a) sala</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Sala creado(a) correctamente.', 'actualizado' => 'Sala actualizado(a) correctamente.', 'eliminado' => 'Sala eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<form action="index.php" method="GET" class="formulario-busqueda">
    <input type="hidden" name="route" value="salas/buscar">
    <input type="text" name="nombre" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
    <input type="text" name="ubicacion" placeholder="Buscar por ubicacion..." value="<?= htmlspecialchars($_GET['ubicacion'] ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <a href="index.php?route=salas" class="btn">Limpiar</a>
</form>

<?php if (empty($salas)): ?>
    <p class="empty-state">No se encontraron registros.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre de la sala</th>
                <th>Capacidad (personas)</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombre']) ?></td>
                    <td><?= htmlspecialchars($reg['capacidad']) ?></td>
                    <td><?= htmlspecialchars($reg['ubicacion']) ?></td>
                    <td>
                        <?php $clasesEstado_estado = ['disponible' => 'badge-success', 'mantenimiento' => 'badge-danger']; ?>
                        <span class="badge <?= $clasesEstado_estado[$reg['estado']] ?? '' ?>"><?= htmlspecialchars(ucfirst($reg['estado'])) ?></span>
                    </td>
                    <td class="acciones">
                        <a href="index.php?route=salas/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=salas/delete&id=<?= $reg['id'] ?>"
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