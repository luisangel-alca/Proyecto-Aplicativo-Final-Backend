<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../clases/Factura.php';

$productoModel = new Producto();
$facturaModel  = new Factura();

$idproducto = $_GET['idproducto'] ?? '';
$ventas = [];
if ($idproducto !== '') {
    $ventas = $facturaModel->ventasPorProducto($idproducto);
}

$productos = $productoModel->listarProductos();

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Consulta: Ventas por Producto</h3>

<form method="GET" action="venta_producto.php" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="idproducto" class="form-select" required>
            <option value="">-- Seleccione un producto --</option>
            <?php foreach ($productos as $p): ?>
                <option value="<?php echo $p->idproducto; ?>" <?php echo $p->idproducto === $idproducto ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($p->nomproducto); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
</form>

<?php if ($idproducto !== ''): ?>
<div class="card">
<div class="card-body">
<table class="table table-bordered">
    <thead><tr><th>N° Factura</th><th>Fecha</th><th>Cliente</th><th>Cantidad</th><th>Precio Unit.</th><th>Importe</th></tr></thead>
    <tbody>
        <?php foreach ($ventas as $row): ?>
        <tr>
            <td><?php echo $row->idfactura; ?></td>
            <td><?php echo $row->fecha; ?></td>
            <td><?php echo htmlspecialchars($row->nomcliente); ?></td>
            <td><?php echo $row->cant; ?></td>
            <td><?php echo number_format($row->preuni, 2); ?></td>
            <td><?php echo number_format($row->importe, 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ventas)): ?>
        <tr><td colspan="6" class="text-center">Este producto no tiene ventas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
