<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../clases/Proveedor.php';
require_once __DIR__ . '/../clases/Categoria.php';

$productoModel  = new Producto();
$proveedorModel = new Proveedor();
$categoriaModel = new Categoria();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'idproveedor' => $_POST['idproveedor'],
        'nomproducto' => trim($_POST['nomproducto']),
        'unimed'      => trim($_POST['unimed']),
        'stock'       => (int) $_POST['stock'],
        'cosuni'      => (float) $_POST['cosuni'],
        'preuni'      => (float) $_POST['preuni'],
        'idcategoria' => $_POST['idcategoria'],
    ];

    if ($datos['nomproducto'] === '') {
        $error = 'El nombre del producto es obligatorio.';
    } else {
        $productoModel->agregar($datos);
        header('Location: index.php?msg=ok');
        exit;
    }
}

$proveedores = $proveedorModel->listarProveedores();
$categorias  = $categoriaModel->listarCategorias();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Agregar Producto</h3>
    <a href="index.php" class="btn btn-secondary">&laquo; Regresar</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="create.php">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Nombre del producto:</label>
            <input type="text" name="nomproducto" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Unidad de medida:</label>
            <input type="text" name="unimed" class="form-control" placeholder="UNIDAD, BOLSA, LATA...">
        </div>
        <div class="col-md-3">
            <label class="form-label">Stock inicial:</label>
            <input type="number" name="stock" class="form-control" value="0" min="0" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Categoría:</label>
            <select name="idcategoria" class="form-select" required>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat->idcategoria; ?>"><?php echo htmlspecialchars($cat->nomcategoria); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Proveedor:</label>
            <select name="idproveedor" class="form-select" required>
                <?php foreach ($proveedores as $prov): ?>
                    <option value="<?php echo $prov->idproveedor; ?>"><?php echo htmlspecialchars($prov->nomproveedor); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Costo unitario:</label>
            <input type="number" step="0.01" name="cosuni" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Precio unitario:</label>
            <input type="number" step="0.01" name="preuni" class="form-control" required>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-success">Guardar producto</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
