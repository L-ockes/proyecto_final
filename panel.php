<?php
// Iniciar sesión
session_start();

// Si el usuario no está logueado, enviarlo al login
if (!isset($_SESSION["id"])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Conectar con la base de datos
$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Guardar el ID del usuario logueado
$idUsuario = $_SESSION["id"];

// Sacar datos del emprendimiento del usuario
$sql = "SELECT * FROM emprendedores WHERE id = '$idUsuario'";
$resultado = $conexion->query($sql);
$datos = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard del Emprendedor</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <style>
        /* Fondo suave */
        body {
            background: #f3f4f7;
        }

        /* Tarjeta principal */
        .dashboard-card {
            transition: .3s;
        }

        /* Efecto hover en las tarjetas */
        .dashboard-card:hover {
            transform: scale(1.03);
        }

        /* Foto del emprendimiento */
        .foto-perfil {
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
        }

        /* Caja resumen */
        .resumen-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include("includes/navbar.php"); ?>

    <div class="container mt-5">

        <!-- Título principal -->
        <h2 class="text-primary fw-bold mb-4 text-center">
            Bienvenido al Panel del Emprendimiento, <?php echo $_SESSION["nombre"]; ?>
        </h2>

        <!-- Fila principal -->
        <div class="row g-4">

            <!-- TARJETA DE FOTO -->
            <div class="col-md-4">
                <div class="resumen-box text-center">

                    <!-- Mostrar foto -->
                    <?php if (!empty($datos["foto"])): ?>
                        <img src="<?php echo $datos["foto"]; ?>" class="foto-perfil img-fluid">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x250?text=Sin+Imagen" class="foto-perfil img-fluid">
                    <?php endif; ?>

                    <h4 class="mt-3 text-primary">
                        <?php echo $datos["nombre_emprendimiento"]; ?>
                    </h4>
                    <p class="text-muted">
                        <?php echo $datos["categoria"]; ?>
                    </p>

                    <!-- Botón ver en catálogo -->
                    <a href="emprendimientos.php" class="btn btn-outline-primary mt-2 w-100">
                        <i class="fa-solid fa-eye"></i> Ver Público
                    </a>

                </div>
            </div>

            <!-- TARJETA DE INFORMACIÓN -->
            <div class="col-md-8">
                <div class="resumen-box">

                    <h4 class="mb-3 text-primary fw-bold">
                        Información del Emprendimiento
                    </h4>

                    <!-- Datos -->
                    <p><strong>Emprendimiento:</strong> <?php echo $datos["nombre_emprendimiento"]; ?></p>
                    <p><strong>Categoría:</strong> <?php echo $datos["categoria"]; ?></p>
                    <p><strong>Ubicación:</strong> <?php echo $datos["ubicacion"]; ?></p>
                    <p><strong>Propietario:</strong> <?php echo $datos["nombre_propietario"]; ?></p>
                    <p><strong>Teléfono:</strong> <?php echo $datos["telefono"]; ?></p>
                    <p><strong>Correo:</strong> <?php echo $datos["correo"]; ?></p>

                    <!-- Descripción -->
                    <p class="mt-3">
                        <strong>Descripción:</strong><br>
                        <?php echo $datos["descripcion"]; ?>
                    </p>

                    <p><strong>Horarios:</strong><br><?php echo $datos["horarios"]; ?></p>

                    <p><strong>Servicios ofrecidos:</strong><br>
                        <?php echo $datos["servicios"]; ?>
                    </p>

                    <?php if (!empty($datos["servicios_extra"])): ?>
                    <p><strong>Servicios adicionales:</strong><br>
                        <?php echo $datos["servicios_extra"]; ?>
                    </p>
                    <?php endif; ?>


                    <!-- BOTONES DE ACCIÓN GRANDES -->
                    <div class="row mt-4">

                        <div class="col-md-4 mb-2">
                            <a href="editar.php?id=<?php echo $datos['id']; ?>" class="btn btn-warning w-100">
                                <i class="fa-solid fa-pen"></i> Editar
                            </a>
                        </div>

                        <div class="col-md-4 mb-2">
                            <a href="cambiar_contraseña.php" class="btn btn-warning w-100">
                                  Cambiar Contraseña
                            </a>
                        </div>    

                        <div class="col-md-4 mb-2">
                            <a href="eliminar.php?id=<?php echo $datos['id']; ?>" class="btn btn-danger w-100">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </a>
                        </div>

                        <div class="col-md-4 mb-2">
                            <a href="cerrar_sesion.php" class="btn btn-secondary w-100">
                                <i class="fa-solid fa-right-from-bracket"></i> Salir
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
// Cerrar conexión
$conexion->close();
?>
