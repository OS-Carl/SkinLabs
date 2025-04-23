<?php
session_start();

// ❌ Evitar caché del navegador
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 🔐 Verificación de sesión
if (!isset($_SESSION['empleado'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Personal - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Panel del Personal - SkinLabs</h2>
            <span>👤 <?php echo $_SESSION['empleado']; ?></span>
        </div>
        <div class="card-body">

            <!-- ✅ Mostrar mensaje de éxito -->
            <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_GET['msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

            <p class="lead">Selecciona una opción:</p>
            <div class="list-group">
                <a href="nuevo.php" class="list-group-item list-group-item-action">➕ Agregar nuevo paciente</a>
                <a href="buscar.php" class="list-group-item list-group-item-action">🔎 Buscar o modificar paciente</a>
                <a href="ver_historial.php" class="list-group-item list-group-item-action">📄 Ver historial completo</a>
                <a href="agregar_tratamiento.php" class="list-group-item list-group-item-action">💆‍♂️ Agregar tratamiento o anotaciones</a>
                <a href="historia_clinica.php" class="list-group-item list-group-item-action">📚 Ver historial de un paciente</a>
                <a href="ver_agenda.php" class="list-group-item list-group-item-action">📅 Ver agenda</a>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="../logout.php" class="btn btn-danger">🔒 Cerrar sesión</a>
        </div>
    </div>
</div>

<script>
    // Si el usuario intenta volver con la flecha del navegador
    // y la sesión ya no existe, lo redirigimos al login.
    window.addEventListener("pageshow", function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            location.reload();
        }
    });
</script>

</body>
</html>
