<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$nombre_emprendimiento = $_POST['nombre_emprendimiento'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$ubicacion = $_POST['ubicacion'];
$horarios = $_POST['horarios'];

$servicios = isset($_POST['servicios']) ? implode(", ", $_POST['servicios']) : "";
$servicios_extra = $_POST['servicios_extra'];

$nombre_propietario = $_POST['nombre_propietario'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$foto = "";
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
    $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);
    $rutaDestino = "fotos/" . $nombreImagen;
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        $foto = $rutaDestino;
    }
}

$sql = "INSERT INTO emprendedores 
(nombre_emprendimiento, categoria, descripcion, ubicacion, horarios, servicios, servicios_extra, nombre_propietario, telefono, correo, contraseña, foto)
VALUES 
('$nombre_emprendimiento', '$categoria', '$descripcion', '$ubicacion', '$horarios', '$servicios', '$servicios_extra', '$nombre_propietario', '$telefono', '$correo', '$contraseña', '$foto')";

if ($conexion->query($sql)) {
    echo "<script>alert('Registro exitoso'); window.location='inicio_sesion.php';</script>";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
