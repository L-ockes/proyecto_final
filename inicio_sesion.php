<?php include("includes/navbar.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Visita Quibdó</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Iniciar Sesión</h3>
            </div>

            <div class="card-body">

                <form action="procesar_login.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" name="contraseña" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>

                    <div class="text-center mt-3">
                        <a href="registro.php">¿No tienes cuenta? Regístrate</a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
