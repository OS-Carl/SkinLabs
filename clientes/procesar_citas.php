<?php
include("../php/conexion.php");

$servicio = isset($_GET['servicio']) ? $_GET['servicio'] : '';

// Sanitización de los datos recibidos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);  // DNI agregado
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);  // Fecha recibida del formulario
    $hora = mysqli_real_escape_string($conexion, $_POST['hora']);

    // 1. Verificar que la fecha no sea en el pasado
    $fecha_actual = date('Y-m-d');  // Fecha actual en formato Y-m-d
    if ($fecha < $fecha_actual) {
        echo "<div class='alert alert-danger'>No se puede agendar una cita en el pasado.</div>";
    } else {
        // 2. Verificar que la persona no haya reservado ya para este día
        $query_existencia = "SELECT * FROM citas WHERE dni = '$dni' AND fecha = '$fecha'";  // Usando DNI para verificar
        $result = mysqli_query($conexion, $query_existencia);
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger'>Ya has agendado una cita para este día.</div>";
        } else {
            // 3. Verificar que no haya citas a la misma hora en la misma fecha
            $query_hora = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$hora'";
            $result_hora = mysqli_query($conexion, $query_hora);
            if (mysqli_num_rows($result_hora) > 0) {
                echo "<div class='alert alert-danger'>Ya hay una cita agendada para este horario.</div>";
            } else {
                // 4. Insertar la cita en la base de datos
                $query = "INSERT INTO citas (nombre, telefono, dni, servicio, fecha, hora) 
                          VALUES ('$nombre', '$telefono', '$dni', '$servicio', '$fecha', '$hora')";
                if (mysqli_query($conexion, $query)) {
                    echo "<div class='alert alert-success'>¡Cita agendada con éxito!</div>";
                    // Redirigir a la página de servicios después de agendar la cita
                    header("Location: servicios.php?exito=1");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Error al agendar la cita. Intenta nuevamente.</div>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">Agendar Cita para: <?php echo htmlspecialchars($servicio); ?></h2>

        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>
            <button type="submit" class="btn btn-success">Agendar cita</button>
        </form>
    </div>
</body>
</html>


