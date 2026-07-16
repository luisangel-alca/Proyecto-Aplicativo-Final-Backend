<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../clases/Proveedor.php';
require_once __DIR__ . '/../clases/Categoria.php';

$productoModel  = new Producto();
$proveedorModel = new Proveedor();
$categoriaModel = new Categoria();

$idproducto = $_GET['id'] ?? '';
$producto = $productoModel->obtenerPorId($idproducto);

if (!$producto) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'idproveedor' => $_POST['idproveedor'],
        'nomproducto' => trim($_POST['nomproducto']),
        'unimed'      => trim($_POST['unimed']),
        'cosuni'      => (float) $_POST['cosuni'],
        'preuni'      => (float) $_POST['preuni'],
        'idcategoria' => $_POST['idcategoria'],
    ];

    if ($datos['nomproducto'] === '') {
        $error = 'El nombre del producto es obligatorio.';
    } else {
        $productoModel->actualizar($idproducto, $datos);
        header('Location: index.php?msg=ok');
        exit;
    }
}

$proveedores = $proveedorModel->listarProveedores();
$categorias  = $categoriaModel->listarCategorias();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Editar Producto</h3>
    <a href="index.php" class="btn btn-secondary">&laquo; Regresar</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="update.php?id=<?php echo urlencode($idproducto); ?>">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Nombre del producto:</label>
            <input type="text" name="nomproducto" class="form-control" required
                   value="<?php echo htmlspecialchars($producto->nomproducto); ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Unidad de medida:</label>
            <input type="text" name="unimed" class="form-control"
                   value="<?php echo htmlspecialchars($producto->unimed); ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Stock actual:</label>
            <input type="number" class="form-control" value="<?php echo $producto->stock; ?>" disabled>
            <small class="text-muted">El stock se actualiza automáticamente con las ventas.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Categoría:</label>
            <select name="idcategoria" class="form-select" required>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat->idcategoria; ?>" <?php echo $cat->idcategoria === $producto->idcategoria ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat->nomcategoria); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Proveedor:</label>
            <select name="idproveedor" class="form-select" required>
                <?php foreach ($proveedores as $prov): ?>
                    <option value="<?php echo $prov->idproveedor; ?>" <?php echo $prov->idproveedor === $producto->idproveedor ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($prov->nomproveedor); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Costo unitario:</label>
            <input type="number" step="0.01" name="cosuni" class="form-control" required
                   value="<?php echo $producto->cosuni; ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Precio unitario:</label>
            <input type="number" step="0.01" name="preuni" class="form-control" required
                   value="<?php echo $producto->preuni; ?>">
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-success">Actualizar producto</button>
</form>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
