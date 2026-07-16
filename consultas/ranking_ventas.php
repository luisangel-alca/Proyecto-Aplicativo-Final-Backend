<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Factura.php';

$facturaModel = new Factura();
$ranking = $facturaModel->rankingVentas(10);

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Consulta: Ranking de Ventas</h3>
<p class="text-muted">Top 10 ventas con mayor importe registrado.</p>

<div class="card">
<div class="card-body">
<table class="table table-bordered">
    <thead><tr><th>#</th><th>N° Factura</th><th>Fecha</th><th>Cliente</th><th>Importe</th></tr></thead>
    <tbody>
        <?php $pos = 1; foreach ($ranking as $row): ?>
        <tr>
            <td><?php echo $pos++; ?></td>
            <td><?php echo $row->idfactura; ?></td>
            <td><?php echo $row->fecha; ?></td>
            <td><?php echo htmlspecialchars($row->nomcliente); ?></td>
            <td><?php echo number_format($row->valorventa, 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ranking)): ?>
        <tr><td colspan="5" class="text-center">Aún no hay ventas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
