<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Cliente.php';

$idcliente = $_GET['id'] ?? '';

if ($idcliente !== '') {
    $clienteModel = new Cliente();
    $clienteModel->eliminar($idcliente);
}

header('Location: index.php?msg=ok');
exit;
