<?php $titulo = 'Préstamos - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>Préstamos</h1>
    <a href="index.php?route=prestamos/create" class="btn btn-primary">+ Nuevo préstamo</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = [
            'creado'      => 'Préstamo registrado correctamente.',
            'actualizado' => 'Préstamo actualizado correctamente.',
            'eliminado'   => 'Préstamo eliminado correctamente.',
            'devuelto'    => 'Préstamo marcado como devuelto.',
        ];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<?php if (empty($prestamosLista)): ?>
    <p class="empty-state">No hay préstamos registrados todavía.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Libro</th>
                <th>Prestatario</th>
                <th>Curso/Grado</th>
                <th>F. Préstamo</th>
                <th>F. Dev. Esperada</th>
                <th>F. Dev. Real</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamosLista as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['titulo']) ?></td>
                    <td><?= htmlspecialchars($p['nombre_prestatario']) ?></td>
                    <td><?= htmlspecialchars($p['curso_grado']) ?></td>
                    <td><?= htmlspecialchars($p['fecha_prestamo']) ?></td>
                    <td><?= htmlspecialchars($p['fecha_devolucion_esperada']) ?></td>
                    <td><?= htmlspecialchars($p['fecha_devolucion_real'] ?? '—') ?></td>
                    <td>
                        <?php
                        $clases = ['prestado' => 'badge-warning', 'devuelto' => 'badge-success', 'atrasado' => 'badge-danger'];
                        ?>
                        <span class="badge <?= $clases[$p['estado']] ?? '' ?>"><?= htmlspecialchars(ucfirst($p['estado'])) ?></span>
                    </td>
                    <td class="acciones">
                        <a href="index.php?route=prestamos/edit&id=<?= $p['id'] ?>" class="btn btn-small">Editar</a>
                        <?php if ($p['estado'] !== 'devuelto'): ?>
                            <a href="index.php?route=prestamos/devolver&id=<?= $p['id'] ?>"
                               class="btn btn-small btn-success"
                               onclick="return confirm('¿Marcar este préstamo como devuelto?');">
                               Devolver
                            </a>
                        <?php endif; ?>
                        <a href="index.php?route=prestamos/delete&id=<?= $p['id'] ?>"
                           class="btn btn-small btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar este préstamo?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>