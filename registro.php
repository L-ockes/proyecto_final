<?php include("includes/navbar.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>

    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="text-primary fw-bold text-center mb-4">Crear Cuenta</h2>

    <form action="procesar_registro_usuario.php" method="POST"
          enctype="multipart/form-data"
          class="p-4 shadow rounded bg-white"
          style="max-width: 500px; margin: auto;">

        <!-- Nombre -->
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <!-- Correo -->
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" autocomplete="email" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="tel" name="telefono" class="form-control"
                   inputmode="numeric"
                   pattern="\d{10}"
                   maxlength="10"
                   oninput="this.value=this.value.replace(/\D/g,'').slice(0,10);"
                   placeholder="Ej: 3123456789"
                   required>
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Repetir contraseña</label>
            <input type="password" name="contraseña2" class="form-control" required>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto de perfil (opcional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary w-100">Registrarse</button>

        <p class="text-center mt-3">
            ¿Ya tienes cuenta?
            <a href="inicio_sesion.php">Inicia sesión aquí</a>
        </p>
    </form>

</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
