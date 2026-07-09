<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Biblioteca Escolar' ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="navbar-brand">📚 Biblioteca Escolar</div>
        <nav>
            <a href="index.php?route=inicio">Inicio</a>
            <a href="index.php?route=libros">Libros</a>
            <a href="index.php?route=prestamos">Préstamos</a>
            <a href="index.php?route=editoriales">Editoriales</a>
            <a href="index.php?route=adquisiciones">Adquisiciones</a>
            <a href="index.php?route=estudiantes">Estudiantes</a>
            <a href="index.php?route=sanciones">Sanciones</a>
            <a href="index.php?route=empleados">Empleados</a>
            <a href="index.php?route=turnos">Turnos</a>
            <a href="index.php?route=salas">Salas</a>
            <a href="index.php?route=reservas">Reservas</a>
        </nav>
    </header>
    <main class="container">