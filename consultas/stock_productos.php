<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../includes/header.php';

$productoModel = new Producto();
$stock = $productoModel->listarStock();
?>

<h3 class="mb-3">Consulta: Stock de Productos</h3>

<div class="card">
<div class="card-body">
<table class="table table-bordered">
    <thead><tr><th>Código</th><th>Producto</th><th>U. Medida</th><th>Stock</th><th>Precio Unit.</th></tr></thead>
    <tbody>
        <?php foreach ($stock as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row->idproducto); ?></td>
            <td><?php echo htmlspecialchars($row->nomproducto); ?></td>
            <td><?php echo htmlspecialchars($row->unimed); ?></td>
            <td class="<?php echo $row->stock <= 5 ? 'text-danger fw-bold' : ''; ?>"><?php echo $row->stock; ?></td>
            <td><?php echo number_format($row->preuni, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
