<?php
// ============================================
// registro.php
// Recibe los datos del registro y los inserta
// en la base de datos.
// ============================================

// 1. -----------------------------------------
// Conexión con la base de datos
// --------------------------------------------
$servidor = "localhost";    // Servidor local
$usuario = "root";          // Usuario de MySQL en XAMPP
$clave = "";                // Contraseña por defecto
$bd = "visita_quibdo";      // Nombre de tu base de datos

$conn = new mysqli($servidor, $usuario, $clave, $bd);

// Confirmar si hay error en la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// 2. -----------------------------------------
// Recibir datos del formulario (POST)
// --------------------------------------------
$nombre_emprendimiento = $_POST["nombre_emprendimiento"];
$categoria = $_POST["categoria"];
$descripcion = $_POST["descripcion"];
$ubicacion = $_POST["ubicacion"];
$nombre_propietario = $_POST["nombre_propietario"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$contraseña = $_POST["contraseña"];  // <--- CONTRASEÑA AGREGADA

// 3. -----------------------------------------
// Validar si el correo ya existe
// --------------------------------------------
$verificar = "SELECT * FROM emprendedores WHERE correo='$correo'";
$resultado = $conn->query($verificar);

if ($resultado->num_rows > 0) {
    // Si ya existe el correo
    echo "<h3 style='color:red;'>Este correo ya está registrado.</h3>";
    echo "<a href='registro.html'>Volver al registro</a>";
    exit();
}

// 4. -----------------------------------------
// Insertar datos en la tabla
// --------------------------------------------
$sql = "INSERT INTO emprendedores 
        (nombre_emprendimiento, categoria, descripcion, ubicacion, nombre_propietario, telefono, correo, contraseña)
        VALUES
        ('$nombre_emprendimiento', '$categoria', '$descripcion', '$ubicacion', '$nombre_propietario', '$telefono', '$correo', '$contraseña')";

// 5. -----------------------------------------
// Ejecutar la consulta e informar resultado
// --------------------------------------------
if ($conn->query($sql) === TRUE) {
    echo "<h2>Registro exitoso</h2>";
    echo "<p>El emprendimiento fue registrado correctamente.</p>";
    echo "<a href='inicio_sesion.html'>Iniciar sesión</a>";
} else {
    echo "<h3 style='color:red;'>Error al registrar: " . $conn->error . "</h3>";
}

// 6. -----------------------------------------
// Cerrar conexión
// --------------------------------------------
$conn->close();
?>
