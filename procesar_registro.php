<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

function limpiar($txt) {
    return ucfirst(strtolower(trim($txt)));
}

$nombre      = limpiar($_POST["nombre"]);
$telefono    = $_POST["telefono"];
$correo      = $conexion->real_escape_string($_POST["correo"]);
$pass        = $_POST["contraseña"];
$pass2       = $_POST["contraseña2"];

// Validar contraseñas
if ($pass !== $pass2) {
    echo "<script>alert('Las contraseñas no coinciden'); history.back();</script>";
    exit();
}

// Validar correo único
$check = $conexion->query("SELECT id FROM usuarios WHERE correo='$correo'");
if ($check->num_rows > 0) {
    echo "<script>alert('El correo ya está en uso'); history.back();</script>";
    exit();
}

// Hash seguro
$passHash = password_hash($pass, PASSWORD_DEFAULT);

// FOTO PERFIL
$foto = "";
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $nombreFoto = time() . "_" . basename($_FILES["foto"]["name"]);
    $ruta = "fotos/" . $nombreFoto;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta)) {
        $foto = $ruta;
    }
}

// INSERTAR USER
$sql = "INSERT INTO usuarios (nombre, telefono, correo, contraseña, foto, rol)
        VALUES ('$nombre', '$telefono', '$correo', '$passHash', '$foto', 'usuario')";

if ($conexion->query($sql)) {
    echo "<script>alert('Cuenta creada con éxito'); window.location='inicio_sesion.php';</script>";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
