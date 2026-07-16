<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Cliente.php';
require_once __DIR__ . '/../includes/header.php';

$clienteModel = new Cliente();
$clientes = $clienteModel->listarClientes();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de Clientes</h3>
    <a href="create.php" class="btn btn-info">+ Agregar cliente</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'ok'): ?>
    <div class="alert alert-success">Operación realizada correctamente.</div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>RUC</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>E-mail</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row->idcliente); ?></td>
            <td><?php echo htmlspecialchars($row->nomcliente); ?></td>
            <td><?php echo htmlspecialchars($row->ruccliente); ?></td>
            <td><?php echo htmlspecialchars($row->dircliente); ?></td>
            <td><?php echo htmlspecialchars($row->telcliente); ?></td>
            <td><?php echo htmlspecialchars($row->emailcliente); ?></td>
            <td>
                <a href="update.php?id=<?php echo urlencode($row->idcliente); ?>"
                   class="btn btn-sm btn-warning" title="Editar">
                   <span class="material-icons" style="font-size:16px;">edit</span>
                </a>
                <a href="delete.php?id=<?php echo urlencode($row->idcliente); ?>"
                   class="btn btn-sm btn-danger" title="Eliminar"
                   onclick="return confirm('¿Seguro que desea eliminar este cliente?');">
                   <span class="material-icons" style="font-size:16px;">delete</span>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($clientes)): ?>
        <tr><td colspan="7" class="text-center">No hay clientes registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
