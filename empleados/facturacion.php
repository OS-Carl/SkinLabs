<?php
session_start();

if (!isset($_SESSION['empleado'])) {
    header("Location: login.php");
    exit;
}

include("../php/conexion.php");

$factura_guardada = false;
$nombre = $dni = $cuil = $direccion = $email = $fecha = $monto = $metodo_pago = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $cuil = $_POST['cuil'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $fecha = $_POST['fecha'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $stmt = $conexion->prepare("INSERT INTO facturas (nombre, dni, cuil, direccion, mail, fecha, monto, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ssssssds", $nombre, $dni, $cuil, $direccion, $email, $fecha, $monto, $metodo_pago);

    if ($stmt->execute()) {
        $factura_guardada = true;
    } else {
        echo "<div class='alert alert-danger'>❌ Error al guardar la factura. " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
    .ticket {
        width: 300px;
        padding: 20px;
        margin: auto;
        background: #fff;
        border: 1px dashed #000;
        font-family: 'Courier New', monospace;
        font-size: 14px;
    }
    .ticket hr {
        margin: 5px 0;
        border-top: 1px dashed #000;
    }
    .ticket .text-center {
        text-align: center;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .ticket, .ticket * {
            visibility: visible;
        }
        .ticket {
            position: absolute;
            left: 0;
            top: 0;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">💸 Generar Factura SkinLabs</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3"><label class="form-label">Nombre completo</label><input type="text" name="nombre" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">DNI</label><input type="text" name="dni" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">CUIL</label><input type="text" name="cuil" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Dirección</label><input type="text" name="direccion" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Fecha</label><input type="date" name="fecha" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Monto</label><input type="number" step="0.01" name="monto" class="form-control" required></div>
                <div class="mb-3">
                    <label class="form-label">Método de pago</label>
                    <select name="metodo_pago" class="form-select" required>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                        <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                        <option value="Billetera Virtual">Billetera Virtual</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Generar Factura</button>
            </form>

            <!-- Ticket generado -->
            <?php if ($factura_guardada): ?>
            <div id="factura" class="ticket mt-4">
                <div class="text-center">
                    <h5>SKINLABS ESTÉTICA</h5>
                    <small>Factura Nº: <?= rand(100000,999999) ?> - <?= date("Y") ?></small>
                    <hr>
                </div>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></p>
                <p><strong>DNI:</strong> <?= htmlspecialchars($dni) ?></p>
                <p><strong>CUIL:</strong> <?= htmlspecialchars($cuil) ?></p>
                <p><strong>Dirección:</strong> <?= htmlspecialchars($direccion) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                <hr>
                <p><strong>Fecha:</strong> <?= htmlspecialchars($fecha) ?></p>
                <p><strong>Método de Pago:</strong> <?= htmlspecialchars($metodo_pago) ?></p>
                <p><strong>Total:</strong> $<?= number_format($monto, 2, ',', '.') ?></p>
                <hr>
                <div class="text-center">
                    <em>¡Gracias por tu visita!</em>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-sm btn-secondary no-print" onclick="window.print()">🖨 Imprimir</button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


</body>
</html>
