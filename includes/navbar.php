<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Visita Quibdó</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>

                <li class="nav-item"><a href="emprendimientos.php" class="nav-link">Emprendimientos</a></li>

                <?php if (!isset($_SESSION["id"])): ?>
                    <li class="nav-item"><a href="registro.php" class="nav-link">Registrar</a></li>
                    <li class="nav-item"><a href="inicio_sesion.php" class="nav-link">Iniciar sesión</a></li>
                <?php else: ?>
                    <li class="nav-item">
                        <span class="nav-link text-warning fw-bold">
                            Bienvenido, <?php echo $_SESSION["nombre"]; ?>
                        </span>
                    </li>

                    <li class="nav-item"><a href="panel.php" class="nav-link">Mi Panel</a></li>

                    <li class="nav-item">
                        <a href="cerrar_sesion.php" class="btn btn-danger btn-sm ms-2">Cerrar sesión</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
