<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Factura.php';

$facturaModel = new Factura();
$fechaInicio = $_GET['inicio'] ?? date('Y-m-01');
$fechaFin    = $_GET['fin'] ?? date('Y-m-d');
$ventas = $facturaModel->ventasEntreFechas($fechaInicio, $fechaFin);

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Consulta: Ventas Entre Fechas</h3>

<form method="GET" action="ventas_fecha.php" class="row g-2 mb-3">
    <div class="col-auto">
        <label class="col-form-label">Desde:</label>
    </div>
    <div class="col-auto">
        <input type="date" name="inicio" class="form-control" value="<?php echo htmlspecialchars($fechaInicio); ?>">
    </div>
    <div class="col-auto">
        <label class="col-form-label">Hasta:</label>
    </div>
    <div class="col-auto">
        <input type="date" name="fin" class="form-control" value="<?php echo htmlspecialchars($fechaFin); ?>">
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
        <?php $total = 0; foreach ($ventas as $row): $total += $row->valorventa; ?>
        <tr>
            <td><?php echo $row->idfactura; ?></td>
            <td><?php echo $row->fecha; ?></td>
            <td><?php echo htmlspecialchars($row->nomcliente); ?></td>
            <td><?php echo htmlspecialchars($row->nomcondicion); ?></td>
            <td><?php echo number_format($row->valorventa, 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ventas)): ?>
        <tr><td colspan="5" class="text-center">No hay ventas registradas en este rango.</td></tr>
        <?php else: ?>
        <tr class="table-secondary fw-bold"><td colspan="4" class="text-end">Total:</td><td><?php echo number_format($total, 2); ?></td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
