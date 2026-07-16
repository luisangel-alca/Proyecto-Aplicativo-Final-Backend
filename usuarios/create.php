<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Usuario.php';

$usuarioModel = new Usuario();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nomusuario' => trim($_POST['nomusuario']),
        'password'   => $_POST['password'],
        'apellidos'  => trim($_POST['apellidos']),
        'nombres'    => trim($_POST['nombres']),
        'email'      => trim($_POST['email']),
    ];

    if ($datos['nomusuario'] === '' || $datos['password'] === '') {
        $error = 'Usuario y contraseña son obligatorios.';
    } else {
        $usuarioModel->agregar($datos);
        header('Location: index.php?msg=ok');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Agregar Usuario</h3>
    <a href="index.php" class="btn btn-secondary">&laquo; Regresar</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="create.php">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Apellidos:</label>
            <input type="text" name="apellidos" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nombres:</label>
            <input type="text" name="nombres" class="form-control" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Usuario (login):</label>
            <input type="text" name="nomusuario" class="form-control" maxlength="15" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" name="email" class="form-control">
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-success">Guardar usuario</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
