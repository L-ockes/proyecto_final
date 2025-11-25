<?php
session_start();

// Verificar que haya sesión
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// Función para normalizar texto
function normalizarTexto($txt) {
    $txt = trim($txt);
    return ($txt !== "") ? ucfirst(strtolower($txt)) : "";
}

// =========================
// 1. RECIBIR DATOS
// =========================
$nombre_emprendimiento = normalizarTexto($_POST['nombre_emprendimiento']);
$categoria             = $_POST['categoria'];
$categoria_nueva       = normalizarTexto($_POST['categoria_nueva'] ?? "");

$descripcion           = normalizarTexto($_POST['descripcion']);
$ubicacion             = normalizarTexto($_POST['ubicacion']);
$horarios              = normalizarTexto($_POST['horarios']);

$servicio              = $_POST["servicio"];
$servicio_nuevo        = normalizarTexto($_POST["servicio_nuevo"] ?? "");

$correo                = $_POST["correo"] ?? "";
$telefono              = $_POST["telefono"] ?? "";

// =========================
// 2. VALIDACIONES AVANZADAS
// =========================

// Validar nombre duplicado (excepto el propio)
$nombreLimpio = $conexion->real_escape_string($nombre_emprendimiento);
$queryNombre = $conexion->query("SELECT id FROM emprendedores WHERE nombre_emprendimiento = '$nombreLimpio' AND id != '$id'");

if ($queryNombre->num_rows > 0) {
    echo "<script>alert('El nombre del emprendimiento ya existe'); history.back();</script>";
    exit();
}

// Validar correo duplicado
if (!empty($correo)) {
    $correoLimpio = $conexion->real_escape_string($correo);
    $queryCorreo = $conexion->query("SELECT id FROM emprendedores WHERE correo = '$correoLimpio' AND id != '$id'");

    if ($queryCorreo->num_rows > 0) {
        echo "<script>alert('Ese correo pertenece a otro emprendimiento'); history.back();</script>";
        exit();
    }
}

// =========================
// 3. PROCESAR CATEGORÍA NUEVA
// =========================
if ($categoria === "Otro" && !empty($categoria_nueva)) {
    $categoria_nueva = $conexion->real_escape_string($categoria_nueva);

    $checkCat = $conexion->query("SELECT id FROM categorias WHERE nombre_categoria = '$categoria_nueva'");
    if ($checkCat->num_rows == 0) {
        $conexion->query("INSERT INTO categorias (nombre_categoria) VALUES ('$categoria_nueva')");
    }

    $categoria = $categoria_nueva;
}

// =========================
// 4. PROCESAR SERVICIO NUEVO
// =========================
if ($servicio === "Otro" && !empty($servicio_nuevo)) {
    $servicio_nuevo = $conexion->real_escape_string($servicio_nuevo);

    $checkSrv = $conexion->query("SELECT id FROM servicios WHERE nombre_servicio = '$servicio_nuevo'");
    if ($checkSrv->num_rows == 0) {
        $conexion->query("INSERT INTO servicios (nombre_servicio) VALUES ('$servicio_nuevo')");
    }

    $servicios = $servicio_nuevo;
} else {
    $servicios = $conexion->real_escape_string($servicio);
}

// =========================
// 5. FOTO
// =========================
$sqlFoto   = "SELECT foto FROM emprendedores WHERE id='$id'";
$resultFoto = $conexion->query($sqlFoto);
$datosFoto  = $resultFoto->fetch_assoc();
$fotoActual = $datosFoto["foto"];

$nuevaFoto = $fotoActual; // Por defecto

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
    $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);
    $rutaDestino  = "fotos/" . $nombreImagen;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        $nuevaFoto = $rutaDestino;
    }
}

// =========================
// 6. ACTUALIZAR BD
// =========================
$sql = "UPDATE emprendedores SET
        nombre_emprendimiento = '$nombre_emprendimiento',
        categoria            = '$categoria',
        descripcion          = '$descripcion',
        ubicacion            = '$ubicacion',
        horarios             = '$horarios',
        servicios            = '$servicios',
        foto                 = '$nuevaFoto'
        WHERE id             = '$id'";

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
