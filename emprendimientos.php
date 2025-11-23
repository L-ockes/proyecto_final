<?php
// Iniciar sesión (por si necesitamos saber si el usuario está logueado)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

// Verificar error de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir posibles filtros desde la URL (GET)
$busqueda = $_GET['q'] ?? "";         // Texto de búsqueda
$categoriaFiltro = $_GET['categoria'] ?? ""; // Categoría seleccionada

// Empezamos a armar el SQL base
$sql = "SELECT * FROM emprendedores WHERE 1=1";

// Si hay texto en búsqueda, lo usamos en nombre y descripción
if (!empty($busqueda)) {
    $busquedaLimpia = $conexion->real_escape_string($busqueda);
    $sql .= " AND (nombre_emprendimiento LIKE '%$busquedaLimpia%' OR descripcion LIKE '%$busquedaLimpia%')";
}

// Si hay categoría seleccionada, la agregamos al filtro
if (!empty($categoriaFiltro)) {
    $categoriaLimpia = $conexion->real_escape_string($categoriaFiltro);
    $sql .= " AND categoria = '$categoriaLimpia'";
}

// Ejecutamos la consulta final
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Emprendimientos - Visita Quibdó</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Menú -->
    <?php include("includes/navbar.php"); ?>

    <!-- Contenedor principal -->
    <div class="container mt-5">

        <!-- Título -->
        <h2 class="text-center text-primary fw-bold mb-4">Emprendimientos Registrados</h2>

        <!-- FORMULARIO DE BÚSQUEDA Y FILTRO -->
        <form method="GET" class="row mb-4">
            <!-- Campo de búsqueda -->
            <div class="col-md-6 mb-2">
                <input type="text"
                       name="q"
                       class="form-control"
                       placeholder="Buscar por nombre o descripción"
                       value="<?php echo htmlspecialchars($busqueda); ?>">
            </div>

            <!-- Campo de filtro por categoría -->
            <div class="col-md-3 mb-2">
                <select name="categoria" class="form-control">
                    <option value="">Todas las categorías</option>
                    <option value="Comida"     <?php if ($categoriaFiltro == "Comida") echo "selected"; ?>>Comida</option>
                    <option value="Tecnología" <?php if ($categoriaFiltro == "Tecnología") echo "selected"; ?>>Tecnología</option>
                    <option value="Ropa"       <?php if ($categoriaFiltro == "Ropa") echo "selected"; ?>>Ropa</option>
                    <option value="Servicios"  <?php if ($categoriaFiltro == "Servicios") echo "selected"; ?>>Servicios</option>
                    <option value="Otro"       <?php if ($categoriaFiltro == "Otro") echo "selected"; ?>>Otro</option>
                </select>
            </div>

            <!-- Botón de buscar -->
            <div class="col-md-3 mb-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </form>

        <!-- Fila de tarjetas -->
        <div class="row">

            <?php
            // Si no hay resultados, mostramos mensaje
            if ($resultado->num_rows == 0):
            ?>
                <p class="text-center text-muted">No se encontraron emprendimientos con esos filtros.</p>
            <?php
            // Si sí hay resultados, los recorremos
            else:
                while ($fila = $resultado->fetch_assoc()):
            ?>

                <!-- Columna para una tarjeta -->
                <div class="col-md-4 mb-4">
                    <!-- Tarjeta de Bootstrap -->
                    <div class="card shadow h-100">

                        <!-- Imagen del emprendimiento, si tiene foto -->
                        <?php if (!empty($fila["foto"])): ?>
                            <img src="<?php echo $fila["foto"]; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x200?text=Sin+Imagen" class="card-img-top">
                        <?php endif; ?>

                        <!-- Cuerpo de la tarjeta -->
                        <div class="card-body d-flex flex-column">
                            <!-- Nombre -->
                            <h5 class="card-title text-primary fw-bold">
                                <?php echo $fila["nombre_emprendimiento"]; ?>
                            </h5>

                            <!-- Categoría -->
                            <p class="card-text mb-1">
                                <strong>Categoría:</strong> <?php echo $fila["categoria"]; ?>
                            </p>

                            <!-- Ubicación -->
                            <p class="card-text mb-2">
                                <strong>Ubicación:</strong> <?php echo $fila["ubicacion"]; ?>
                            </p>

                            <!-- Descripción recortada -->
                            <p class="card-text">
                                <?php echo substr($fila["descripcion"], 0, 80) . "..."; ?>
                            </p>

                            <!-- Espacio flexible para empujar el botón hacia abajo -->
                            <div class="mt-auto">
                                <!-- Botón para ver más detalles -->
                                <a href="ver_mas.php?id=<?php echo $fila['id']; ?>" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-eye"></i> Ver más
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            <?php
                endwhile;
            endif;
            ?>

        </div>
    </div>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Cerramos conexión
$conexion->close();
?>
