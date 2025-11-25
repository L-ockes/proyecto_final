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
$idUsuario = (int) $_SESSION["id"];

// Traemos los datos del emprendimiento para saber si tiene foto
$stmtSelect = $conexion->prepare("SELECT foto FROM emprendedores WHERE id = ? LIMIT 1");

if (!$stmtSelect) {
    die("No se pudo preparar la consulta de búsqueda de emprendimiento.");
}

$stmtSelect->bind_param("i", $idUsuario);
$stmtSelect->execute();
$resultado = $stmtSelect->get_result();

// Si no hay fila, mostramos mensaje
if ($resultado->num_rows == 0) {
    $stmtSelect->close();
    die("No se encontró el emprendimiento a eliminar.");
}

$datos = $resultado->fetch_assoc();
$foto = $datos["foto"];
$stmtSelect->close();

// Eliminamos el registro de la base de datos
$stmtDelete = $conexion->prepare("DELETE FROM emprendedores WHERE id = ? LIMIT 1");

if (!$stmtDelete) {
    die("No se pudo preparar la eliminación del emprendimiento.");
}

$stmtDelete->bind_param("i", $idUsuario);

if ($stmtDelete->execute()) {

    // Si hay foto y el archivo existe, la podemos borrar (opcional)
    if (!empty($foto) && file_exists($foto)) {
        // unlink($foto); // Descomentar si quieres borrar la foto físicamente
    }

    echo "<script>
            alert('Tu emprendimiento ha sido eliminado, tu cuenta permanece activa.');
            window.location.href = 'panel.php';
          </script>";
} else {
    echo "Error al eliminar: " . $stmtDelete->error;
}

$stmtDelete->close();

// Cerramos conexión
$conexion->close();
?>
