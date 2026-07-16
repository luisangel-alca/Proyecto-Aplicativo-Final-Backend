<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Usuario.php';

$usuarioModel = new Usuario();
$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actual = $_POST['password_actual'];
    $nueva  = $_POST['password_nueva'];
    $confirmar = $_POST['password_confirmar'];

    if ($nueva !== $confirmar) {
        $error = 'La nueva contraseña y su confirmación no coinciden.';
    } elseif (strlen($nueva) < 6) {
        $error = 'La nueva contraseña debe tener al menos 6 caracteres.';
    } else {
        $ok = $usuarioModel->cambiarPassword($_SESSION['idusuario'], $actual, $nueva);
        if ($ok) {
            $exito = 'Contraseña actualizada correctamente.';
        } else {
            $error = 'La contraseña actual no es correcta.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Cambiar Contraseña</h3>

<?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<?php if ($exito): ?><div class="alert alert-success"><?php echo htmlspecialchars($exito); ?></div><?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="cambiar_password.php" style="max-width:400px;">
    <div class="mb-3">
        <label class="form-label">Contraseña actual:</label>
        <input type="password" name="password_actual" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nueva contraseña:</label>
        <input type="password" name="password_nueva" class="form-control" required minlength="6">
    </div>
    <div class="mb-3">
        <label class="form-label">Confirmar nueva contraseña:</label>
        <input type="password" name="password_confirmar" class="form-control" required minlength="6">
    </div>
    <button type="submit" class="btn btn-success">Actualizar contraseña</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
