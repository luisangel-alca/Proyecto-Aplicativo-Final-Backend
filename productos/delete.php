<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Producto.php';

$idproducto = $_GET['id'] ?? '';

if ($idproducto !== '') {
    $productoModel = new Producto();
    $productoModel->eliminar($idproducto);
}

header('Location: index.php?msg=ok');
exit;
