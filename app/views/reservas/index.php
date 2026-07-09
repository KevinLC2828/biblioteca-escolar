<?php $titulo = 'Reservas - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>📅 Reservas</h1>
    <a href="index.php?route=reservas/create" class="btn btn-primary">+ Nuevo(a) reserva</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Reserva registrado(a) correctamente.', 'actualizado' => 'Reserva actualizado(a) correctamente.', 'eliminado' => 'Reserva eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<?php if (empty($reservasLista)): ?>
    <p class="empty-state">No hay registros todavía.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Sala</th>
                <th>Nombre del solicitante</th>
                <th>Fecha de la reserva</th>
                <th>Hora de inicio</th>
                <th>Hora de fin</th>
                <th>Motivo de la reserva</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservasLista as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombre_sala']) ?></td>
                    <td><?= htmlspecialchars($reg['nombre_solicitante']) ?></td>
                    <td><?= htmlspecialchars($reg['fecha_reserva']) ?></td>
                    <td><?= htmlspecialchars($reg['hora_inicio']) ?></td>
                    <td><?= htmlspecialchars($reg['hora_fin']) ?></td>
                    <td><?= htmlspecialchars($reg['motivo']) ?></td>
                    <td>
                        <?php $clasesEstado_estado = ['confirmada' => 'badge-success', 'cancelada' => 'badge-danger']; ?>
                        <span class="badge <?= $clasesEstado_estado[$reg['estado']] ?? '' ?>"><?= htmlspecialchars(ucfirst($reg['estado'])) ?></span>
                    </td>
                    <td class="acciones">
                        <a href="index.php?route=reservas/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=reservas/delete&id=<?= $reg['id'] ?>"
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