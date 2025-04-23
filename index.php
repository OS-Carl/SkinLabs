<?php
session_start();

// Evita que el navegador guarde la página en caché
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SkinLabs - Estética Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e3f2fd);
        }
        .portada {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-lg {
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="portada">
        <div class="text-center">
            <h1 class="mb-4">💆‍♀️ Bienvenido a SkinLabs</h1>
            <p class="lead mb-5">Tu centro de estética de confianza</p>

            <div class="d-flex justify-content-center gap-4">
                <a href="clientes/servicios.php" class="btn btn-success btn-lg">👩 Cliente</a>
                <a href="empleados/index_empleados.php" class="btn btn-primary btn-lg">🔐 Empleado</a>
            </div>
        </div>
    </div>
</body>
</html>

