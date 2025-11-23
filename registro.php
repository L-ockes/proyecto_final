<?php include("includes/navbar.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Emprendimiento</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Registrar Emprendimiento</h3>
            </div>

            <div class="card-body">

                <form action="procesar_registro.php" method="POST" enctype="multipart/form-data">


                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Emprendimiento</label>
                        <input type="text" class="form-control" name="nombre_emprendimiento" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoría</label>
                        <select class="form-control" name="categoria" required>
                            <option value="">Seleccione</option>
                            <option value="Comida">Comida</option>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Ropa">Ropa</option>
                            <option value="Servicios">Servicios</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea class="form-control" name="descripcion" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Propietario</label>
                        <input type="text" class="form-control" name="nombre_propietario" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Teléfono</label>
                        <input type="number" class="form-control" name="telefono" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" name="contraseña" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto del emprendimiento</label>
                        <input type="file" class="form-control" name="foto">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Registrar</button>
                </form>

            </div>
        </div>

    </div>

    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
