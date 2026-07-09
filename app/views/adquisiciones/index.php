<?php $titulo = 'Adquisiciones - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>📦 Adquisiciones</h1>
    <a href="index.php?route=adquisiciones/create" class="btn btn-primary">+ Nuevo(a) adquisicion</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Adquisición registrado(a) correctamente.', 'actualizado' => 'Adquisición actualizado(a) correctamente.', 'eliminado' => 'Adquisición eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<?php if (empty($adquisicionesLista)): ?>
    <p class="empty-state">No hay registros todavía.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Editorial</th>
                <th>Título de la obra</th>
                <th>Cantidad</th>
                <th>Fecha de adquisición</th>
                <th>Costo unitario ($)</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adquisicionesLista as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombre_editorial']) ?></td>
                    <td><?= htmlspecialchars($reg['titulo_obra']) ?></td>
                    <td><?= htmlspecialchars($reg['cantidad']) ?></td>
                    <td><?= htmlspecialchars($reg['fecha_adquisicion']) ?></td>
                    <td><?= htmlspecialchars($reg['costo_unitario']) ?></td>
                    <td>
                        <?php $clasesEstado_estado = ['pendiente' => 'badge-warning', 'recibido' => 'badge-success', 'cancelado' => 'badge-danger']; ?>
                        <span class="badge <?= $clasesEstado_estado[$reg['estado']] ?? '' ?>"><?= htmlspecialchars(ucfirst($reg['estado'])) ?></span>
                    </td>
                    <td class="acciones">
                        <a href="index.php?route=adquisiciones/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=adquisiciones/delete&id=<?= $reg['id'] ?>"
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