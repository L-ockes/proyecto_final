<?php
// Iniciar sesión SOLO si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="/visita_quibdo/styles.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="index.php">Visita Quibdó</a>

        <!-- Botón responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <!-- LINKS IZQUIERDA -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link fw-semibold " href="emprendimientos.php">Emprendimientos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold " href="lugares.php">Lugares Turísticos</a>
                </li>
            </ul>

            <!-- MENÚ DERECHA -->
            <ul class="navbar-nav">

                <?php if (!isset($_SESSION["id"])): ?>

                    <!-- Iniciar sesión + registrar SOLO si NO ha iniciado sesión -->
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm me-2" href="inicio_sesion.php">Iniciar sesión</a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="registro.php">Registrarse</a>
                    </li>

                <?php else: ?>

                    <!-- DROPDOWN DE USUARIO -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center"
                           href="#" id="userMenu" role="button" data-bs-toggle="dropdown">

                            <!-- FOTO DE PERFIL (si existe) -->
                            <?php if (!empty($_SESSION["foto"])): ?>
                                <img src="<?php echo $_SESSION["foto"]; ?>"
                                     style="width:26px; height:26px; border-radius:50%; object-fit:cover; margin-right:6px;">
                            <?php else: ?>
                                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                     style="width:26px; height:26px; border-radius:50%; margin-right:6px;">
                            <?php endif; ?>

                            <?php echo ucfirst($_SESSION["nombre"]); ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <!-- Panel según rol -->
                            <?php if ($_SESSION["rol"] === "admin"): ?>
                                <li><a class="dropdown-item" href="panel_admin.php">Panel Administrador</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="panel.php">Mi Panel</a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>

                            <!-- Cerrar sesión -->
                            <li><a class="dropdown-item text-danger fw-semibold" href="cerrar_sesion.php">Cerrar Sesión</a></li>
                        </ul>

                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>
