<?php
session_start();

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Traer categorías y servicios para los select
$categorias  = $conexion->query("SELECT nombre_categoria FROM categorias ORDER BY nombre_categoria ASC");
$serviciosBD = $conexion->query("SELECT nombre_servicio FROM servicios ORDER BY nombre_servicio ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Emprendimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="text-primary fw-bold mb-4 text-center">Registrar mi Emprendimiento</h2>

    <form action="procesar_crear_emprendimiento.php" method="POST" enctype="multipart/form-data"
          class="p-4 shadow rounded bg-white">

        <!-- Nombre -->
        <div class="mb-3">
            <label class="form-label">Nombre del Emprendimiento</label>
            <input type="text" name="nombre_emprendimiento" class="form-control" required>
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" id="categoriaSelect" class="form-control" required>
                <?php if ($categorias && $categorias->num_rows > 0): ?>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $cat['nombre_categoria']; ?>">
                            <?php echo $cat['nombre_categoria']; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
                <option value="Otro">Otro</option>
            </select>
            <input type="text" name="categoria_nueva" id="categoriaNueva" class="form-control mt-2"
                   placeholder="Escribe la nueva categoría" style="display:none;">
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>

        <!-- Ubicación -->
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" required>
        </div>

        <!-- Horarios -->
        <div class="mb-3">
            <label class="form-label">Horarios</label>
            <input type="text" name="horarios" class="form-control" placeholder="Ej: Lunes a viernes 8am - 6pm">
        </div>

        <!-- Servicios -->
        <div class="mb-3">
            <label class="form-label">Servicios ofrecidos</label>
            <select name="servicios" id="serviciosSelect" class="form-control" required>
                <?php if ($serviciosBD && $serviciosBD->num_rows > 0): ?>
                    <?php while ($srv = $serviciosBD->fetch_assoc()): ?>
                        <option value="<?php echo $srv['nombre_servicio']; ?>">
                            <?php echo $srv['nombre_servicio']; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
                <option value="Otro">Otro</option>
            </select>
            <input type="text" name="servicio_nuevo" id="servicioNuevo" class="form-control mt-2"
                   placeholder="Describe el servicio" style="display:none;">
        </div>

        <!-- Servicios extra -->
        <div class="mb-3">
            <label class="form-label">Servicios adicionales (opcional)</label>
            <textarea name="servicios_extra" class="form-control"></textarea>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto principal (opcional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary w-100">Guardar Emprendimiento</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const categoriaSelect = document.getElementById('categoriaSelect');
    const categoriaNueva  = document.getElementById('categoriaNueva');
    const serviciosSelect = document.getElementById('serviciosSelect');
    const servicioNuevo   = document.getElementById('servicioNuevo');

    categoriaSelect.addEventListener('change', () => {
        categoriaNueva.style.display = categoriaSelect.value === 'Otro' ? 'block' : 'none';
    });

    serviciosSelect.addEventListener('change', () => {
        servicioNuevo.style.display = serviciosSelect.value === 'Otro' ? 'block' : 'none';
    });
</script>

</body>
</html>
<?php
$conexion->close();
?>
