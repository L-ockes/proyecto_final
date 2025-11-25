<?php
session_start();
include("includes/navbar.php");

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = (int) ($_GET["id"] ?? 0);

$sql = "SELECT e.*, u.nombre AS usuario_nombre, u.telefono AS usuario_telefono, u.correo AS usuario_correo
        FROM emprendedores e
        JOIN usuarios u ON e.id = u.id
        WHERE e.id = ?";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $fila["nombre_emprendimiento"]; ?> - Información</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

    <style>
        /* Imagen correcta para ver_mas */
        .foto-negocio {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 15px;
        }

        .vermas-align {
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .vermas-align {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <h2 class="text-primary fw-bold mb-4 text-center">
        <?php echo $fila["nombre_emprendimiento"]; ?>
    </h2>

    <div class="row vermas-align">

        <!-- FOTO -->
        <div class="col-md-6 text-center mb-4">
            <?php if (!empty($fila["foto"])): ?>
                <img src="<?php echo $fila["foto"]; ?>" class="foto-negocio">
            <?php else: ?>
                <img src="https://via.placeholder.com/500x350?text=Sin+Imagen" class="foto-negocio">
            <?php endif; ?>
        </div>

        <!-- INFORMACIÓN -->
        <div class="col-md-6 info-negocio">

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

             <p><strong>Propietario:</strong> <?php echo htmlspecialchars($fila["usuario_nombre"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($fila["usuario_telefono"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($fila["usuario_correo"] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

            <a href="https://wa.me/57<?php echo htmlspecialchars($fila['usuario_telefono'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
               class="btn btn-success w-100 mt-3">
               <i class="fa-brands fa-whatsapp"></i> Contactar por WhatsApp
            </a>

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="emprendimientos.php" class="btn btn-secondary">Volver al Catálogo</a>
    </div>

</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conexion->close(); ?>
