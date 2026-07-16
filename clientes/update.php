<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Cliente.php';

$clienteModel = new Cliente();
$idcliente = $_GET['id'] ?? '';
$cliente = $clienteModel->obtenerPorId($idcliente);

if (!$cliente) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nomcliente'   => trim($_POST['nomcliente']),
        'ruccliente'   => trim($_POST['ruccliente']),
        'dircliente'   => trim($_POST['dircliente']),
        'telcliente'   => trim($_POST['telcliente']),
        'emailcliente' => trim($_POST['emailcliente']),
    ];

    if ($datos['nomcliente'] === '') {
        $error = 'El nombre del cliente es obligatorio.';
    } else {
        $clienteModel->actualizar($idcliente, $datos);
        header('Location: index.php?msg=ok');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Editar Cliente</h3>
    <a href="index.php" class="btn btn-secondary">&laquo; Regresar</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="update.php?id=<?php echo urlencode($idcliente); ?>">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Nombres:</label>
            <input type="text" name="nomcliente" class="form-control" required
                   value="<?php echo htmlspecialchars($cliente->nomcliente); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">RUC / DNI:</label>
            <input type="text" name="ruccliente" class="form-control" maxlength="11"
                   value="<?php echo htmlspecialchars($cliente->ruccliente); ?>">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección:</label>
        <textarea name="dircliente" class="form-control" rows="3"><?php echo htmlspecialchars($cliente->dircliente); ?></textarea>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Teléfono:</label>
            <input type="text" name="telcliente" class="form-control" maxlength="9"
                   value="<?php echo htmlspecialchars($cliente->telcliente); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" name="emailcliente" class="form-control"
                   value="<?php echo htmlspecialchars($cliente->emailcliente); ?>">
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-success">Actualizar datos</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
