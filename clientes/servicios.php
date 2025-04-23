<?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
    <div class="alert alert-success text-center mt-3">
        ¡Cita agendada con éxito!
    </div>
<?php endif; ?>

<?php include("../php/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .servicio-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">Nuestros Servicios</h2>
        
        <!-- Aquí puedes agregar más servicios -->
        <div class="row">
            <div class="col-md-4">
                <div class="card servicio-card">
                    <div class="card-header bg-primary text-white">
                        <h5>Limpieza Facial</h5>
                    </div>
                    <div class="card-body">
                        <p>Un tratamiento para limpiar profundamente tu piel y darle luminosidad.</p>
                        <p><strong>Precio: $50</strong></p>
                        <a href="agendar.php?servicio=Limpieza+Facial" class="btn btn-success">Agendar Cita</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card servicio-card">
                    <div class="card-header bg-primary text-white">
                        <h5>Tratamiento Antiacné</h5>
                    </div>
                    <div class="card-body">
                        <p>El tratamiento perfecto para combatir el acné y mejorar la apariencia de tu piel.</p>
                        <p><strong>Precio: $80</strong></p>
                        <a href="agendar.php?servicio=Tratamiento+Antiacné" class="btn btn-success">Agendar Cita</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card servicio-card">
                    <div class="card-header bg-primary text-white">
                        <h5>Masaje Relajante</h5>
                    </div>
                    <div class="card-body">
                        <p>Relájate con un masaje que aliviará el estrés y mejorará tu bienestar general.</p>
                        <p><strong>Precio: $60</strong></p>
                        <a href="agendar.php?servicio=Masaje+Relajante" class="btn btn-success">Agendar Cita</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
