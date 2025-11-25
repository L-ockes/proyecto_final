<?php
// Iniciar sesión
session_start();

// Si no está logueado → fuera
if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "emprendedor") {
    header("Location: inicio_sesion.php");
    exit();
}

include("includes/navbar.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5" style="max-width: 480px;">
    <h3 class="text-primary fw-bold text-center mb-4">Cambiar Contraseña</h3>

    <form action="procesar_cambiar_contraseña.php" method="POST" class="p-4 bg-white shadow rounded">

        <!-- Contraseña actual -->
        <div class="mb-3">
            <label class="form-label">Contraseña actual</label>
            <input type="password" name="actual" class="form-control" required>
        </div>

        <!-- Contraseña nueva -->
        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="nueva" class="form-control" required>
        </div>

        <!-- Repetir contraseña nueva -->
        <div class="mb-3">
            <label class="form-label">Repetir nueva contraseña</label>
            <input type="password" name="nueva2" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Guardar Cambios</button>

    </form>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>
