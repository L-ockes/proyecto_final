<?php
session_start();

// SOLO PERMITIR ADMIN
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// Obtener datos del admin
$sql = "SELECT * FROM emprendedores WHERE id='$id' LIMIT 1";
$result = $conexion->query($sql);
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .panel-card {
            max-width: 600px;
            margin: auto;
        }
        .foto-admin {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #0d6efd;
        }
    </style>
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h2 class="text-center text-primary fw-bold mb-4">Panel de Administrador</h2>

    <div class="card p-4 shadow panel-card">

        <div class="text-center mb-3">
            <?php if (!empty($admin["foto"])): ?>
                <img src="<?php echo $admin["foto"]; ?>" class="foto-admin">
            <?php else: ?>
                <img src="https://via.placeholder.com/150?text=Admin" class="foto-admin">
            <?php endif; ?>
        </div>

        <h4 class="text-center"><?php echo $admin["nombre_emprendimiento"]; ?></h4>
        <p class="text-center text-muted"><?php echo $admin["correo"]; ?></p>

        <hr>

        <a href="cambiar_contraseña_admin.php" class="btn btn-warning w-100 mb-2">
            Cambiar contraseña
        </a>

        <a href="admin_cambiar_foto.php" class="btn btn-info w-100 mb-2 text-white">
            Cambiar foto de perfil
        </a>

        <a href="cerrar_sesion.php" class="btn btn-danger w-100">Cerrar sesión</a>

    </div>

</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
