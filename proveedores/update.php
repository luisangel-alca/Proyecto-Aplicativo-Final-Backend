<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Proveedor.php';

$proveedorModel = new Proveedor();
$idproveedor = $_GET['id'] ?? '';
$proveedor = $proveedorModel->obtenerPorId($idproveedor);

if (!$proveedor) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nomproveedor'   => trim($_POST['nomproveedor']),
        'rucproveedor'   => trim($_POST['rucproveedor']),
        'dirproveedor'   => trim($_POST['dirproveedor']),
        'telproveedor'   => trim($_POST['telproveedor']),
        'emailproveedor' => trim($_POST['emailproveedor']),
    ];

    if ($datos['nomproveedor'] === '') {
        $error = 'El nombre del proveedor es obligatorio.';
    } else {
        $proveedorModel->actualizar($idproveedor, $datos);
        header('Location: index.php?msg=ok');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Editar Proveedor</h3>
    <a href="index.php" class="btn btn-secondary">&laquo; Regresar</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="update.php?id=<?php echo urlencode($idproveedor); ?>">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Razón social:</label>
            <input type="text" name="nomproveedor" class="form-control" required
                   value="<?php echo htmlspecialchars($proveedor->nomproveedor); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">RUC:</label>
            <input type="text" name="rucproveedor" class="form-control" maxlength="11"
                   value="<?php echo htmlspecialchars($proveedor->rucproveedor); ?>">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección:</label>
        <textarea name="dirproveedor" class="form-control" rows="3"><?php echo htmlspecialchars($proveedor->dirproveedor); ?></textarea>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Teléfono:</label>
            <input type="text" name="telproveedor" class="form-control" maxlength="9"
                   value="<?php echo htmlspecialchars($proveedor->telproveedor); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" name="emailproveedor" class="form-control"
                   value="<?php echo htmlspecialchars($proveedor->emailproveedor); ?>">
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-success">Actualizar datos</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
