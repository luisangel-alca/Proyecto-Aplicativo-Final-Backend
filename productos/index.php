<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../includes/header.php';

$productoModel = new Producto();
$productos = $productoModel->listarProductos();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de Productos</h3>
    <a href="create.php" class="btn btn-info">+ Agregar producto</a>
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
            <th>Categoría</th>
            <th>Proveedor</th>
            <th>U. Medida</th>
            <th>Stock</th>
            <th>Costo</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row->idproducto); ?></td>
            <td><?php echo htmlspecialchars($row->nomproducto); ?></td>
            <td><?php echo htmlspecialchars($row->nomcategoria); ?></td>
            <td><?php echo htmlspecialchars($row->nomproveedor); ?></td>
            <td><?php echo htmlspecialchars($row->unimed); ?></td>
            <td class="<?php echo $row->stock <= 5 ? 'text-danger fw-bold' : ''; ?>">
                <?php echo $row->stock; ?>
            </td>
            <td><?php echo number_format($row->cosuni, 2); ?></td>
            <td><?php echo number_format($row->preuni, 2); ?></td>
            <td>
                <a href="update.php?id=<?php echo urlencode($row->idproducto); ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="delete.php?id=<?php echo urlencode($row->idproducto); ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($productos)): ?>
        <tr><td colspan="9" class="text-center">No hay productos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
