<?php
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

$sql = "INSERT INTO emprendedores (nombre, categoria, descripcion, direccion, telefono, correo)
        VALUES ('$nombre','$categoria','$descripcion','$direccion','$telefono','$correo')";

if ($conexion->query($sql) === TRUE) {
    echo "¡Registro exitoso!";
} else {
    echo "Error al registrar: " . $conexion->error;
}

$conexion->close();
?>
