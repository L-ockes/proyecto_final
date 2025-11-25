<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener lugares turísticos
$sql = "SELECT * FROM lugares_turisticos ORDER BY id DESC";
$resultado = $conexion->query($sql);
?>

<?php include("includes/navbar.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lugares Turísticos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="text-primary fw-bold mb-4 text-center">Lugares Turísticos</h2>

    <!-- ================================
         BOTONES SOLO PARA ADMIN
    =================================== -->
    <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin"): ?>
        <div class="d-flex justify-content-center gap-3 mb-4">
            <a href="panel_lugares.php" class="btn btn-primary fw-semibold">
                🗂️ Panel de Lugares
            </a>
        </div>
    <?php endif; ?>

    <!-- Lista de lugares -->
    <div class="row">
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($lugar = $resultado->fetch_assoc()): ?>
                
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">

                        <?php if (!empty($lugar["imagen"])): ?>
                            <img src="<?php echo $lugar["imagen"]; ?>" 
                                 class="card-img-top" style="height: 220px; object-fit: cover;">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x220?text=Sin+Imagen" 
                                 class="card-img-top">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">
                                <?php echo $lugar["nombre"]; ?>
                            </h5>

                            <p class="card-text">
                                <?php echo substr($lugar["descripcion"], 0, 80) . "..."; ?>
                            </p>

                            <p class="text-muted small">
                                📍 <?php echo $lugar["direccion"] ?: "Dirección no disponible"; ?>
                            </p>

                            <a href="ver_lugar.php?id=<?php echo $lugar['id']; ?>" class="btn btn-outline-primary w-100">
                                Ver más
                            </a>
                        </div>

                    </div>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-muted">No hay lugares registrados aún.</p>
        <?php endif; ?>
    </div>

</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
