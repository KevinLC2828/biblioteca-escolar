<?php $titulo = 'Estudiantes - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/../header.php'; ?>

<div class="page-header">
    <h1>🎓 Estudiantes</h1>
    <a href="index.php?route=estudiantes/create" class="btn btn-primary">+ Nuevo(a) estudiante</a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php
        $mensajes = ['creado' => 'Estudiante creado(a) correctamente.', 'actualizado' => 'Estudiante actualizado(a) correctamente.', 'eliminado' => 'Estudiante eliminado(a) correctamente.'];
        echo htmlspecialchars($mensajes[$_GET['mensaje']] ?? 'Operación realizada.');
        ?>
    </div>
<?php endif; ?>

<form action="index.php" method="GET" class="formulario-busqueda">
    <input type="hidden" name="route" value="estudiantes/buscar">
    <input type="text" name="nombres" placeholder="Buscar por nombres..." value="<?= htmlspecialchars($_GET['nombres'] ?? '') ?>">
    <input type="text" name="apellidos" placeholder="Buscar por apellidos..." value="<?= htmlspecialchars($_GET['apellidos'] ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <a href="index.php?route=estudiantes" class="btn">Limpiar</a>
</form>

<?php if (empty($estudiantes)): ?>
    <p class="empty-state">No se encontraron registros.</p>
<?php else: ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Curso / Grado</th>
                <th>Cédula</th>
                <th>Correo electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $reg): ?>
                <tr>
                    <td><?= htmlspecialchars($reg['nombres']) ?></td>
                    <td><?= htmlspecialchars($reg['apellidos']) ?></td>
                    <td><?= htmlspecialchars($reg['curso_grado']) ?></td>
                    <td><?= htmlspecialchars($reg['cedula']) ?></td>
                    <td><?= htmlspecialchars($reg['email']) ?></td>
                    <td class="acciones">
                        <a href="index.php?route=estudiantes/edit&id=<?= $reg['id'] ?>" class="btn btn-small">Editar</a>
                        <a href="index.php?route=estudiantes/delete&id=<?= $reg['id'] ?>"
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