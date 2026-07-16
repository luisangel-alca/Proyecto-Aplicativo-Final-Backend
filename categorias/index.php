<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Categoria.php';

$categoriaModel = new Categoria();
$error = '';
$editar = null;

// Procesar formulario (agregar o actualizar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomcategoria = trim($_POST['nomcategoria']);
    $idcategoria  = $_POST['idcategoria'] ?? '';

    if ($nomcategoria === '') {
        $error = 'El nombre de la categoría es obligatorio.';
    } elseif ($idcategoria !== '') {
        $categoriaModel->actualizar($idcategoria, $nomcategoria);
        header('Location: index.php?msg=ok');
        exit;
    } else {
        $categoriaModel->agregar($nomcategoria);
        header('Location: index.php?msg=ok');
        exit;
    }
}

// Editar: cargar datos en el formulario
if (isset($_GET['edit'])) {
    $editar = $categoriaModel->obtenerPorId($_GET['edit']);
}

$categorias = $categoriaModel->listarCategorias();

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Mantenimiento de Categorías</h3>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'ok'): ?>
    <div class="alert alert-success">Operación realizada correctamente.</div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5><?php echo $editar ? 'Editar categoría' : 'Nueva categoría'; ?></h5>
                <form method="POST" action="index.php">
                    <?php if ($editar): ?>
                        <input type="hidden" name="idcategoria" value="<?php echo htmlspecialchars($editar->idcategoria); ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre:</label>
                        <input type="text" name="nomcategoria" class="form-control" required
                               value="<?php echo $editar ? htmlspecialchars($editar->nomcategoria) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <?php if ($editar): ?>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
        <div class="card-body">
        <table class="table table-bordered">
            <thead><tr><th>Código</th><th>Nombre</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach ($categorias as $cat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cat->idcategoria); ?></td>
                    <td><?php echo htmlspecialchars($cat->nomcategoria); ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo urlencode($cat->idcategoria); ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="delete.php?id=<?php echo urlencode($cat->idcategoria); ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
