<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar que se envió un ID
if (!isset($_GET["id"])) {
    die("Lugar no encontrado");
}

$id = intval($_GET["id"]);

// Consultar lugar
$sql = "SELECT * FROM lugares_turisticos WHERE id = $id LIMIT 1";
$resultado = $conexion->query($sql);

if ($resultado->num_rows == 0) {
    die("Lugar no encontrado");
}

$lugar = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lugar["nombre"]; ?> - Lugar Turístico</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <style>
        #mapa {
            height: 350px;
            width: 100%;
            border-radius: 10px;
            margin-top: 15px;
        }

        .foto-lugar {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h2 class="text-primary fw-bold text-center mb-4">
        <?php echo $lugar["nombre"]; ?>
    </h2>

    <div class="row">

        <!-- Foto -->
        <div class="col-md-6 mb-3">
            <img src="<?php echo $lugar["imagen"]; ?>" class="foto-lugar">
        </div>

        <!-- Info -->
        <div class="col-md-6">

            <p><strong>Descripción:</strong><br>
                <?php echo $lugar["descripcion"]; ?>
            </p>

            <?php if (!empty($lugar["direccion"])): ?>
                <p><strong>Dirección:</strong><br>
                    <?php echo $lugar["direccion"]; ?>
                </p>
            <?php endif; ?>

            <p><strong>Coordenadas:</strong><br>
                Lat: <?php echo $lugar["latitud"]; ?><br>
                Lng: <?php echo $lugar["longitud"]; ?>
            </p>

        </div>
    </div>

    <!-- Mapa -->
    <div id="mapa"></div>

    <!-- Botón volver -->
    <div class="text-center mt-4">
        <a href="lugares.php" class="btn btn-secondary">Volver</a>
    </div>

</div>

<?php include("includes/footer.php"); ?>

<!-- Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Crear mapa
var mapa = L.map('mapa').setView(
    [<?php echo $lugar["latitud"]; ?>, <?php echo $lugar["longitud"]; ?>], 
    15
);

// Capa base
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: "© OpenStreetMap"
}).addTo(mapa);

// Marcador
L.marker([<?php echo $lugar["latitud"]; ?>, <?php echo $lugar["longitud"]; ?>])
  .addTo(mapa)
  .bindPopup("<?php echo $lugar['nombre']; ?>")
  .openPopup();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conexion->close(); ?>
