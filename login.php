<?php
session_start();

// Si el usuario ya inició sesión, redirigirlo
if (isset($_SESSION['empleado'])) {
    session_unset();    // Limpia las variables de sesión
    session_destroy();  // Destruye la sesión
    header("Location: empleados/index_empleados.php");
    exit;
}

// Evitar caché del navegador
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include("php/conexion.php");

    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);

    // Consulta segura con sentencia preparada
    $stmt = mysqli_prepare($conexion, "SELECT * FROM empleados WHERE usuario = ? AND clave = SHA2(?, 256)");
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $clave);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) === 1) {
        $_SESSION['empleado'] = $usuario;
        
        // Redireccionar con método POST-Redirect-GET
        header("Location: empleados/index_empleados.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Empleado - SkinLabs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Cache-Control" content="no-store" />
    <style>
        body {
            background: #f0f4f8;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 15px;
        }
        .card-header {
            background-color: #0056b3;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 0.5rem;
            height: 45px;
        }
        .btn-primary {
            border-radius: 0.5rem;
            font-size: 1.1rem;
            padding: 12px;
        }
        .alert {
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #004085;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header text-center">
                <h4 class="mb-0">Ingreso del Personal</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" autocomplete="off">
                    <!-- Campo oculto para evitar autocompletado -->
                    <input type="text" style="display: none">
                    <input type="password" style="display: none">
                    
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" required autocomplete="new-password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Si se vuelve con "atrás", limpiar los campos
    window.onload = () => {
        if (performance.navigation.type === 2 || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            document.getElementById("usuario").value = "";
            document.getElementById("clave").value = "";
        }
    };
</script>

</body>
</html>


