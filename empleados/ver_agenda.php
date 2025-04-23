<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['empleado'])) {
    // Redirigir al login si no está logueado
    header("Location: login.php");
    exit;
}

include("../php/conexion.php");

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Turnos - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">📅 Agenda de Turnos</h3>
        </div>
        <div class="card-body">
            <!-- Botón para volver al menú -->
            <div class="mb-3">
                <a href="index_empleados.php" class="btn btn-secondary">Volver al Menú</a>
            </div>
            
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>DNI</th> <!-- Nueva columna DNI -->
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta preparada para obtener las citas, ahora también el DNI
                    $query = "SELECT nombre, telefono, dni, servicio, fecha, hora FROM citas WHERE fecha >= CURDATE() ORDER BY fecha, hora";
                    $stmt = $conexion->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['telefono']}</td>
                                    <td>{$row['dni']}</td> <!-- Mostrar DNI -->
                                    <td>{$row['servicio']}</td>
                                    <td>{$row['fecha']}</td>
                                    <td>{$row['hora']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No hay citas registradas</td></tr>";
                    }

                    // Cerrar la conexión
                    $stmt->close();
                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

