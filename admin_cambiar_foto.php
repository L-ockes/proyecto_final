<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {

        $nombreImagen = time() . "_" . basename($_FILES["foto"]["name"]);
        $rutaDestino = "fotos/" . $nombreImagen;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
            $conexion->query("UPDATE emprendedores SET foto='$rutaDestino' WHERE id='$id'");
        }
    }

    echo "<script>alert('Foto actualizada'); window.location='panel_admin.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Foto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-primary fw-bold text-center mb-3">Cambiar Foto de Perfil</h3>

    <form method="POST" enctype="multipart/form-data" class="p-4 bg-white shadow rounded">

        <label class="form-label">Selecciona nueva imagen</label>
        <input type="file" name="foto" class="form-control mb-3" accept="image/*" required>

        <button class="btn btn-info w-100 text-white">Actualizar Foto</button>
    </form>
</div>

</body>
</html>
