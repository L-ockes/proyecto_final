<?php
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

function normalizarTexto($txt) {
    $txt = trim($txt);
    if ($txt === "") return "";
    return ucfirst($txt);
}

$id          = intval($_POST["id"]);
$nombre      = normalizarTexto($_POST["nombre"]);
$descripcion = normalizarTexto($_POST["descripcion"]);
$direccion   = normalizarTexto($_POST["direccion"]);
$latitud     = $_POST["latitud"];
$longitud    = $_POST["longitud"];

$nombre      = $conexion->real_escape_string($nombre);
$descripcion = $conexion->real_escape_string($descripcion);
$direccion   = $conexion->real_escape_string($direccion);

// Obtener imagen actual
$sqlImg  = "SELECT imagen FROM lugares_turisticos WHERE id=$id";
$resImg  = $conexion->query($sqlImg);
$datos   = $resImg->fetch_assoc();
$imagenActual = $datos["imagen"];

$nuevaImagen = $imagenActual;

// Si sube nueva imagen
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
    $nombreImagen = time() . "_" . basename($_FILES["imagen"]["name"]);
    $rutaDestino  = "fotos/" . $nombreImagen;

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
        $nuevaImagen = $rutaDestino;
    }
}

$sql = "UPDATE lugares_turisticos SET
        nombre = '$nombre',
        descripcion = '$descripcion',
        direccion = '$direccion',
        latitud = '$latitud',
        longitud = '$longitud',
        imagen = '$nuevaImagen'
        WHERE id = $id";

if ($conexion->query($sql)) {
    echo "<script>
            alert('Lugar actualizado correctamente');
            window.location='panel_lugares.php';
          </script>";
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
