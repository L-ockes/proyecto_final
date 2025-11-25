<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$idUsuario = (int) $_SESSION["id"];

// Evitar duplicados: si ya tiene emprendimiento, regresar al panel
$verificar = $conexion->prepare("SELECT id FROM emprendedores WHERE id = ? LIMIT 1");
if ($verificar) {
    $verificar->bind_param("i", $idUsuario);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        $verificar->close();
        $conexion->close();
        echo "<script>alert('Ya tienes un emprendimiento registrado.'); window.location='panel.php';</script>";
        exit();
    }

    $verificar->close();
}

// Normalizar textos
function limpiarTexto(mysqli $conexion, string $valor): string
{
    return $conexion->real_escape_string(trim($valor));
}

$nombreEmprendimiento = limpiarTexto($conexion, $_POST['nombre_emprendimiento'] ?? '');
$categoria            = limpiarTexto($conexion, $_POST['categoria'] ?? '');
$categoriaNueva       = limpiarTexto($conexion, $_POST['categoria_nueva'] ?? '');
$descripcion          = limpiarTexto($conexion, $_POST['descripcion'] ?? '');
$ubicacion            = limpiarTexto($conexion, $_POST['ubicacion'] ?? '');
$horarios             = limpiarTexto($conexion, $_POST['horarios'] ?? '');
$servicioSeleccionado = limpiarTexto($conexion, $_POST['servicios'] ?? '');
$servicioNuevo        = limpiarTexto($conexion, $_POST['servicio_nuevo'] ?? '');
$serviciosExtra       = limpiarTexto($conexion, $_POST['servicios_extra'] ?? '');

// Datos de contacto desde el perfil del usuario
$datosUsuario = [
    'nombre'   => '',
    'telefono' => '',
    'correo'   => '',
];

$perfilStmt = $conexion->prepare("SELECT nombre, telefono, correo FROM usuarios WHERE id = ? LIMIT 1");
if ($perfilStmt) {
    $perfilStmt->bind_param("i", $idUsuario);
    $perfilStmt->execute();
    $perfilStmt->bind_result($datosUsuario['nombre'], $datosUsuario['telefono'], $datosUsuario['correo']);
    $perfilStmt->fetch();
    $perfilStmt->close();
}

// Categoría: registrar nueva si elige "Otro"
if ($categoria === 'Otro' && $categoriaNueva !== '') {
    $checkCategoria = $conexion->query("SELECT id FROM categorias WHERE nombre_categoria = '$categoriaNueva'");
    if ($checkCategoria && $checkCategoria->num_rows === 0) {
        $conexion->query("INSERT INTO categorias (nombre_categoria) VALUES ('$categoriaNueva')");
    }
    $categoria = $categoriaNueva;
}

// Servicio: registrar nuevo si elige "Otro"
if ($servicioSeleccionado === 'Otro' && $servicioNuevo !== '') {
    $checkServicio = $conexion->query("SELECT id FROM servicios WHERE nombre_servicio = '$servicioNuevo'");
    if ($checkServicio && $checkServicio->num_rows === 0) {
        $conexion->query("INSERT INTO servicios (nombre_servicio) VALUES ('$servicioNuevo')");
    }
    $servicios = $servicioNuevo;
} else {
    $servicios = $servicioSeleccionado;
}

// Foto
$foto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $nombreImagen = time() . "_" . basename($_FILES['foto']['name']);
    $rutaDestino  = "fotos/" . $nombreImagen;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
        $foto = $rutaDestino;
    }
}

$propietario = $datosUsuario['nombre'] !== ''
    ? $datosUsuario['nombre']
    : (isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '');

$telefono = $datosUsuario['telefono'] !== '' ? $datosUsuario['telefono'] : 'Sin teléfono';
$correo   = $datosUsuario['correo'] !== '' ? $datosUsuario['correo'] : 'Sin correo';

$propietario = limpiarTexto($conexion, $propietario);
$telefono    = limpiarTexto($conexion, $telefono);
$correo      = limpiarTexto($conexion, $correo);

$hashAleatorio = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

$stmt = $conexion->prepare("INSERT INTO emprendedores (id, nombre_emprendimiento, categoria, descripcion, ubicacion, nombre_propietario, telefono, correo, contraseña, foto, foto_perfil, horarios, servicios, servicios_extra, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', ?, ?, ?, 'emprendedor')");

if (!$stmt) {
    $conexion->close();
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param(
    "issssssssssss",
    $idUsuario,
    $nombreEmprendimiento,
    $categoria,
    $descripcion,
    $ubicacion,
    $propietario,
    $telefono,
    $correo,
    $hashAleatorio,
    $foto,
    $horarios,
    $servicios,
    $serviciosExtra
);

if ($stmt->execute()) {
    echo "<script>alert('Emprendimiento registrado con éxito'); window.location='panel.php';</script>";
} else {
    echo "Error al registrar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
