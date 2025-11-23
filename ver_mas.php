<?php
session_start();
include("includes/navbar.php");

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener ID del emprendimiento
$id = $_GET["id"];

// Consultar datos
$sql = "SELECT * FROM emprendedores WHERE id='$id'";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $fila["nombre_emprendimiento"]; ?> - Información</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container mt-5">

    <!-- Título -->
    <h2 class="text-primary fw-bold mb-4 text-center">
        <?php echo $fila["nombre_emprendimiento"]; ?>
    </h2>

    <div class="row vermas-align">

        <!-- FOTO -->
        <div class="col-md-6 text-center">
            <?php if (!empty($fila["foto"])): ?>
                <img src="<?php echo $fila["foto"]; ?>" class="foto-negocio">
            <?php else: ?>
                <img src="https://via.placeholder.com/500x350?text=Sin+Imagen" class="foto-negocio">
            <?php endif; ?>
        </div>

        <!-- INFORMACIÓN -->
        <div class="col-md-6 info-negocio mt-4 mt-md-0">

            <p><strong>Categoría:</strong> <?php echo $fila["categoria"]; ?></p>

            <p><strong>Ubicación:</strong> <?php echo $fila["ubicacion"]; ?></p>

            <p><strong>Descripción:</strong><br>
                <?php echo $fila["descripcion"]; ?>
            </p>

            <p><strong>Horarios:</strong><br>
                <?php echo $fila["horarios"]; ?>
            </p>

            <p><strong>Servicios ofrecidos:</strong><br>
                <?php echo $fila["servicios"]; ?>
            </p>

            <?php if (!empty($fila["servicios_extra"])): ?>
                <p><strong>Servicios adicionales:</strong><br>
                    <?php echo $fila["servicios_extra"]; ?>
                </p>
            <?php endif; ?>

            <p><strong>Propietario:</strong> <?php echo $fila["nombre_propietario"]; ?></p>

            <p><strong>Teléfono:</strong> <?php echo $fila["telefono"]; ?></p>

            <p><strong>Correo:</strong> <?php echo $fila["correo"]; ?></p>

            <!-- BOTÓN WHATSAPP -->
            <a href="https://wa.me/57<?php echo $fila['telefono']; ?>" class="btn btn-success w-100 mt-3">
                <i class="fa-brands fa-whatsapp"></i> Contactar por WhatsApp
            </a>

        </div>
    </div>

    <!-- BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <a href="emprendimientos.php" class="btn btn-secondary">Volver al Catálogo</a>
    </div>

</div>

<?php include("includes/footer.php"); ?>

</body>
</html>

<?php
$conexion->close();
?>
