<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $dni = $_POST['dni'];
    $id_profesional = $_POST['id_profesional'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $observaciones = $_POST['observaciones'];

    // Verificar si el DNI del paciente existe
    $sql = "SELECT id FROM pacientes WHERE dni = '$dni'";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        $paciente = $result->fetch_assoc();
        $id_paciente = $paciente['id'];

        // Preparar la inserción en la tabla tratamientos
        $stmt = $conexion->prepare("INSERT INTO tratamientos (id_paciente, id_profesional, fecha, descripcion, observaciones, historial_fecha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $id_paciente, $id_profesional, $fecha, $descripcion, $observaciones, $fecha); // usas la misma fecha para historial_fecha

        // Ejecutar la inserción
        if ($stmt->execute()) {
            // Redirigir a la página de historia clínica con el DNI y un mensaje de éxito
            header("Location: ../empleados/historia_clinica.php?dni=$dni&exito=1");
            exit();
        } else {
            // Si ocurre un error al insertar
            echo "<script>alert('Error al guardar el tratamiento.'); window.location.href='../empleados/agregar_tratamiento.php';</script>";
        }
    } else {
        // Si no existe el paciente con ese DNI
        echo "<script>alert('El paciente con DNI $dni no existe.'); window.location.href='../empleados/agregar_tratamiento.php';</script>";
    }
}
?>

