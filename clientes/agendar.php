<?php
include("../php/conexion.php");

$servicio = isset($_GET['servicio']) ? $_GET['servicio'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $dni = $_POST['dni'];  // Añadido el campo DNI
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Verificar si ya hay una cita agendada para ese día y hora
    $query_check = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$hora'";
    $result_check = mysqli_query($conexion, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<div class='alert alert-danger'>¡El horario seleccionado ya está ocupado! Por favor, elige otro horario.</div>";
    } else {
        // Verificar si la persona ya tiene una cita agendada en ese día (no importa la hora)
        $query_check_persona = "SELECT * FROM citas WHERE fecha = '$fecha' AND dni = '$dni'";  // Usamos DNI
        $result_check_persona = mysqli_query($conexion, $query_check_persona);

        if (mysqli_num_rows($result_check_persona) > 0) {
            echo "<div class='alert alert-danger'>¡Ya tienes un turno agendado para este día! Solo puedes agendar un turno por día.</div>";
        } else {
            // Verificar si la fecha es domingo
            $dia_semana = date('w', strtotime($fecha)); // 0 = domingo, 6 = sábado
            if ($dia_semana == 0) {
                echo "<div class='alert alert-danger'>No puedes agendar turnos los domingos. Por favor selecciona otro día.</div>";
            } else {
                // Verificar si la hora está en el rango permitido (de 9 a 18)
                $hora_agendada = strtotime($hora);
                $hora_inicio = strtotime('09:00');
                $hora_fin = strtotime('18:00');

                if ($hora_agendada < $hora_inicio || $hora_agendada > $hora_fin) {
                    echo "<div class='alert alert-danger'>El turno debe ser entre las 09:00 y las 18:00 horas.</div>";
                } else {
                    // Insertar la cita en la base de datos
                    $query = "INSERT INTO citas (nombre, telefono, servicio, fecha, hora, dni) VALUES ('$nombre', '$telefono', '$servicio', '$fecha', '$hora', '$dni')";
                    if (mysqli_query($conexion, $query)) {
                        echo "<div class='alert alert-success'>¡Cita agendada con éxito!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error al agendar la cita. Intenta nuevamente.</div>";
                    }
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
                <label for="dni" class="form-label">DNI</label> <!-- Campo DNI -->
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
