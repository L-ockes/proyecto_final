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

// Obtener datos del usuario
$id = $_SESSION["id"];
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$resultado = $conexion->query($sql);
$usuario = $resultado->fetch_assoc();

// Buscar si este usuario tiene un emprendimiento
$sqlEm = "SELECT id FROM emprendedores WHERE id_usuario = '$id' LIMIT 1";
$resEm = $conexion->query($sqlEm);
$tieneEmprendimiento = ($resEm->num_rows > 0);
?>

<?php include("includes/navbar.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
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

    <h2 class="text-center text-primary fw-bold mb-4">Mi Perfil</h2>

    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow p-4 rounded">

            <!-- FOTO -->
            <div class="text-center mb-3">
                <?php if (!empty($usuario["foto"])): ?>
                    <img src="<?php echo $usuario["foto"]; ?>" class="perfil-foto">
                <?php else: ?>
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="perfil-foto">
                <?php endif; ?>
            </div>

            <!-- DATOS -->
            <p><strong>Nombre:</strong> <?php echo $usuario["nombre"]; ?></p>
            <p><strong>Correo:</strong> <?php echo $usuario["correo"]; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $usuario["telefono"]; ?></p>

            <!-- BOTÓN EDITAR PERFIL -->
            <a href="editar_usuario.php" class="btn btn-primary w-100 mt-2">Editar Perfil</a>

            <!-- BOTÓN EMPRENDIMIENTO -->
            <?php if ($tieneEmprendimiento): ?>
                <a href="panel.php" class="btn btn-success w-100 mt-3">Mi Emprendimiento</a>
            <?php else: ?>
                <a href="crear_emprendimiento.php" class="btn btn-warning w-100 mt-3">Publicar mi Emprendimiento</a>
            <?php endif; ?>

        </div>
    </div>

</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conexion->close();
?>
