<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Factura.php';

$facturaModel = new Factura();
$fecha = $_GET['fecha'] ?? date('Y-m-d');
$ventas = $facturaModel->ventasPorDia($fecha);

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Consulta: Ventas por Día</h3>

<form method="GET" action="ventas_dia.php" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="date" name="fecha" class="form-control" value="<?php echo htmlspecialchars($fecha); ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
</form>

<div class="card">
<div class="card-body">
<table class="table table-bordered">
    <thead><tr><th>N° Factura</th><th>Fecha</th><th>Cliente</th><th>Condición</th><th>Importe</th></tr></thead>
    <tbody>
        <?php foreach ($ventas as $row): ?>
        <tr>
            <td><?php echo $row->idfactura; ?></td>
            <td><?php echo $row->fecha; ?></td>
            <td><?php echo htmlspecialchars($row->nomcliente); ?></td>
            <td><?php echo htmlspecialchars($row->nomcondicion); ?></td>
            <td><?php echo number_format($row->valorventa, 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ventas)): ?>
        <tr><td colspan="5" class="text-center">No hay ventas registradas para esta fecha.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
