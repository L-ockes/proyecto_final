<?php
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// ========================================
// FUNCIÓN PARA SOLO LA PRIMERA LETRA EN MAYÚSCULA
// ========================================
function normalizarTexto($txt) {
    $txt = trim($txt);
    if ($txt === "") return "";
    return ucfirst($txt); // ❗ NO toca el resto del texto
}

// ========================================
// 1. RECIBIR DATOS Y NORMALIZAR
// ========================================

$nombre      = normalizarTexto($_POST["nombre"]);
$descripcion = normalizarTexto($_POST["descripcion"]);
$direccion   = normalizarTexto($_POST["direccion"]);

$latitud     = $_POST["latitud"];
$longitud    = $_POST["longitud"];

// Limpiar para evitar caracteres especiales
$nombre      = $conexion->real_escape_string($nombre);
$descripcion = $conexion->real_escape_string($descripcion);
$direccion   = $conexion->real_escape_string($direccion);

// ========================================
// 2. MANEJO DE IMAGEN
// ========================================

$imagen = "";
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {

    $nombreImagen = time() . "_" . basename($_FILES["imagen"]["name"]);
    $rutaDestino  = "fotos/" . $nombreImagen;

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
        $imagen = $rutaDestino;
    }
}

// ========================================
// 3. INSERTAR EN LA BASE DE DATOS
// ========================================

$sql = "INSERT INTO lugares_turisticos (nombre, descripcion, direccion, latitud, longitud, imagen)
        VALUES ('$nombre', '$descripcion', '$direccion', '$latitud', '$longitud', '$imagen')";

if ($conexion->query($sql)) {
    echo "<script>
            alert('¡Lugar registrado correctamente!');
            window.location='mapa.php';
          </script>";
} else {
    echo 'Error al guardar: ' . $conexion->error;
}

$conexion->close();
?>
