<?php
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre_emprendimiento = $_POST['nombre_emprendimiento'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$ubicacion = $_POST['ubicacion'];
$nombre_propietario = $_POST['nombre_propietario'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// -------- MANEJO DE FOTO --------
$foto = "";

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {

    // Crear nombre único
    $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);

    // Ruta de destino
    $rutaDestino = "fotos/" . $nombreImagen;

    // Mover archivo subido
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
        $foto = $rutaDestino;
    }
}
// ----------------------------------

// Query final (INCLUYENDO FOTO)
$sql = "INSERT INTO emprendedores 
(nombre_emprendimiento, categoria, descripcion, ubicacion, nombre_propietario, telefono, correo, contraseña, foto)
VALUES 
('$nombre_emprendimiento', '$categoria', '$descripcion', '$ubicacion', '$nombre_propietario', '$telefono', '$correo', '$contraseña', '$foto')";

// Ejecutar consulta
if ($conexion->query($sql) === TRUE) {
    echo "<script>
            alert('Registro exitoso. Ahora inicia sesión.');
            window.location.href = 'inicio_sesion.php';
          </script>";
} else {
    echo "Error: " . $conexion->error;
}

$conexion->close();
?>
