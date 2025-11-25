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

// Obtener datos actuales del emprendimiento
$sql       = "SELECT * FROM emprendedores WHERE id='$id'";
$resultado = $conexion->query($sql);
$datos     = $resultado->fetch_assoc();

// Obtener categorías y servicios desde la BD
$categorias  = $conexion->query("SELECT nombre_categoria FROM categorias ORDER BY nombre_categoria ASC");
$serviciosBD = $conexion->query("SELECT nombre_servicio FROM servicios ORDER BY nombre_servicio ASC");
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

        <!-- Categoría dinámica -->
        <div class="mb-3">
            <label class="form-label">Categoría</label>

            <select name="categoria" id="categoriaSelect" class="form-control" required>
                <?php if ($categorias && $categorias->num_rows > 0): ?>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $cat['nombre_categoria']; ?>"
                            <?php if ($datos['categoria'] == $cat['nombre_categoria']) echo "selected"; ?>>
                            <?php echo $cat['nombre_categoria']; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>

                <option value="Otro">Otro</option>
            </select>

            <!-- Campo nueva categoría -->
            <input type="text" name="categoria_nueva" id="categoriaNueva" class="form-control mt-2"
                   placeholder="Escribe la nueva categoría" style="display:none;">
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?php echo $datos['descripcion']; ?></textarea>
        </div>

        <!-- Ubicación -->
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control"
                   value="<?php echo $datos['ubicacion']; ?>" required>
        </div>

        <!-- Horarios -->
        <div class="mb-3">
            <label class="form-label">Horarios</label>
            <textarea name="horarios" class="form-control"><?php echo $datos['horarios']; ?></textarea>
        </div>

        <!-- Servicio principal -->
        <div class="mb-3">
            <label class="form-label">Servicio Ofrecido</label>

            <select name="servicio" id="servicioSelect" class="form-control" required>
                <?php if ($serviciosBD && $serviciosBD->num_rows > 0): ?>
                    <?php while ($srv = $serviciosBD->fetch_assoc()): ?>
                        <?php
                            $nombreSrv = $srv['nombre_servicio'];
                            $selected  = ($datos['servicios'] == $nombreSrv) ? "selected" : "";
                        ?>
                        <option value="<?php echo $nombreSrv; ?>" <?php echo $selected; ?>>
                            <?php echo $nombreSrv; ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>

                <option value="Otro">Otro</option>
            </select>

            <!-- Campo nuevo servicio -->
            <input type="text" name="servicio_nuevo" id="servicioNuevo"
                   class="form-control mt-2" placeholder="Escribe un nuevo servicio" style="display:none;">
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
    <script>
function primeraMayuscula(texto) {
    if (!texto) return "";
    return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
}

// Campos que deben normalizarse automáticamente
const campos = [
    "nombre_emprendimiento",
    "descripcion",
    "ubicacion",
    "horarios",
    "nombre_propietario",
    "categoriaNueva",
    "servicioNuevo"
];

// Activar normalización en cada input
campos.forEach(id => {
    let campo = document.getElementsByName(id)[0] || document.getElementById(id);
    if (campo) {
        campo.addEventListener("input", function () {
            this.value = primeraMayuscula(this.value);
        });
    }
});
</script>

    <script>
function primeraMayuscula(texto) {
    if (!texto) return "";
    return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
}

// Nueva categoría
document.getElementById("categoriaNueva").addEventListener("input", function () {
    this.value = primeraMayuscula(this.value);
});

// Nuevo servicio
document.getElementById("servicioNuevo").addEventListener("input", function () {
    this.value = primeraMayuscula(this.value);
});
</script>

</div>

<?php include("includes/footer.php"); ?>

<!-- Scripts para "Otro" -->
<script>
// Categoría: mostrar input nueva categoría
document.getElementById('categoriaSelect').addEventListener('change', function () {
    let input = document.getElementById('categoriaNueva');
    input.style.display = (this.value === 'Otro') ? 'block' : 'none';
});

// Servicio: mostrar input nuevo servicio
document.getElementById('servicioSelect').addEventListener('change', function () {
    let input = document.getElementById('servicioNuevo');
    input.style.display = (this.value === 'Otro') ? 'block' : 'none';
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
