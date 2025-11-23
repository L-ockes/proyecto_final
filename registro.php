<?php include("includes/navbar.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Emprendimiento</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-primary fw-bold text-center mb-4">Registrar Emprendimiento</h2>

    <form action="procesar_registro.php" method="POST" enctype="multipart/form-data" class="p-4 shadow rounded bg-white">

        <!-- Nombre del emprendimiento -->
        <div class="mb-3">
            <label class="form-label">Nombre del Emprendimiento</label>
            <input type="text" name="nombre_emprendimiento" class="form-control" required>
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-control" required>
                <option value="Gastronomía">Gastronomía</option>
                <option value="Artesanías">Artesanías</option>
                <option value="Tecnología">Tecnología</option>
                <option value="Servicios">Servicios</option>
                <option value="Ropa">Ropa</option>
                <option value="Otro">Otro</option>
            </select>
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

        <!-- Horarios (texto libre) -->
        <div class="mb-3">
            <label class="form-label">Horarios</label>
            <textarea name="horarios" class="form-control" placeholder="Ejemplo: Lunes a sábado 8am-6pm"></textarea>
        </div>

        <!-- Servicios (checkbox + extra) -->
        <div class="mb-3">
            <label class="form-label">Servicios Ofrecidos</label><br>

            <input type="checkbox" name="servicios[]" value="Domicilios"> Domicilios <br>
            <input type="checkbox" name="servicios[]" value="Pedidos"> Pedidos <br>
            <input type="checkbox" name="servicios[]" value="Atención presencial"> Atención presencial <br>
            <input type="checkbox" name="servicios[]" value="Envíos nacionales"> Envíos nacionales <br>

            <label class="form-label mt-2">Otros servicios (texto):</label>
            <textarea name="servicios_extra" class="form-control"></textarea>
        </div>

        <!-- Datos del propietario -->
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

        <!-- Contraseña -->
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="contraseña" class="form-control" required>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto del Negocio</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <!-- Botón registrar -->
        <button class="btn btn-primary w-100">Registrar</button>

    </form>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>
