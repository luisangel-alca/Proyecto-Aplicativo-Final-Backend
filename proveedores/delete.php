<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Proveedor.php';

$idproveedor = $_GET['id'] ?? '';

if ($idproveedor !== '') {
    $proveedorModel = new Proveedor();
    $proveedorModel->eliminar($idproveedor);
}

header('Location: index.php?msg=ok');
exit;
