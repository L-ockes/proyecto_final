<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Lugar Turístico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <style>
        #mapa {
            height: 400px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="text-primary fw-bold text-center mb-4">Registrar Lugar Turístico</h2>

    <!-- MAPA PARA SELECCIONAR COORDENADAS -->
    <div id="mapa"></div>

    <form action="procesar_lugar.php" method="POST" enctype="multipart/form-data" class="p-4 bg-white shadow rounded">

        <div class="mb-3">
            <label class="form-label">Nombre del Lugar</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección (opcional)</label>
            <input type="text" name="direccion" class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Latitud</label>
                <input type="text" id="latitud" name="latitud" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Longitud</label>
                <input type="text" id="longitud" name="longitud" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div> 
        
        <button class="btn btn-primary w-100">Guardar Lugar</button>

    </form>
</div>

<?php include("includes/footer.php"); ?>

<!-- LEAFLET JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Mapa centrado en Quibdó
var mapa = L.map('mapa').setView([5.6944, -76.6611], 14);

// Capa base
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(mapa);

var marcador;

// Al hacer clic en el mapa, obtener coordenadas
mapa.on('click', function(e) {

    var lat = e.latlng.lat.toFixed(8);
    var lng = e.latlng.lng.toFixed(8);

    document.getElementById("latitud").value = lat;
    document.getElementById("longitud").value = lng;

    if (marcador) {
        mapa.removeLayer(marcador);
    }

    marcador = L.marker([lat, lng]).addTo(mapa)
        .bindPopup("Coordenadas seleccionadas:<br>Lat: " + lat + "<br>Lng: " + lng)
        .openPopup();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
