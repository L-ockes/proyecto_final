<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$sql = "SELECT * FROM emprendedores WHERE correo = '$correo'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();

    if ($fila["contraseña"] === $contraseña) {

        // Guardar sesión
        $_SESSION["id"] = $fila["id"];
        $_SESSION["nombre"] = $fila["nombre_propietario"];

        echo "<script>
                alert('Sesión iniciada correctamente.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Contraseña incorrecta.');
                window.location.href = 'inicio_sesion.php';
              </script>";
    }

} else {
    echo "<script>
            alert('El correo no está registrado.');
            window.location.href = 'inicio_sesion.php';
          </script>";
}

$conexion->close();
?>
