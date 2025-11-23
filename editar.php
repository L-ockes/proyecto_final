<?php
session_start();

// Si no hay usuario logueado, redirigir
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}

$id = $_SESSION["id"];

// Obtener datos actuales
$sql = "SELECT * FROM emprendedores WHERE id='$id'";
$resultado = $conexion->query($sql);
$datos = $resultado->fetch_assoc();

// Convertir servicios en arreglo para marcar checkbox
$servicios_guardados = explode(", ", $datos["servicios"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Emprendimiento</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="text-primary fw-bold mb-4 text-center">Editar Mi Emprendimiento</h2>

    <form action="procesar_editar.php" method="POST" enctype="multipart/form-data" class="p-4 shadow rounded bg-white">

        <!-- Nombre -->
        <div class="mb-3">
            <label class="form-label">Nombre del Emprendimiento</label>
            <input type="text" name="nombre_emprendimiento" class="form-control"
            value="<?php echo $datos['nombre_emprendimiento']; ?>" required>
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-control" required>
                <option <?php if($datos['categoria']=="Gastronomía") echo "selected"; ?>>Gastronomía</option>
                <option <?php if($datos['categoria']=="Artesanías") echo "selected"; ?>>Artesanías</option>
                <option <?php if($datos['categoria']=="Tecnología") echo "selected"; ?>>Tecnología</option>
                <option <?php if($datos['categoria']=="Servicios") echo "selected"; ?>>Servicios</option>
                <option <?php if($datos['categoria']=="Ropa") echo "selected"; ?>>Ropa</option>
                <option <?php if($datos['categoria']=="Otro") echo "selected"; ?>>Otro</option>
            </select>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?php echo $datos['descripcion']; ?></textarea>
        </div>

        <!-- Ubicación -->
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" value="<?php echo $datos['ubicacion']; ?>" required>
        </div>

        <!-- Horarios -->
        <div class="mb-3">
            <label class="form-label">Horarios</label>
            <textarea name="horarios" class="form-control"><?php echo $datos['horarios']; ?></textarea>
        </div>

        <!-- Servicios -->
        <div class="mb-3">
            <label class="form-label">Servicios Ofrecidos</label><br>

            <input type="checkbox" name="servicios[]" value="Domicilios"
                <?php if(in_array("Domicilios",$servicios_guardados)) echo "checked"; ?>> Domicilios <br>

            <input type="checkbox" name="servicios[]" value="Pedidos"
                <?php if(in_array("Pedidos",$servicios_guardados)) echo "checked"; ?>> Pedidos <br>

            <input type="checkbox" name="servicios[]" value="Atención presencial"
                <?php if(in_array("Atención presencial",$servicios_guardados)) echo "checked"; ?>> Atención presencial <br>

            <input type="checkbox" name="servicios[]" value="Envíos nacionales"
                <?php if(in_array("Envíos nacionales",$servicios_guardados)) echo "checked"; ?>> Envíos nacionales <br>

            <label class="form-label mt-2">Servicios adicionales:</label>
            <textarea name="servicios_extra" class="form-control"><?php echo $datos['servicios_extra']; ?></textarea>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto actual</label><br>
            <img src="<?php echo $datos['foto']; ?>" width="200" class="rounded mb-3"><br>

            <label class="form-label">Cambiar foto (opcional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <!-- Botón -->
        <button class="btn btn-success w-100">Guardar Cambios</button>

    </form>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>
