<?php
// Crear administrador manualmente
// --- SOLO EL ADMINISTRADOR GENERAL DEBE TENER ACCESO A ESTE ARCHIVO ---

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $contraseña = $_POST["contraseña"];

    // Hash de contraseña
    $hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Verificar correo duplicado
    $check = $conexion->query("SELECT id FROM emprendedores WHERE correo = '$correo'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Ese correo ya está registrado'); history.back();</script>";
        exit();
    }

    // Insertar admin
    $sql = "INSERT INTO emprendedores (nombre_emprendimiento, correo, contraseña, rol)
            VALUES ('$nombre', '$correo', '$hash', 'admin')";

    if ($conexion->query($sql)) {
        echo "<script>alert('Administrador creado correctamente'); window.location='inicio_sesion.php';</script>";
    } else {
        echo "Error: " . $conexion->error;
    }

    $conexion->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center text-primary fw-bold mb-4">Crear Administrador</h3>

    <form method="POST" class="p-4 bg-white shadow rounded">

        <div class="mb-3">
            <label class="form-label">Nombre del Administrador</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo del Administrador</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Crear Administrador</button>

    </form>
</div>

</body>
</html>
