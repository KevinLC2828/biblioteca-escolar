<?php $titulo = 'Empleados - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>🧑‍💼 Empleados</h1>
    <a href="index.php?route=empleados/create" class="btn btn-primary">+ Nuevo(a) empleado</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Empleado creado(a) correctamente.', 'actualizado' => 'Empleado actualizado(a) correctamente.', 'eliminado' => 'Empleado eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<form action="index.php" method="GET" class="formulario-busqueda">
    <input type="hidden" name="route" value="empleados/buscar">
    <input type="text" name="nombres" placeholder="Buscar por nombres..." value="<?= htmlspecialchars($_GET['nombres'] ?? '') ?>">
    <input type="text" name="apellidos" placeholder="Buscar por apellidos..." value="<?= htmlspecialchars($_GET['apellidos'] ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <a href="index.php?route=empleados" class="btn">Limpiar</a>
</form>

<?php if (empty($empleados)): ?>
    <p class="empty-state">No se encontraron registros.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cargo</th>
                <th>Teléfono</th>
                <th>Correo electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombres']) ?></td>
                    <td><?= htmlspecialchars($reg['apellidos']) ?></td>
                    <td><?= htmlspecialchars($reg['cargo']) ?></td>
                    <td><?= htmlspecialchars($reg['telefono']) ?></td>
                    <td><?= htmlspecialchars($reg['email']) ?></td>
                    <td class="acciones">
                        <a href="index.php?route=empleados/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=empleados/delete&id=<?= $reg['id'] ?>"
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