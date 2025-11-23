<?php
// Iniciar la sesión para saber qué usuario está logueado
session_start();

// Si NO hay usuario en sesión, lo mandamos al inicio de sesión
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php"); // Redirige al login si no está logueado
    exit(); // Detiene el código
}

// Conectamos a la base de datos
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

// Si hay error en la conexión, mostramos mensaje y paramos
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Guardamos el id del usuario logueado
$idUsuario = $_SESSION["id"];

// Buscamos el emprendimiento de ese usuario
$sql = "SELECT * FROM emprendedores WHERE id = '$idUsuario'";
$resultado = $conexion->query($sql);

// Si no se encuentra, mostramos error simple
if ($resultado->num_rows == 0) {
    die("No se encontró el emprendimiento del usuario.");
}

// Guardamos los datos en un arreglo
$datos = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Definimos que la página está en español y codificación UTF-8 -->
    <meta charset="UTF-8">
    <!-- Título de la pestaña del navegador -->
    <title>Editar Emprendimiento</title>

    <!-- CSS de Bootstrap para estilos rápidos y responsivos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos de Font Awesome para los botones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tus estilos personalizados -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">

    <!-- Incluimos el menú superior -->
    <?php include("includes/navbar.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-5">
        <!-- Título centrado -->
        <h2 class="text-center text-primary fw-bold mb-4">Editar mi Emprendimiento</h2>

        <!-- Tarjeta que contiene el formulario -->
        <div class="card shadow-lg">
            <!-- Encabezado de la tarjeta -->
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Actualiza tus datos</h4>
            </div>

            <!-- Cuerpo de la tarjeta -->
            <div class="card-body">
                <!-- Formulario para editar -->
                <!-- enctype multipart para poder subir archivos (foto) -->
                <form action="procesar_editar.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- Campo oculto con el ID del emprendimiento -->
                    <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">

                    <!-- Nombre del emprendimiento -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Emprendimiento</label>
                        <input type="text" class="form-control" name="nombre_emprendimiento"
                               value="<?php echo $datos['nombre_emprendimiento']; ?>" required>
                    </div>

                    <!-- Categoría -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoría</label>
                        <input type="text" class="form-control" name="categoria"
                               value="<?php echo $datos['categoria']; ?>" required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="4" required><?php echo $datos['descripcion']; ?></textarea>
                    </div>

                    <!-- Ubicación -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion"
                               value="<?php echo $datos['ubicacion']; ?>" required>
                    </div>

                    <!-- Nombre del propietario -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Propietario</label>
                        <input type="text" class="form-control" name="nombre_propietario"
                               value="<?php echo $datos['nombre_propietario']; ?>" required>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="text" class="form-control" name="telefono"
                               value="<?php echo $datos['telefono']; ?>" required>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo</label>
                        <input type="email" class="form-control" name="correo"
                               value="<?php echo $datos['correo']; ?>" required>
                    </div>

                    <!-- Foto actual (si existe) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Foto actual</label>
                        <?php if (!empty($datos["foto"])): ?>
                            <img src="<?php echo $datos['foto']; ?>" class="img-fluid mb-2" style="max-height: 200px;">
                        <?php else: ?>
                            <p class="text-muted">No hay foto registrada.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Subir una nueva foto (opcional) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cambiar foto (opcional)</label>
                        <input type="file" class="form-control" name="foto">
                    </div>

                    <!-- Botones -->
                    <div class="text-center">
                        <!-- Botón para guardar cambios -->
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
                        </button>

                        <!-- Botón para volver al panel -->
                        <a href="panel.php" class="btn btn-secondary px-4 ms-2">
                            <i class="fa-solid fa-arrow-left"></i> Volver al panel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?php include("includes/footer.php"); ?>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerramos la conexión a la base de datos
$conexion->close();
?>
