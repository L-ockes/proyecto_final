<?php
// ==========================================
// inicio_sesion.php
// Procesa el inicio de sesión del usuario
// ==========================================

// 1. -----------------------------------------
// Conectar con la base de datos
// -----------------------------------------
$servidor = "localhost";   // Servidor local en XAMPP
$usuario = "root";         // Usuario por defecto
$clave = "";               // Contraseña por defecto (vacía)
$bd = "visita_quibdo";     // Nombre de tu base de datos

$conn = new mysqli($servidor, $usuario, $clave, $bd);

// Si la conexión falla
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


// 2. -----------------------------------------
// Recibir datos del formulario enviado por POST
// -----------------------------------------
$correo = $_POST["correo"];
$contraseña = $_POST["contraseña"];


// 3. -----------------------------------------
// Verificar si el correo existe en la BD
// -----------------------------------------
$sql = "SELECT * FROM emprendedores WHERE correo='$correo'";
$resultado = $conn->query($sql);


// 4. -----------------------------------------
// Validar si se encontró el correo
// -----------------------------------------
if ($resultado->num_rows > 0) {

    // Convertimos el resultado en un arreglo
    $fila = $resultado->fetch_assoc();

    // 5. -------------------------------------
    // Validar contraseña ingresada con la BD
    // -------------------------------------
    if ($fila["contraseña"] === $contraseña) {

        // Iniciar sesión correcta
        session_start();

        // Guardamos datos del usuario para usar en el panel
        $_SESSION["id"] = $fila["id_emprendedor"];
        $_SESSION["nombre"] = $fila["nombre_emprendimiento"];

        // Redirigir al panel del emprendedor
        header("Location: panel.php");
        exit();

    } else {
        // Contraseña incorrecta
        echo "<h3 style='color:red;'>Contraseña incorrecta</h3>";
        echo "<a href='inicio_sesion.html'>Intentar de nuevo</a>";
    }

} else {
    // No existe el correo
    echo "<h3 style='color:red;'>El correo no está registrado</h3>";
    echo "<a href='inicio_sesion.html'>Volver al inicio</a>";
}


// 6. -----------------------------------------
// Cerrar conexión
// -----------------------------------------
$conn->close();
?>
