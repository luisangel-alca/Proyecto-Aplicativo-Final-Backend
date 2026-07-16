<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Cliente.php';
require_once __DIR__ . '/../clases/Producto.php';
require_once __DIR__ . '/../clases/Factura.php';

$clienteModel  = new Cliente();
$productoModel = new Producto();
$facturaModel  = new Factura();

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idcliente   = $_POST['idcliente'];
    $idcondicion = $_POST['idcondicion'];
    $idsProducto = $_POST['idproducto'] ?? [];
    $cantidades  = $_POST['cantidad'] ?? [];

    $detalle = [];
    foreach ($idsProducto as $i => $idp) {
        if ($idp === '' || (int) $cantidades[$i] <= 0) {
            continue;
        }
        $prod = $productoModel->obtenerPorId($idp);
        if (!$prod) {
            continue;
        }
        if ($cantidades[$i] > $prod->stock) {
            $error = 'Stock insuficiente para el producto: ' . $prod->nomproducto;
            break;
        }
        $detalle[] = [
            'idproducto' => $idp,
            'cant'       => (int) $cantidades[$i],
            'preuni'     => (float) $prod->preuni,
            'cosuni'     => (float) $prod->cosuni,
        ];
    }

    if (!$error && empty($detalle)) {
        $error = 'Debe agregar al menos un producto a la venta.';
    }

    if (!$error) {
        try {
            $idfactura = $facturaModel->registrarVenta($idcliente, $_SESSION['idusuario'], $idcondicion, $detalle);
            $exito = "Venta registrada correctamente. N° de factura: $idfactura";
        } catch (Exception $e) {
            $error = 'Ocurrió un error al registrar la venta.';
        }
    }
}

$clientes  = $clienteModel->listarClientes();
$productos = $productoModel->listarProductos();

require_once __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-3">Registrar Venta</h3>

<?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<?php if ($exito): ?><div class="alert alert-success"><?php echo htmlspecialchars($exito); ?></div><?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST" action="registrar.php" id="formVenta">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Cliente:</label>
            <select name="idcliente" class="form-select" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?php echo $c->idcliente; ?>"><?php echo htmlspecialchars($c->nomcliente); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Condición de venta:</label>
            <select name="idcondicion" class="form-select" required>
                <option value="01">Contado</option>
                <option value="02">Crédito</option>
            </select>
        </div>
    </div>

    <hr>
    <h5>Detalle de productos</h5>
    <table class="table table-bordered" id="tablaDetalle">
        <thead>
            <tr><th>Producto</th><th style="width:120px;">Cantidad</th><th style="width:120px;">Precio</th><th style="width:50px;"></th></tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="idproducto[]" class="form-select select-producto" required>
                        <option value="">-- Seleccione --</option>
                        <?php foreach ($productos as $p): ?>
                            <option value="<?php echo $p->idproducto; ?>" data-precio="<?php echo $p->preuni; ?>" data-stock="<?php echo $p->stock; ?>">
                                <?php echo htmlspecialchars($p->nomproducto); ?> (Stock: <?php echo $p->stock; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="cantidad[]" class="form-control input-cantidad" min="1" required></td>
                <td><input type="text" class="form-control input-precio" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger btn-quitar">&times;</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-secondary btn-sm" id="btnAgregarFila">+ Agregar producto</button>

    <hr>
    <button type="submit" class="btn btn-success">Registrar Venta</button>
</form>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabla = document.getElementById('tablaDetalle').querySelector('tbody');

    function filaTemplate() {
        return tabla.rows[0].cloneNode(true);
    }

    function actualizarPrecio(select) {
        const fila = select.closest('tr');
        const opcion = select.options[select.selectedIndex];
        const precio = opcion.getAttribute('data-precio') || '';
        fila.querySelector('.input-precio').value = precio;
    }

    tabla.addEventListener('change', function (e) {
        if (e.target.classList.contains('select-producto')) {
            actualizarPrecio(e.target);
        }
    });

    tabla.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-quitar')) {
            if (tabla.rows.length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });

    document.getElementById('btnAgregarFila').addEventListener('click', function () {
        const nuevaFila = filaTemplate();
        nuevaFila.querySelector('select').value = '';
        nuevaFila.querySelector('.input-cantidad').value = '';
        nuevaFila.querySelector('.input-precio').value = '';
        tabla.appendChild(nuevaFila);
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
