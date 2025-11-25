<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Emprendimiento</title>

    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<?php
// Conexión
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Categorías
$categorias = $conexion->query("SELECT nombre_categoria FROM categorias ORDER BY nombre_categoria ASC");

// Servicios
$serviciosBD = $conexion->query("SELECT nombre_servicio FROM servicios ORDER BY nombre_servicio ASC");
?>

<div class="container mt-5">
    <h2 class="text-primary fw-bold text-center mb-4">Registrar Emprendimiento</h2>

    <form action="procesar_registro.php" method="POST" enctype="multipart/form-data" class="p-4 shadow rounded bg-white">

        <!-- Nombre -->
        <div class="mb-3">
            <label class="form-label">Nombre del Emprendimiento</label>
            <input type="text" name="nombre_emprendimiento" class="form-control" required>
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" id="categoriaSelect" class="form-control">
                <?php while ($cat = $categorias->fetch_assoc()): ?>
                    <option value="<?= $cat['nombre_categoria'] ?>"><?= $cat['nombre_categoria'] ?></option>
                <?php endwhile; ?>
                <option value="Otro">Otro</option>
            </select>

            <input type="text" name="categoria_nueva" id="categoriaNueva" class="form-control mt-2" placeholder="Nueva categoría" style="display:none;">
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
            <textarea name="horarios" class="form-control"></textarea>
        </div>

        <!-- Servicios -->
        <div class="mb-3">
            <label class="form-label">Servicio ofrecido</label>

            <select name="servicio" id="servicioSelect" class="form-control">
                <?php while ($srv = $serviciosBD->fetch_assoc()): ?>
                    <option value="<?= $srv['nombre_servicio'] ?>"><?= $srv['nombre_servicio'] ?></option>
                <?php endwhile; ?>
                <option value="Otro">Otro</option>
            </select>

            <input type="text" name="servicio_nuevo" id="servicioNuevo" class="form-control mt-2" placeholder="Nuevo servicio" style="display:none;">
        </div>

        <!-- Datos propietario -->
        <div class="mb-3">
            <label class="form-label">Nombre del Propietario</label>
            <input type="text" name="nombre_propietario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="number" name="telefono" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <!-- Contraseñas -->
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Repetir contraseña</label>
            <input type="password" name="contraseña2" class="form-control" required>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto del negocio</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary w-100">Registrar</button>

        <p class="text-center mt-3">
            ¿Ya tienes cuenta?
            <a href="inicio_sesion.php">Inicia sesión aquí</a>
        </p>

    </form>
</div>

<?php include("includes/footer.php"); ?>

<script>
document.getElementById('categoriaSelect').addEventListener('change', e => {
    document.getElementById('categoriaNueva').style.display = e.target.value === "Otro" ? "block" : "none";
});

document.getElementById('servicioSelect').addEventListener('change', e => {
    document.getElementById('servicioNuevo').style.display = e.target.value === "Otro" ? "block" : "none";
});

function primeraMayuscula(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
}

document.querySelectorAll("input[type=text], textarea").forEach(campo => {
    campo.addEventListener("input", function () {
        this.value = primeraMayuscula(this.value);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
