<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Facturación y Control de Stocks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">Facturación &amp; Stocks</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuPrincipal">
      <ul class="navbar-nav me-auto">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Archivos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>productos/index.php">Productos</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>clientes/index.php">Clientes</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>proveedores/index.php">Proveedores</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>categorias/index.php">Categorías</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>usuarios/index.php">Usuarios</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>logout.php">Terminar</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Procesos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>ventas/registrar.php">Registrar Ventas</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Consultas</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>consultas/stock_productos.php">Stock productos</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>consultas/ventas_dia.php">Ventas por día</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>consultas/ventas_fecha.php">Ventas por fecha</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>consultas/venta_cliente.php">Venta por Cliente</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>consultas/venta_producto.php">Venta por producto</a></li>
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>consultas/ranking_ventas.php">Ranking ventas</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Herramientas</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>usuarios/cambiar_password.php">Cambiar Password</a></li>
          </ul>
        </li>

      </ul>
      <span class="navbar-text text-light">
        <?php if (isset($_SESSION['nombres'])): ?>
          Bienvenido, <?php echo htmlspecialchars($_SESSION['nombres']); ?>
          | <a href="<?php echo BASE_URL; ?>logout.php" class="text-warning">Salir</a>
        <?php endif; ?>
      </span>
    </div>
  </div>
</nav>
<div class="container mt-4">
