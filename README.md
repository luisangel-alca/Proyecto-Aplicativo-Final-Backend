# Sistema de Facturación y Control de Stocks

Proyecto Aplicativo Final — Curso de Desarrollo Backend (PHP)

## Descripción

Sistema web de facturación desarrollado en **PHP orientado a objetos**, con conexión a **MySQL mediante PDO**, que permite registrar ventas, controlar el stock de productos, y gestionar clientes, productos, proveedores, categorías y usuarios.

## Integrantes

Ver archivo [`integrantes.txt`](./integrantes.txt) en la raíz del proyecto.

## Tecnologías utilizadas

- PHP 8 (Programación Orientada a Objetos)
- MySQL / MariaDB
- PDO (PHP Data Objects) para acceso a datos
- Bootstrap 5 (interfaz)
- Sesiones PHP (autenticación)

## Estructura del proyecto

```
proyecto-facturacion/
├── integrantes.txt        # Nombres del equipo
├── sql/facturacion.sql    # Script completo de la base de datos + datos de prueba
├── conexion/               # Conexión PDO (Singleton)
├── clases/                 # Clases POO (Cliente, Producto, Proveedor, Categoria, Usuario, Factura)
├── includes/                # Header, footer, config y verificación de sesión
├── clientes/  productos/  proveedores/  categorias/  usuarios/   # Módulos CRUD (Archivos)
├── ventas/                 # Registro de ventas (Procesos)
├── consultas/               # Stock, ventas por día/fecha/cliente/producto, ranking
├── login.php / logout.php / index.php
└── css/
```

## Instalación (XAMPP)

1. Copiar la carpeta `proyecto-facturacion` dentro de `C:\xampp\htdocs\`
2. Iniciar **Apache** y **MySQL** desde el panel de XAMPP.
3. Abrir **phpMyAdmin** (`http://localhost/phpmyadmin`) e importar el archivo `sql/facturacion.sql`.
4. Verificar los datos de conexión en `conexion/Conexion.php` (por defecto: host `localhost`, usuario `root`, sin contraseña).
5. Acceder a `http://localhost/proyecto-facturacion/login.php`

## Credenciales de prueba

| Usuario     | Contraseña |
|-------------|------------|
| jvelasquez  | 123456     |
| aaraujo     | 123456     |
| achoque     | 123456     |
| lalvarez    | 123456     |

## Requerimientos funcionales cubiertos

- [x] Registro de ventas (contado/crédito) con detalle de productos
- [x] CRUD de Clientes, Productos, Proveedores
- [x] Clasificación de productos por categoría
- [x] Control de stock (se descuenta automáticamente al vender)
- [x] Consulta de ventas por día y entre fechas
- [x] Consulta de ventas por cliente
- [x] Consulta de ventas por producto
- [x] Ranking de ventas por importe
- [x] Login y control de sesión
- [x] Cambio de contraseña
