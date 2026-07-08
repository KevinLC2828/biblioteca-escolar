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
        </nav>
    </header>
    <main class="container">