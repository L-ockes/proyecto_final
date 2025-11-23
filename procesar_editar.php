<?php
session_start();

// Verificar que haya sesión
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Conexión
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// =======================
// 1. Obtener datos del formulario
// =======================

$nombre_emprendimiento = $_POST['nombre_emprendimiento'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$ubicacion = $_POST['ubicacion'];
$horarios = $_POST['horarios'];

// Convertir servicios marcados en texto
$servicios = isset($_POST["servicios"]) ? implode(", ", $_POST["servicios"]) : "";
$servicios_extra = $_POST["servicios_extra"];

$nombre_propietario = $_POST['nombre_propietario'] ?? "";
$telefono = $_POST['telefono'] ?? "";
$correo = $_POST['correo'] ?? "";
$contraseña = $_POST['contraseña'] ?? "";  // (si lo estás editando aquí)


// =======================
// 2. Manejo de la foto
// =======================

// Primero obtenemos la foto actual
$sqlFoto = "SELECT foto FROM emprendedores WHERE id='$id'";
$resultFoto = $conexion->query($sqlFoto);
$datosFoto = $resultFoto->fetch_assoc();
$fotoActual = $datosFoto["foto"];

$nuevaFoto = $fotoActual; // Por defecto, conservar la foto actual

// Si subió una nueva imagen
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {

    // Crear nombre único
    $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);
    $rutaDestino = "fotos/" . $nombreImagen;

    // Mover imagen
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        $nuevaFoto = $rutaDestino;
    }
}


// =======================
// 3. Actualizar datos en la base de datos
// =======================

$sql = "UPDATE emprendedores SET
        nombre_emprendimiento = '$nombre_emprendimiento',
        categoria = '$categoria',
        descripcion = '$descripcion',
        ubicacion = '$ubicacion',
        horarios = '$horarios',
        servicios = '$servicios',
        servicios_extra = '$servicios_extra',
        foto = '$nuevaFoto'
        WHERE id = '$id'";

if ($conexion->query($sql)) {
    echo "<script>
            alert('Cambios guardados correctamente');
            window.location = 'panel.php';
          </script>";
} else {
    echo "Error al actualizar: " . $conexion->error;
}

$conexion->close();
?>
