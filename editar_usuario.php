<?php
session_start();

// Si no hay usuario logueado → redirigir
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// Obtener datos actuales
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$res = $conexion->query($sql);
$usuario = $res->fetch_assoc();
?>

<?php include("includes/navbar.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .perfil-foto {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0d6efd;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <h2 class="text-center text-primary fw-bold mb-4">Editar Perfil</h2>

    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow rounded p-4">

            <!-- FOTO ACTUAL -->
            <div class="text-center mb-3">
                <?php if (!empty($usuario["foto"])): ?>
                    <img src="<?php echo $usuario["foto"]; ?>" class="perfil-foto">
                <?php else: ?>
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="perfil-foto">
                <?php endif; ?>
            </div>

            <form action="procesar_editar_usuario.php" method="POST" enctype="multipart/form-data">

                <!-- Nombre -->
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                           value="<?php echo $usuario['nombre']; ?>" required>
                </div>

                <!-- Teléfono -->
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control"
                           value="<?php echo $usuario['telefono']; ?>" required>
                </div>

                <!-- Nueva foto -->
                <div class="mb-3">
                    <label class="form-label">Cambiar foto (opcional)</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <hr>

                <!-- Cambiar contraseña -->
                <h5 class="fw-bold text-primary">Cambiar Contraseña</h5>

                <div class="mb-3">
                    <label class="form-label">Nueva contraseña</label>
                    <input type="password" name="pass1" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Repetir contraseña</label>
                    <input type="password" name="pass2" class="form-control">
                </div>

                <!-- Botón -->
                <button class="btn btn-success w-100">Guardar Cambios</button>
            </form>

        </div>
    </div>

</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conexion->close(); ?>
