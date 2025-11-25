<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a BD
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Recibir filtros
$busqueda = $_GET['q'] ?? "";
$categoriaFiltro = $_GET['categoria'] ?? "";

// ===============================
// Cargar categorías desde BD
// ===============================
$categoriasBD = $conexion->query("SELECT nombre_categoria FROM categorias ORDER BY nombre_categoria ASC");

// ===============================
// Crear consulta principal
// ===============================

// No mostrar admins en el catálogo
$sql = "SELECT * FROM emprendedores WHERE rol = 'emprendedor'";


// Si busca texto
if (!empty($busqueda)) {
    $busquedaLimpia = $conexion->real_escape_string($busqueda);
    $sql .= " AND (nombre_emprendimiento LIKE '%$busquedaLimpia%' 
                OR descripcion LIKE '%$busquedaLimpia%')";
}

// Si filtra por categoría
if (!empty($categoriaFiltro)) {
    $categoriaLimpia = $conexion->real_escape_string($categoriaFiltro);
    $sql .= " AND categoria = '$categoriaLimpia'";
}

// Ejecutar búsqueda
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Emprendimientos - Visita Quibdó</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h2 class="text-center text-primary fw-bold mb-4">Emprendimientos Registrados</h2>

    <!-- ===================== -->
    <!-- FORMULARIO FILTROS -->
    <!-- ===================== -->
    <form method="GET" class="row mb-4">

        <!-- Campo de búsqueda -->
        <div class="col-md-6 mb-2">
            <input type="text" name="q" class="form-control"
                   placeholder="Buscar por nombre o descripción"
                   value="<?php echo htmlspecialchars($busqueda); ?>">
        </div>

        <!-- Selector de categoría dinámico -->
        <div class="col-md-3 mb-2">
            <select name="categoria" class="form-control">

                <option value="">Todas las categorías</option>

                <?php if ($categoriasBD && $categoriasBD->num_rows > 0): ?>
                    <?php while ($cat = $categoriasBD->fetch_assoc()): ?>
                        <?php 
                            $nombre = $cat['nombre_categoria']; 
                            $selected = ($categoriaFiltro === $nombre) ? "selected" : "";
                        ?>
                        <option value="<?php echo $nombre; ?>" <?php echo $selected; ?>>
                            <?php echo $nombre; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>

            </select>
        </div>

        <!-- Botón buscar -->
        <div class="col-md-3 mb-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
            </button>
        </div>

    </form>

    <!-- ===================== -->
    <!-- TARJETAS DE EMPRENDIMIENTOS -->
    <!-- ===================== -->

    <div class="row">

        <?php if ($resultado->num_rows == 0): ?>

            <p class="text-center text-muted">No se encontraron resultados.</p>

        <?php else: ?>

            <?php while ($fila = $resultado->fetch_assoc()): ?>

                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">

                        <!-- Foto -->
                        <?php if (!empty($fila["foto"])): ?>
                            <img src="<?php echo $fila["foto"]; ?>" class="card-img-top" 
                                 style="height:200px; object-fit:cover;">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x200?text=Sin+imagen" class="card-img-top">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title fw-bold text-primary">
                                <?php echo $fila["nombre_emprendimiento"]; ?>
                            </h5>

                            <p><strong>Categoría:</strong> <?php echo $fila["categoria"]; ?></p>
                            <p><strong>Ubicación:</strong> <?php echo $fila["ubicacion"]; ?></p>

                            <p>
                                <?php echo substr($fila["descripcion"], 0, 80) . "..."; ?>
                            </p>

                            <div class="mt-auto">
                                <a href="ver_mas.php?id=<?php echo $fila['id']; ?>" 
                                   class="btn btn-primary w-100">
                                    Ver más
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            <?php endwhile; ?>

        <?php endif; ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conexion->close(); ?>
