<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

function normalizarTexto($txt) {
    $txt = trim($txt);
    if ($txt === "") return "";
    return ucfirst(strtolower($txt));
}

// ===============================
// 1. Recibir datos
// ===============================
$nombre_emprendimiento = normalizarTexto($_POST['nombre_emprendimiento']);
$categoria             = $_POST['categoria'];
$categoria_nueva       = normalizarTexto($_POST['categoria_nueva'] ?? "");
$descripcion           = normalizarTexto($_POST['descripcion']);
$ubicacion             = normalizarTexto($_POST['ubicacion']);
$horarios              = normalizarTexto($_POST['horarios']);
$servicio              = $_POST['servicio'];
$servicio_nuevo        = normalizarTexto($_POST['servicio_nuevo'] ?? "");
$nombre_propietario    = normalizarTexto($_POST['nombre_propietario']);
$telefono              = $_POST['telefono'];
$correo                = $_POST['correo'];

$contraseña            = $_POST['contraseña'];
$contraseña2           = $_POST['contraseña2'];

// ===============================
// 2. Validaciones
// ===============================

// Contraseñas iguales
if ($contraseña !== $contraseña2) {
    echo "<script>alert('Las contraseñas no coinciden'); history.back();</script>";
    exit();
}

// Contraseña fuerte
if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{6,}$/", $contraseña)) {
    echo "<script>alert('La contraseña debe tener mínimo 6 caracteres, una letra y un número'); history.back();</script>";
    exit();
}


// Validacion del correo
$dominio = substr(strrchr($correo, "@"), 1);

if (!checkdnsrr($dominio, "MX") && !checkdnsrr($dominio, "A")) {
    echo "<script>alert('El correo no existe o su dominio no es válido'); history.back();</script>";
    exit();
}

// Limpiar caracteres peligrosos
$correo = $conexion->real_escape_string($correo);


// Nombre único
$nombreLimpio = $conexion->real_escape_string($nombre_emprendimiento);
$checkNombre = $conexion->query("SELECT id FROM emprendedores WHERE nombre_emprendimiento='$nombreLimpio'");
if ($checkNombre->num_rows > 0) {
    echo "<script>alert('Ese nombre de emprendimiento ya está registrado'); history.back();</script>";
    exit();
}

// Teléfono único
$checkTel = $conexion->query("SELECT id FROM emprendedores WHERE telefono='$telefono'");
if ($checkTel->num_rows > 0) {
    echo "<script>alert('Ese número de teléfono ya está registrado'); history.back();</script>";
    exit();
}

// ===============================
// 3. Categoría nueva
// ===============================
if ($categoria === "Otro" && !empty($categoria_nueva)) {
    $categoria_nueva = $conexion->real_escape_string($categoria_nueva);

    $existeCat = $conexion->query("SELECT id FROM categorias WHERE nombre_categoria='$categoria_nueva'");
    if ($existeCat->num_rows == 0) {
        $conexion->query("INSERT INTO categorias (nombre_categoria) VALUES ('$categoria_nueva')");
    }
    $categoria = $categoria_nueva;
}

// ===============================
// 4. Servicio nuevo
// ===============================
if ($servicio === "Otro" && !empty($servicio_nuevo)) {
    $servicio_nuevo = $conexion->real_escape_string($servicio_nuevo);

    $existeSrv = $conexion->query("SELECT id FROM servicios WHERE nombre_servicio='$servicio_nuevo'");
    if ($existeSrv->num_rows == 0) {
        $conexion->query("INSERT INTO servicios (nombre_servicio) VALUES ('$servicio_nuevo')");
    }

    $servicios = $servicio_nuevo;
} else {
    $servicios = $conexion->real_escape_string($servicio);
}

$servicios_extra = "";

// ===============================
// 5. Guardar foto
// ===============================
$foto = "";
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
    $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);
    $rutaDestino = "fotos/" . $nombreImagen;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        $foto = $rutaDestino;
    }
}

// ===============================
// 6. Contraseña con hash
// ===============================
$contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);

// ===============================
// 7. Insertar registro
// ===============================
$sql = "INSERT INTO emprendedores 
(nombre_emprendimiento, categoria, descripcion, ubicacion, horarios, servicios, servicios_extra, nombre_propietario, telefono, correo, contraseña, foto, rol)
VALUES 
('$nombre_emprendimiento', '$categoria', '$descripcion', '$ubicacion', '$horarios', '$servicios', '$servicios_extra', '$nombre_propietario', '$telefono', '$correo', '$contraseñaHash', '$foto', 'emprendedor')";

if ($conexion->query($sql)) {
    echo "<script>alert('¡Registro exitoso!'); window.location='inicio_sesion.php';</script>";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
