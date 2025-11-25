<?php
session_start();

// Solo admin
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$id_admin = $_SESSION["id"];

$actual   = $_POST["actual"];
$nueva    = $_POST["nueva"];
$nueva2   = $_POST["nueva2"];

// Validar contraseñas iguales
if ($nueva !== $nueva2) {
    echo "<script>alert('Las contraseñas nuevas no coinciden'); history.back();</script>";
    exit();
}

// Validar seguridad
if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $nueva)) {
    echo "<script>alert('La nueva contraseña debe tener mínimo 6 caracteres, 1 letra y 1 número'); history.back();</script>";
    exit();
}

// Buscar contraseña guardada
$sql = "SELECT contraseña FROM emprendedores WHERE id='$id_admin' LIMIT 1";
$res = $conexion->query($sql);
$admin = $res->fetch_assoc();

if (!password_verify($actual, $admin["contraseña"])) {
    echo "<script>alert('La contraseña actual es incorrecta'); history.back();</script>";
    exit();
}

// Crear hash de la nueva contraseña
$nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);

// Actualizar
$update = "UPDATE emprendedores SET contraseña='$nuevaHash' WHERE id='$id_admin'";
$conexion->query($update);

echo "<script>alert('¡Contraseña actualizada con éxito!'); window.location='panel_admin.php';</script>";
?>
