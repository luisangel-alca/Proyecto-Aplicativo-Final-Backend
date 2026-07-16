<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Usuario.php';
require_once __DIR__ . '/../includes/header.php';

$usuarioModel = new Usuario();
$usuarios = $usuarioModel->listarUsuarios();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de Usuarios</h3>
    <a href="create.php" class="btn btn-info">+ Agregar usuario</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'ok'): ?>
    <div class="alert alert-success">Operación realizada correctamente.</div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<table class="table table-bordered table-hover">
    <thead>
        <tr><th>Código</th><th>Usuario</th><th>Apellidos</th><th>Nombres</th><th>E-mail</th><th>Estado</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row->idusuario); ?></td>
            <td><?php echo htmlspecialchars($row->nomusuario); ?></td>
            <td><?php echo htmlspecialchars($row->apellidos); ?></td>
            <td><?php echo htmlspecialchars($row->nombres); ?></td>
            <td><?php echo htmlspecialchars($row->email); ?></td>
            <td><?php echo $row->estado === '1' ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?></td>
            <td>
                <a href="update.php?id=<?php echo urlencode($row->idusuario); ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="delete.php?id=<?php echo urlencode($row->idusuario); ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('¿Desactivar este usuario?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
