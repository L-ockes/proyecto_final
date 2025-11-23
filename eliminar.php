<?php
// Iniciar sesión
session_start();

// Si no hay sesión, redirigir al login
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

// Verificar error en conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtenemos el id del usuario logueado
$idUsuario = $_SESSION["id"];

// Traemos los datos del emprendimiento para saber si tiene foto
$sqlSelect = "SELECT foto FROM emprendedores WHERE id = '$idUsuario'";
$resultado = $conexion->query($sqlSelect);

// Si no hay fila, mostramos mensaje
if ($resultado->num_rows == 0) {
    die("No se encontró el emprendimiento a eliminar.");
}

$datos = $resultado->fetch_assoc();
$foto = $datos["foto"];

// Eliminamos el registro de la base de datos
$sqlDelete = "DELETE FROM emprendedores WHERE id = '$idUsuario'";

if ($conexion->query($sqlDelete) === TRUE) {

    // Si hay foto y el archivo existe, la podemos borrar (opcional)
    if (!empty($foto) && file_exists($foto)) {
        // unlink($foto); // Descomentar si quieres borrar la foto físicamente
    }

    // Cerramos sesión porque ya no tiene emprendimiento
    session_unset();
    session_destroy();

    echo "<script>
            alert('Tu emprendimiento ha sido eliminado.');
            window.location.href = 'index.php';
          </script>";
} else {
    echo "Error al eliminar: " . $conexion->error;
}

// Cerramos conexión
$conexion->close();
?>
