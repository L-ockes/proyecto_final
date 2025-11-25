<?php
session_start();

// Solo emprendedores
if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "emprendedor") {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// Recibir datos
$actual = $_POST["actual"];
$nueva = $_POST["nueva"];
$nueva2 = $_POST["nueva2"];

// Confirmar nueva contraseña
if ($nueva !== $nueva2) {
    echo "<script>alert('Las contraseñas nuevas no coinciden'); history.back();</script>";
    exit();
}

// Validar seguridad
if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $nueva)) {
    echo "<script>alert('La nueva contraseña debe tener al menos 6 caracteres, 1 letra y 1 número'); history.back();</script>";
    exit();
}

// Obtener contraseña actual
$sql = "SELECT contraseña FROM emprendedores WHERE id='$id'";
$res = $conexion->query($sql);
$emp = $res->fetch_assoc();

// Verificar contraseña actual
if (!password_verify($actual, $emp["contraseña"])) {
    echo "<script>alert('La contraseña actual es incorrecta'); history.back();</script>";
    exit();
}

// Crear hash nuevo
$nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);

// Guardar
$update = "UPDATE emprendedores SET contraseña='$nuevaHash' WHERE id='$id'";
$conexion->query($update);

echo "<script>alert('¡Contraseña actualizada con éxito!'); window.location='panel.php';</script>";
?>
