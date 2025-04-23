<?php
session_start();

if (!isset($_SESSION['empleado'])) {
    header("Location: login.php");
    exit;
}

include("../php/conexion.php");

// Variables para mostrar la factura después de guardarla
$factura_guardada = false;
$nombre = $dni = $fecha = $monto = $metodo_pago = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $fecha = $_POST['fecha'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];

    // Verificar la conexión
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Guardamos en la base de datos
    $stmt = $conexion->prepare("INSERT INTO facturas (nombre, dni, fecha, monto, metodo_pago) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("sssss", $nombre, $dni, $fecha, $monto, $metodo_pago);

    if ($stmt->execute()) {
        $factura_guardada = true; // Mostramos la factura abajo
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
    <title>Facturación - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">💸 Cargar Factura</h3>
        </div>
        <div class="card-body">

            <!-- Formulario para cargar factura -->
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Monto</label>
                    <input type="number" step="0.01" name="monto" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Método de pago</label>
                    <select name="metodo_pago" class="form-select" required>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                        <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                        <option value="Billetera Virtual">Billetera Virtual (Mercado Pago, etc.)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Guardar Factura</button>
            </form>

            <!-- Mostrar la factura generada -->
            <?php if ($factura_guardada): ?>
            <div id="factura" class="card p-4 mt-4">
                <h4 class="mb-3">🧾 Factura Generada</h4>
                <p><strong>Cliente:</strong> <?= htmlspecialchars($nombre) ?></p>
                <p><strong>DNI:</strong> <?= htmlspecialchars($dni) ?></p>
                <p><strong>Fecha:</strong> <?= htmlspecialchars($fecha) ?></p>
                <p><strong>Monto:</strong> $<?= htmlspecialchars($monto) ?></p>
                <p><strong>Método de Pago:</strong> <?= htmlspecialchars($metodo_pago) ?></p>

                <div class="mt-3">
                    <button class="btn btn-secondary" onclick="window.print()">🖨️ Imprimir</button>
                    <button class="btn btn-success" onclick="guardarPDF()">💾 Guardar como PDF</button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Script para guardar como PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function guardarPDF() {
    const factura = document.getElementById("factura");
    // Verificamos que se haya generado una factura para poder guardarla como PDF
    if (factura) {
        html2pdf().from(factura).set({
            margin: 10,
            filename: 'Factura_SkinLabs.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        }).save();
    } else {
        alert('No se puede generar el PDF. Asegúrate de que la factura esté visible.');
    }
}
</script>
</body>
</html>
