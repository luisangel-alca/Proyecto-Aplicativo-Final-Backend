<?php
session_start();
require_once __DIR__ . '/clases/Usuario.php';
require_once __DIR__ . '/includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomusuario = trim($_POST['nomusuario'] ?? '');
    $password   = $_POST['password'] ?? '';

    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->login($nomusuario, $password);

    if ($usuario) {
        $_SESSION['idusuario'] = $usuario->idusuario;
        $_SESSION['nomusuario'] = $usuario->nomusuario;
        $_SESSION['nombres']   = $usuario->nombres . ' ' . $usuario->apellidos;
        header('Location: ' . BASE_URL . 'index.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Sistema de Facturación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark d-flex align-items-center" style="height:100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Iniciar Sesión</h3>
                    <p class="text-center text-muted small">Sistema de Facturación y Control de Stocks</p>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" name="nomusuario" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
