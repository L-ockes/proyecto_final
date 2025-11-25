<?php
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== 'admin') {
    header("Location: index.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = intval($_GET["id"] ?? 0);

// Opcional: obtener imagen para borrar archivo luego
$sql = "DELETE FROM lugares_turisticos WHERE id = $id";

if ($conexion->query($sql)) {
    echo "<script>
            alert('Lugar eliminado correctamente');
            window.location='panel_lugares.php';
          </script>";
} else {
    echo "Error al eliminar: " . $conexion->error;
}

$conexion->close();
?>
