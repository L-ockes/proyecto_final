<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $correo = strtolower(trim($_POST['correo']));
   $correo = $conexion->real_escape_string($correo);

    $contraseña = $_POST["contraseña"];

    $sql = "SELECT * FROM emprendedores WHERE correo = '$correo' LIMIT 1";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();

        // Usar password_verify()
        if (password_verify($contraseña, $usuario["contraseña"])) {

            $_SESSION["id"]     = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre_propietario"];
            $_SESSION["rol"]    = $usuario["rol"];
            $_SESSION["foto"]   = $usuario["foto"];


            // Enviar según el rol
            if ($_SESSION["rol"] === "admin") {
                 header("Location: panel_admin.php");
            } else {
                 header("Location: panel.php");

}
exit();


        } else {
            echo "<script>alert('Contraseña incorrecta'); history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('No existe un usuario con ese correo'); history.back();</script>";
        exit();
    }
}
?>
