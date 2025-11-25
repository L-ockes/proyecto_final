<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// Recibir datos
$nombre = $_POST["nombre"];
$telefono = $_POST["telefono"];


// ----------------------
// FOTO
// ----------------------
$sqlFoto = "SELECT foto FROM usuarios WHERE id='$id'";
$resFoto = $conexion->query($sqlFoto);
$fotoActual = $resFoto->fetch_assoc()["foto"];

$nuevaFoto = $fotoActual;

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
    $archivo = time() . "_" . basename($_FILES["foto"]["name"]);
    $ruta = "fotos/" . $archivo;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta)) {
        $nuevaFoto = $ruta;
    }
}

// ----------------------
// CONTRASEÑA NUEVA
// ----------------------
$pass1 = $_POST["pass1"];
$pass2 = $_POST["pass2"];
$updatePassword = "";

if (!empty($pass1) || !empty($pass2)) {

    if ($pass1 !== $pass2) {
        echo "<script>alert('Las contraseñas no coinciden'); history.back();</script>";
        exit();
    }

    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $pass1)) {
        echo "<script>alert('La contraseña debe tener mínimo 6 caracteres, una letra y un número'); history.back();</script>";
        exit();
    }

    $hash = password_hash($pass1, PASSWORD_DEFAULT);
    $updatePassword = ", contraseña = '$hash'";
}

// ----------------------
// UPDATE FINAL
// ----------------------
$sql = "UPDATE usuarios SET 
        nombre='$nombre',
        telefono='$telefono',
        foto='$nuevaFoto'
        $updatePassword
        WHERE id='$id'";

if ($conexion->query($sql)) {

    // Actualizar sesión
    $_SESSION["nombre"] = $nombre;
    $_SESSION["foto"] = $nuevaFoto;

    echo "<script>alert('Perfil actualizado correctamente'); window.location='panel_usuario.php';</script>";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
