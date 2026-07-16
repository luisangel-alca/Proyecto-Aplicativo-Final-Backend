<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Usuario.php';

$usuarioModel = new Usuario();
$idusuario = $_GET['id'] ?? '';
$usuario = $usuarioModel->obtenerPorId($idusuario);

if (!$usuario) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'apellidos' => trim($_POST['apellidos']),
        'nombres'   => trim($_POST['nombres']),
        'email'     => trim($_POST['email']),
    ];
    $usuarioModel->actualizar($idusuario, $datos);
    header('Location: index.php?msg=ok');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Editar Usuario</h3>
    <a href="index.php" class="btn btn-secondary">&laquo; Regresar</a>
</div>

<div class="card">
<div class="card-body">
<form method="POST" action="update.php?id=<?php echo urlencode($idusuario); ?>">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Apellidos:</label>
            <input type="text" name="apellidos" class="form-control" required
                   value="<?php echo htmlspecialchars($usuario->apellidos); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Nombres:</label>
            <input type="text" name="nombres" class="form-control" required
                   value="<?php echo htmlspecialchars($usuario->nombres); ?>">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Correo electrónico:</label>
        <input type="email" name="email" class="form-control"
               value="<?php echo htmlspecialchars($usuario->email); ?>">
    </div>
    <p class="text-muted small">Para cambiar la contraseña usa la opción "Cambiar Password" del menú Herramientas.</p>
    <hr>
    <button type="submit" class="btn btn-success">Actualizar datos</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
