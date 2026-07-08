<?php $titulo = 'Inicio - Biblioteca Escolar'; ?>
<?php require __DIR__ . '/header.php'; ?>

<section class="hero">
    <h1>Sistema de Gestión de Biblioteca Escolar</h1>
    <p>Administra el catálogo de libros y controla los préstamos realizados a los estudiantes.</p>

    <div class="cards">
        <a href="index.php?route=libros" class="card">
            <h2>📖 Libros</h2>
            <p>Registrar, editar, consultar y eliminar libros del catálogo.</p>
        </a>
        <a href="index.php?route=prestamos" class="card">
            <h2>🗂️ Préstamos</h2>
            <p>Gestionar préstamos, devoluciones y estado de cada ejemplar.</p>
        </a>
    </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>