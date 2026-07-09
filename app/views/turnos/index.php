<?php $titulo = 'Turnos - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>🕒 Turnos</h1>
    <a href="index.php?route=turnos/create" class="btn btn-primary">+ Nuevo(a) turno</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Turno registrado(a) correctamente.', 'actualizado' => 'Turno actualizado(a) correctamente.', 'eliminado' => 'Turno eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<?php if (empty($turnosLista)): ?>
    <p class="empty-state">No hay registros todavía.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Día de la semana</th>
                <th>Hora de inicio</th>
                <th>Hora de fin</th>
                <th>Área asignada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($turnosLista as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombre_empleado'] . ' ' . $reg['apellidos']) ?></td>
                    <td>
                        <?php $clasesEstado_dia_semana = ['Lunes' => 'badge-warning', 'Martes' => 'badge-warning', 'Miercoles' => 'badge-warning', 'Jueves' => 'badge-warning', 'Viernes' => 'badge-warning', 'Sabado' => 'badge-warning']; ?>
                        <span class="badge <?= $clasesEstado_dia_semana[$reg['dia_semana']] ?? '' ?>"><?= htmlspecialchars(ucfirst($reg['dia_semana'])) ?></span>
                    </td>
                    <td><?= htmlspecialchars($reg['hora_inicio']) ?></td>
                    <td><?= htmlspecialchars($reg['hora_fin']) ?></td>
                    <td><?= htmlspecialchars($reg['area']) ?></td>
                    <td class="acciones">
                        <a href="index.php?route=turnos/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=turnos/delete&id=<?= $reg['id'] ?>"
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