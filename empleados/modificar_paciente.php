<?php
include("../php/conexion.php");
// para guardar el cambio del paciente modificado
// Comprobamos que el formulario se haya enviado (mediante POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperamos los datos del formulario
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    
    // Actualizamos los datos del paciente en la base de datos
    $stmt = $conexion->prepare("UPDATE pacientes SET nombre=?, telefono=?, direccion=?, fecha_nacimiento=? WHERE dni=?");
    $stmt->bind_param("sssss", $nombre, $telefono, $direccion, $fecha_nacimiento, $dni);
    
    if ($stmt->execute()) {
        // Redirigimos al listado de empleados con un mensaje de éxito
        header("Location: index_empleados.php?msg=Paciente modificado exitosamente");
        exit;
    } else {
        echo "Error al modificar el paciente.";
    }
}
?>
