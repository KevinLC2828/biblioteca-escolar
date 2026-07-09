<?php $titulo = 'Sanciones - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>⚠️ Sanciones</h1>
    <a href="index.php?route=sanciones/create" class="btn btn-primary">+ Nuevo(a) sancion</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Sanción registrado(a) correctamente.', 'actualizado' => 'Sanción actualizado(a) correctamente.', 'eliminado' => 'Sanción eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<?php if (empty($sancionesLista)): ?>
    <p class="empty-state">No hay registros todavía.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Motivo</th>
                <th>Monto ($)</th>
                <th>Fecha de la sanción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sancionesLista as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombre_estudiante'] . ' ' . $reg['apellidos']) ?></td>
                    <td><?= htmlspecialchars($reg['motivo']) ?></td>
                    <td><?= htmlspecialchars($reg['monto']) ?></td>
                    <td><?= htmlspecialchars($reg['fecha_sancion']) ?></td>
                    <td>
                        <?php $clasesEstado_estado = ['pendiente' => 'badge-warning', 'pagada' => 'badge-success', 'anulada' => 'badge-danger']; ?>
                        <span class="badge <?= $clasesEstado_estado[$reg['estado']] ?? '' ?>"><?= htmlspecialchars(ucfirst($reg['estado'])) ?></span>
                    </td>
                    <td class="acciones">
                        <a href="index.php?route=sanciones/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=sanciones/delete&id=<?= $reg['id'] ?>"
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