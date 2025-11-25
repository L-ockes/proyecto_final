<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

function limpiar($txt) {
    return ucfirst(strtolower(trim($txt)));
}

$nombre = limpiar($_POST["nombre"]);
$correo = $conexion->real_escape_string($_POST["correo"]);
$telefono = $conexion->real_escape_string($_POST["telefono"]);
$pass1 = $_POST["contraseña"];
$pass2 = $_POST["contraseña2"];

// Validar contraseñas
if ($pass1 !== $pass2) {
    echo "<script>alert('Las contraseñas no coinciden'); history.back();</script>";
    exit();
}

// Contraseña segura
if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $pass1)) {
    echo "<script>alert('La contraseña debe tener mínimo 6 caracteres, una letra y un número'); history.back();</script>";
    exit();
}

// Validar correo único
$checkCorreo = $conexion->query("SELECT id FROM usuarios WHERE correo='$correo'");
if ($checkCorreo->num_rows > 0) {
    echo "<script>alert('El correo ya está registrado'); history.back();</script>";
    exit();
}

// Validar teléfono único
$checkTel = $conexion->query("SELECT id FROM usuarios WHERE telefono='$telefono'");
if ($checkTel->num_rows > 0) {
    echo "<script>alert('El teléfono ya está registrado'); history.back();</script>";
    exit();
}

// FOTO
$foto = "";
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
    $nombreFoto = time() . "_" . $_FILES["foto"]["name"];
    $ruta = "fotos/" . $nombreFoto;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta)) {
        $foto = $ruta;
    }
}

$hash = password_hash($pass1, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, correo, telefono, contraseña, foto, rol)
        VALUES ('$nombre', '$correo', '$telefono', '$hash', '$foto', 'usuario')";

if ($conexion->query($sql)) {
    echo "<script>alert('Registro exitoso'); window.location='inicio_sesion.php';</script>";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
