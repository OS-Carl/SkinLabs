<?php
$host = "localhost";      // o 127.0.0.1
$usuario = "root";        // tu usuario de MySQL
$clave = "";              // tu contraseña de MySQL (por defecto en XAMPP está vacía)
$bd = "esba";             // nombre base de datos

// Crear conexión
$conexion = new mysqli($host, $usuario, $clave, $bd);

// Verificar si la conexión es exitosa
if ($conexion->connect_error) {
    die("❌ Error al conectar con la base de datos: " . $conexion->connect_error);
} else {
    // echo "✅ Conexión exitosa"; // Descomentar solo para pruebas
}
?>

