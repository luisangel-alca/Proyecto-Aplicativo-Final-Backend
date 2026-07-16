<?php
require_once __DIR__ . '/../includes/verificar_sesion.php';
require_once __DIR__ . '/../clases/Categoria.php';

$idcategoria = $_GET['id'] ?? '';

if ($idcategoria !== '') {
    $categoriaModel = new Categoria();
    try {
        $categoriaModel->eliminar($idcategoria);
    } catch (PDOException $e) {
        // Si tiene productos asociados no se puede eliminar (restricción de llave foránea)
        header('Location: index.php?msg=error');
        exit;
    }
}

header('Location: index.php?msg=ok');
exit;
