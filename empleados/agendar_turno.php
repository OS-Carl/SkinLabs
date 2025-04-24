<?php
session_start();
include("../php/conexion.php");

// Protección por sesión
if (!isset($_SESSION['empleado'])) {
    header("Location: ../login.php");
    exit;
}

$servicio = isset($_GET['servicio']) ? $_GET['servicio'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $dni = $_POST['dni'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $query_check = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$hora'";
    $result_check = mysqli_query($conexion, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        $mensaje = "<div class='alert alert-danger'>¡El horario ya está ocupado! Elegí otro.</div>";
    } else {
        $query_check_persona = "SELECT * FROM citas WHERE fecha = '$fecha' AND dni = '$dni'";
        $result_check_persona = mysqli_query($conexion, $query_check_persona);

        if (mysqli_num_rows($result_check_persona) > 0) {
            $mensaje = "<div class='alert alert-danger'>Esa persona ya tiene un turno ese día.</div>";
        } else {
            $dia_semana = date('w', strtotime($fecha));
            if ($dia_semana == 0) {
                $mensaje = "<div class='alert alert-danger'>No se agendan turnos los domingos.</div>";
            } else {
                $hora_agendada = strtotime($hora);
                $hora_inicio = strtotime('09:00');
                $hora_fin = strtotime('18:00');

                if ($hora_agendada < $hora_inicio || $hora_agendada > $hora_fin) {
                    $mensaje = "<div class='alert alert-danger'>Horario fuera de rango (09:00 - 18:00).</div>";
                } else {
                    $query = "INSERT INTO citas (nombre, telefono, servicio, fecha, hora, dni) 
                              VALUES ('$nombre', '$telefono', '$servicio', '$fecha', '$hora', '$dni')";
                    if (mysqli_query($conexion, $query)) {
                        $mensaje = "<div class='alert alert-success'>Turno agendado correctamente.</div>";
                    } else {
                        $mensaje = "<div class='alert alert-danger'>Error al guardar el turno.</div>";
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
    <title>Agendar Turno - Panel Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3>📆 Agendar Turno (Empleados)</h3>
        </div>
        <div class="card-body">
            <?php if (isset($mensaje)) echo $mensaje; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre del paciente</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha del turno</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hora del turno</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Agendar turno</button>
                <a href="index_empleados.php" class="btn btn-secondary">Volver al panel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
