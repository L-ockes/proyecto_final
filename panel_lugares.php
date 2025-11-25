<?php
session_start();

// Solo admin puede entrar
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: inicio_sesion.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "visita_quibdo");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$resultado = $conexion->query("SELECT * FROM lugares_turisticos ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Lugares Turísticos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* FOOTER PEGADO ABAJO */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        footer { margin-top: auto; }
    </style>
</head>

<body>

<?php include("includes/navbar.php"); ?>

<div class="panel-lugares-wrapper">   <!-- 🟦 AGREGADO -->
<main class="container mt-5">
<h2 class="text-primary fw-bold text-center mb-4">Panel de Lugares Turísticos</h2>

    <div class="text-end mb-3">
        <a href="agregar_lugar.php" class="btn btn-success">Agregar nuevo lugar</a>
    </div>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Coordenadas</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila["id"]; ?></td>

                <td>
                    <?php if (!empty($fila["imagen"])): ?>
                        <img src="<?php echo $fila["imagen"]; ?>" width="80" height="60" style="object-fit: cover; border-radius: 6px;">
                    <?php else: ?>
                        <span class="text-muted">Sin imagen</span>
                    <?php endif; ?>
                </td>

                <td><?php echo $fila["nombre"]; ?></td>
                <td><?php echo $fila["direccion"]; ?></td>

                <td>
                    <small>
                        Lat: <?php echo $fila["latitud"]; ?><br>
                        Lng: <?php echo $fila["longitud"]; ?>
                    </small>
                </td>

                <td>
                    <a href="editar_lugar.php?id=<?php echo $fila['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminar_lugar.php?id=<?php echo $fila['id']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Seguro que deseas eliminar este lugar?');">
                       Eliminar
                    </a>
                </td>

            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

</div> <!-- 🟦 CIERRE DEL WRAPPER -->

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $conexion->close(); ?>
