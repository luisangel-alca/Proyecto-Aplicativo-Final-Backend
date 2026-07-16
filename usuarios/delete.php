<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Usuario.php';

$idusuario = $_GET['id'] ?? '';

if ($idusuario !== '') {
    $usuarioModel = new Usuario();
    $usuarioModel->eliminar($idusuario);
}

header('Location: index.php?msg=ok');
exit;
