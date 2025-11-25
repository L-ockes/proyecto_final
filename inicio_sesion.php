<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<?php include("includes/navbar.php"); ?>

<div class="container mt-5 flex-grow-1">
    <h2 class="text-center text-primary fw-bold">Iniciar Sesión</h2>

    <form action="procesar_login.php" method="POST" 
          class="p-4 bg-white shadow rounded mt-4" 
          style="max-width: 450px; margin: auto;">

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Ingresar</button>

        <p class="text-center mt-3">
            ¿No tienes cuenta?
            <a href="registro.php">Regístrate aquí</a>
        </p>

    </form>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
