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
$idUsuario = (int) $_SESSION["id"];

// Datos de contacto desde el perfil
$contactoUsuario = [
    'nombre'   => $_SESSION['nombre'] ?? '',
    'telefono' => '',
    'correo'   => '',
];

$perfilStmt = $conexion->prepare("SELECT nombre, telefono, correo FROM usuarios WHERE id = ? LIMIT 1");
if ($perfilStmt) {
    $perfilStmt->bind_param("i", $idUsuario);
    $perfilStmt->execute();
    $perfilStmt->bind_result($contactoUsuario['nombre'], $contactoUsuario['telefono'], $contactoUsuario['correo']);
    $perfilStmt->fetch();
    $perfilStmt->close();
}

// Sacar datos del emprendimiento del usuario usando una consulta preparada
$stmt = $conexion->prepare("SELECT * FROM emprendedores WHERE id = ?");

if (!$stmt) {
    $tieneDatos = false;
    $datos = [];
} else {
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $tieneDatos = $resultado && $resultado->num_rows > 0;
    $datos = $tieneDatos ? $resultado->fetch_assoc() : [];
    $stmt->close();
}

// Helper para evitar avisos cuando falte un dato
function obtenerDato(array $datos, string $campo, string $porDefecto = "No disponible")
{
    if (isset($datos[$campo]) && $datos[$campo] !== "") {
        return htmlspecialchars($datos[$campo], ENT_QUOTES, 'UTF-8');
    }

    return $porDefecto;
}

function mostrarContacto(string $valor, string $porDefecto = "No disponible")
{
    return $valor !== '' ? htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') : $porDefecto;
}
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
            Bienvenido al Panel del Emprendimiento, <?php echo htmlspecialchars($_SESSION["nombre"], ENT_QUOTES, 'UTF-8'); ?>
        </h2>

        <!-- Fila principal -->
        <div class="row g-4">

            <!-- TARJETA DE FOTO -->
            <div class="col-md-4">
                <div class="resumen-box text-center">

                    <!-- Mostrar foto -->
                    <?php if ($tieneDatos && !empty($datos["foto"])): ?>
                        <img src="<?php echo htmlspecialchars($datos["foto"], ENT_QUOTES, 'UTF-8'); ?>" class="foto-perfil img-fluid">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x250?text=Sin+Imagen" class="foto-perfil img-fluid">
                    <?php endif; ?>

                    <h4 class="mt-3 text-primary">
                        <?php
                            echo $tieneDatos
                                ? obtenerDato($datos, "nombre_emprendimiento", "Emprendimiento no registrado")
                                : "Emprendimiento no registrado";
                        ?>
                    </h4>
                    <p class="text-muted">
                        <?php
                            echo $tieneDatos
                                ? obtenerDato($datos, "categoria", "Categoría no asignada")
                                : "Agrega los datos de tu emprendimiento";
                        ?>
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

                    <?php if ($tieneDatos): ?>
                        <!-- Datos -->
                        <p><strong>Emprendimiento:</strong> <?php echo obtenerDato($datos, "nombre_emprendimiento"); ?></p>
                        <p><strong>Categoría:</strong> <?php echo obtenerDato($datos, "categoria"); ?></p>
                        <p><strong>Ubicación:</strong> <?php echo obtenerDato($datos, "ubicacion"); ?></p>
                        <p><strong>Propietario:</strong> <?php echo mostrarContacto($contactoUsuario['nombre']); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo mostrarContacto($contactoUsuario['telefono']); ?></p>
                        <p><strong>Correo:</strong> <?php echo mostrarContacto($contactoUsuario['correo']); ?></p>

                        <!-- Descripción -->
                        <p class="mt-3">
                            <strong>Descripción:</strong><br>
                            <?php echo obtenerDato($datos, "descripcion"); ?>
                        </p>

                        <p><strong>Horarios:</strong><br><?php echo obtenerDato($datos, "horarios"); ?></p>

                        <p><strong>Servicios ofrecidos:</strong><br>
                            <?php echo obtenerDato($datos, "servicios"); ?>
                        </p>

                        <?php if (!empty($datos["servicios_extra"])): ?>
                        <p><strong>Servicios adicionales:</strong><br>
                            <?php echo obtenerDato($datos, "servicios_extra"); ?>
                        </p>
                        <?php endif; ?>


                        <!-- BOTONES DE ACCIÓN GRANDES -->
                        <div class="row mt-4">

                            <div class="col-md-4 mb-2">
                                <a href="editar.php?id=<?php echo urlencode($datos['id']); ?>" class="btn btn-warning w-100">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                            </div>

                            <div class="col-md-4 mb-2">
                                <a href="cambiar_contraseña.php" class="btn btn-warning w-100">
                                      Cambiar Contraseña
                                </a>
                            </div>

                            <div class="col-md-4 mb-2">
                                <a
                                    href="eliminar.php?id=<?php echo urlencode($datos['id']); ?>"
                                    class="btn btn-danger w-100"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar tu emprendimiento?');"
                                >
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </a>
                            </div>

                            <div class="col-md-4 mb-2">
                                <a href="cerrar_sesion.php" class="btn btn-secondary w-100">
                                    <i class="fa-solid fa-right-from-bracket"></i> Salir
                                </a>
                            </div>

                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning" role="alert">
                            No encontramos información de emprendimiento asociada a tu cuenta. Por favor completa tu registro o contacta al administrador.
                        </div>
                        <p class="mb-0">Cuando registres los datos de tu emprendimiento podrás verlos aquí y gestionarlos desde este panel.</p>
                        <a href="crear_emprendimiento.php" class="btn btn-primary mt-3">Registrar mi emprendimiento</a>
                    <?php endif; ?>

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
