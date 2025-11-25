<?php
session_start();

// Solo admin puede editar
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

// ===============================
// VALIDAR ID DEL LUGAR
// ===============================
if (!isset($_GET["id"])) {
    echo "<script>alert('Lugar no encontrado'); window.location='panel_lugares.php';</script>";
    exit();
}

$id = intval($_GET["id"]);
$sql = "SELECT * FROM lugares_turisticos WHERE id = $id LIMIT 1";
$resultado = $conexion->query($sql);

if ($resultado->num_rows === 0) {
    echo "<script>alert('El lugar no existe'); window.location='panel_lugares.php';</script>";
    exit();
}

$lugar = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Lugar Turístico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <style>
        #mapa {
            height: 400px;
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h2 class="text-primary fw-bold mb-4 text-center">Editar Lugar Turístico</h2>

    <!-- MAPA PARA ELEGIR COORDENADAS -->
    <div id="mapa"></div>

    <form method="POST" action="procesar_editar_lugar.php" enctype="multipart/form-data" class="p-4 bg-white shadow rounded">

        <input type="hidden" name="id" value="<?php echo $lugar["id"]; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required 
                   value="<?php echo $lugar['nombre']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required><?php echo $lugar['descripcion']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección (opcional)</label>
            <input type="text" name="direccion" class="form-control" 
                   value="<?php echo $lugar['direccion']; ?>">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Latitud</label>
                <input type="text" id="latitud" name="latitud" class="form-control" 
                       value="<?php echo $lugar['latitud']; ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Longitud</label>
                <input type="text" id="longitud" name="longitud" class="form-control" 
                       value="<?php echo $lugar['longitud']; ?>" required>
            </div>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto actual:</label><br>
            <img src="<?php echo $lugar['imagen']; ?>" 
                 style="width: 200px; height: 150px; object-fit: cover; border-radius: 10px;">
        </div>

        <div class="mb-3">
            <label class="form-label">Cambiar foto (opcional)</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary w-100">Guardar Cambios</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>


<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Crear mapa
var mapa = L.map('mapa').setView([<?php echo $lugar['latitud']; ?>, <?php echo $lugar['longitud']; ?>], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapa);

var marcador = L.marker([<?php echo $lugar['latitud']; ?>, <?php echo $lugar['longitud']; ?>]).addTo(mapa);

// Elegir nueva ubicación
mapa.on('click', function(e) {
    var lat = e.latlng.lat.toFixed(8);
    var lng = e.latlng.lng.toFixed(8);

    document.getElementById("latitud").value = lat;
    document.getElementById("longitud").value = lng;

    mapa.removeLayer(marcador);
    marcador = L.marker([lat, lng]).addTo(mapa);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
