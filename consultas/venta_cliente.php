<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Cliente.php';
require_once __DIR__ . '/../clases/Factura.php';

$clienteModel = new Cliente();
$facturaModel = new Factura();

$idcliente = $_GET['idcliente'] ?? '';
$ventas = [];
if ($idcliente !== '') {
    $ventas = $facturaModel->ventasPorCliente($idcliente);
}

$clientes = $clienteModel->listarClientes();

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Consulta: Ventas por Cliente</h3>

<form method="GET" action="venta_cliente.php" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="idcliente" class="form-select" required>
            <option value="">-- Seleccione un cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?php echo $c->idcliente; ?>" <?php echo $c->idcliente === $idcliente ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c->nomcliente); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
</form>

<?php if ($idcliente !== ''): ?>
<div class="card">
<div class="card-body">
<table class="table table-bordered">
    <thead><tr><th>N° Factura</th><th>Fecha</th><th>Condición</th><th>Importe</th></tr></thead>
    <tbody>
        <?php foreach ($ventas as $row): ?>
        <tr>
            <td><?php echo $row->idfactura; ?></td>
            <td><?php echo $row->fecha; ?></td>
            <td><?php echo htmlspecialchars($row->nomcondicion); ?></td>
            <td><?php echo number_format($row->valorventa, 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ventas)): ?>
        <tr><td colspan="4" class="text-center">Este cliente no tiene ventas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
