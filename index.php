<?php
session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
            background: url('https://images.unsplash.com/photo-1598970434795-0c54fe7c0642?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .logo {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .hero h1 {
            font-weight: 800;
            font-size: 2.8rem;
        }

        .hero p.lead {
            font-weight: 300;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .frase {
            font-style: italic;
            font-size: 1rem;
            margin-top: 1rem;
            color: #ddd;
        }

        .btn-lg {
            width: 220px;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
        }

        .btn-lg:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="logo">🌿 SkinLabs</div>
        <div class="hero">
            <h1 class="mb-3">Bienvenido a tu espacio de bienestar</h1>
            <p class="lead">Estética profesional con alma</p>

            <div class="d-flex justify-content-center gap-4 flex-wrap">
                <a href="clientes/servicios.php" class="btn btn-success btn-lg">
                    <i class="bi bi-person-heart me-2"></i> Cliente
                </a>
                <a href="empleados/index_empleados.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-shield-lock me-2"></i> Empleado
                </a>
            </div>

            <p class="frase mt-4">✨ "La belleza comienza en el momento en que decides ser tú misma." - Coco Chanel</p>
        </div>
    </div>
</body>
</html>
