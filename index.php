<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Visita Quibdó - Emprendimientos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php include("includes/navbar.php"); ?>

    <!-- HERO -->
    <header class="bg-light py-5 text-center">
        <div class="container">

            <h1 class="fw-bold text-primary">
                <?php 
                if (isset($_SESSION["nombre"])) {
                    echo "Apoya los Emprendimientos de Quibdó, " . $_SESSION["nombre"] . "!";
                } else {
                    echo "Apoya los Emprendimientos de Quibdó";
                }
                ?>
            </h1>

            <p class="lead">
                Conecta con negocios locales, descubre talentos y promueve el crecimiento de la comunidad.
            </p>

            <?php if (!isset($_SESSION["id"])): ?>
                <a href="registro.php" class="btn btn-success btn-lg mt-3">Registrar Emprendimiento</a>
                <a href="inicio_sesion.php" class="btn btn-outline-primary btn-lg mt-3">Iniciar Sesión</a>
            <?php else: ?>
                <a href="panel.php" class="btn btn-primary btn-lg mt-3">Ir a Mi Panel</a>
            <?php endif; ?>

        </div>
    </header>

    <section class="container my-5">
        <h2 class="text-center text-primary fw-bold">¿Qué es Visita Quibdó?</h2>
        <p class="text-center mt-3 fs-5">
            Una plataforma digital creada para impulsar a los emprendedores de Quibdó,
            brindando un espacio donde puedan visibilizar sus productos, servicios y proyectos.
        </p>
    </section>

    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
