<?php
// Iniciamos sesión (por si queremos mostrar cosas distintas si hay login)
session_start();

// Conectamos a la base de datos
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

// Revisamos si hay error de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtenemos el id del emprendimiento desde la URL (GET)
$id = $_GET['id'] ?? null; // Si no existe, será null

// Si no hay id, mostramos error simple
if ($id === null) {
    die("No se especificó el emprendimiento.");
}

// Buscamos ese emprendimiento en la base de datos
$sql = "SELECT * FROM emprendedores WHERE id = '$id'";
$resultado = $conexion->query($sql);

// Si no se encuentra, mostramos mensaje
if ($resultado->num_rows == 0) {
    die("Emprendimiento no encontrado.");
}

// Guardamos los datos del emprendimiento
$emprendimiento = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Definimos idioma y codificación -->
    <meta charset="UTF-8">
    <!-- Título de la página -->
    <title><?php echo $emprendimiento['nombre_emprendimiento']; ?> - Detalles</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Menú superior -->
    <?php include("includes/navbar.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-5">

        <!-- Tarjeta con la información completa -->
        <div class="card shadow-lg">
            
            <!-- Si tiene foto, la mostramos -->
            <?php if (!empty($emprendimiento["foto"])): ?>
                <img src="<?php echo $emprendimiento["foto"]; ?>" class="card-img-top" style="max-height: 300px; object-fit: cover;">
            <?php else: ?>
                <img src="https://via.placeholder.com/800x300?text=Sin+Imagen" class="card-img-top">
            <?php endif; ?>

            <!-- Cuerpo de la tarjeta -->
            <div class="card-body">
                <!-- Nombre del emprendimiento -->
                <h3 class="card-title text-primary fw-bold">
                    <?php echo $emprendimiento["nombre_emprendimiento"]; ?>
                </h3>

                <!-- Categoría -->
                <p class="card-text">
                    <strong>Categoría:</strong> <?php echo $emprendimiento["categoria"]; ?>
                </p>

                <!-- Propietario -->
                <p class="card-text">
                    <strong>Propietario:</strong> <?php echo $emprendimiento["nombre_propietario"]; ?>
                </p>

                <!-- Ubicación -->
                <p class="card-text">
                    <strong>Ubicación:</strong> <?php echo $emprendimiento["ubicacion"]; ?>
                </p>

                <!-- Teléfono -->
                <p class="card-text">
                    <strong>Teléfono:</strong> <?php echo $emprendimiento["telefono"]; ?>
                </p>

                <!-- Correo -->
                <p class="card-text">
                    <strong>Correo:</strong> <?php echo $emprendimiento["correo"]; ?>
                </p>

                <!-- Descripción completa -->
                <p class="card-text mt-3">
                    <strong>Descripción:</strong><br>
                    <?php echo nl2br($emprendimiento["descripcion"]); ?>
                </p>

                <!-- Botones -->
                <div class="mt-4">
                    <!-- Botón para volver al listado -->
                    <a href="emprendimientos.php" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Volver a Emprendimientos
                    </a>

                    <!-- Botón de WhatsApp (si tiene teléfono) -->
                    <?php if (!empty($emprendimiento["telefono"])): ?>
                        <?php
                        // Limpiamos el teléfono, quitando espacios
                        $telefonoLimpio = preg_replace('/\s+/', '', $emprendimiento["telefono"]);
                        ?>
                        <a href="https://wa.me/<?php echo $telefonoLimpio; ?>" target="_blank" class="btn btn-success ms-2">
                            <i class="fa-brands fa-whatsapp"></i> Contactar por WhatsApp
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerramos la conexión
$conexion->close();
?>
