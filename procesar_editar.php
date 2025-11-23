<?php
// Iniciar sesión para validar que el usuario esté logueado
session_start();

// Si no hay sesión, redirigir al login
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

// Verificar si hay error al conectar
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario
$id = $_POST['id']; // ID del emprendimiento
$nombre_emprendimiento = $_POST['nombre_emprendimiento'];
$categoria = $_POST['categoria'];
$descripcion = $_POST['descripcion'];
$ubicacion = $_POST['ubicacion'];
$nombre_propietario = $_POST['nombre_propietario'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

// Primero, traemos los datos actuales para obtener la foto anterior
$sqlActual = "SELECT foto FROM emprendedores WHERE id = '$id'";
$resultadoActual = $conexion->query($sqlActual);
$datosActuales = $resultadoActual->fetch_assoc();
$fotoActual = $datosActuales["foto"]; // Guardamos la ruta de la foto vieja

// Empezamos con la foto nueva como la misma de antes
$nuevaFoto = $fotoActual;

// Revisamos si el usuario subió una nueva foto
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
    
    // Creamos un nombre único para la imagen
    $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);
    
    // Carpeta de destino
    $rutaDestino = "fotos/" . $nombreImagen;

    // Movemos la nueva imagen subida
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {

        // Si se movió bien, actualizamos la variable de la nueva foto
        $nuevaFoto = $rutaDestino;

        // Si había una foto anterior, la podemos borrar (opcional)
        if (!empty($fotoActual) && file_exists($fotoActual)) {
            // unlink($fotoActual); // Descomentar si quieres borrar la foto vieja
        }
    }
}

// Armamos el UPDATE para guardar cambios
$sqlUpdate = "UPDATE emprendedores SET 
    nombre_emprendimiento = '$nombre_emprendimiento',
    categoria = '$categoria',
    descripcion = '$descripcion',
    ubicacion = '$ubicacion',
    nombre_propietario = '$nombre_propietario',
    telefono = '$telefono',
    correo = '$correo',
    foto = '$nuevaFoto'
    WHERE id = '$id'";

// Ejecutamos el UPDATE
if ($conexion->query($sqlUpdate) === TRUE) {
    // Si todo salió bien, avisamos y mandamos al panel
    echo "<script>
            alert('Cambios guardados correctamente.');
            window.location.href = 'panel.php';
          </script>";
} else {
    // Si hay error, lo mostramos
    echo "Error al actualizar: " . $conexion->error;
}

// Cerramos la conexión
$conexion->close();
?>
