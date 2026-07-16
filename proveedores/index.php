<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Proveedor.php';
require_once __DIR__ . '/../includes/header.php';

$proveedorModel = new Proveedor();
$proveedores = $proveedorModel->listarProveedores();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de Proveedores</h3>
    <a href="create.php" class="btn btn-info">+ Agregar proveedor</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'ok'): ?>
    <div class="alert alert-success">Operación realizada correctamente.</div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Código</th><th>Nombre</th><th>RUC</th><th>Dirección</th><th>Teléfono</th><th>E-mail</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($proveedores as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row->idproveedor); ?></td>
            <td><?php echo htmlspecialchars($row->nomproveedor); ?></td>
            <td><?php echo htmlspecialchars($row->rucproveedor); ?></td>
            <td><?php echo htmlspecialchars($row->dirproveedor); ?></td>
            <td><?php echo htmlspecialchars($row->telproveedor); ?></td>
            <td><?php echo htmlspecialchars($row->emailproveedor); ?></td>
            <td>
                <a href="update.php?id=<?php echo urlencode($row->idproveedor); ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="delete.php?id=<?php echo urlencode($row->idproveedor); ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este proveedor?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($proveedores)): ?>
        <tr><td colspan="7" class="text-center">No hay proveedores registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
