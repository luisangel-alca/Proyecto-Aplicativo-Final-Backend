-- =========================================================
-- PROYECTO: Sistema de Facturación y Control de Stocks
-- Base de datos: facturacion
-- =========================================================

CREATE DATABASE IF NOT EXISTS facturacion
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE facturacion;

-- ---------------------------------------------------------
-- Tabla: usuarios
-- ---------------------------------------------------------
CREATE TABLE usuarios (
  idusuario   VARCHAR(3) PRIMARY KEY,
  nomusuario  VARCHAR(15) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  apellidos   VARCHAR(64) NOT NULL,
  nombres     VARCHAR(64) NOT NULL,
  email       VARCHAR(64),
  estado      CHAR(1) NOT NULL DEFAULT '1'  -- 1: activo, 0: inactivo
);

-- ---------------------------------------------------------
-- Tabla: clientes
-- ---------------------------------------------------------
CREATE TABLE clientes (
  idcliente    VARCHAR(10) PRIMARY KEY,
  nomcliente   VARCHAR(128) NOT NULL,
  ruccliente   VARCHAR(11),
  dircliente   VARCHAR(128),
  telcliente   VARCHAR(9),
  emailcliente VARCHAR(64),
  estado       CHAR(1) NOT NULL DEFAULT '1'
);

-- ---------------------------------------------------------
-- Tabla: proveedores
-- ---------------------------------------------------------
CREATE TABLE proveedores (
  idproveedor    VARCHAR(3) PRIMARY KEY,
  nomproveedor   VARCHAR(128) NOT NULL,
  rucproveedor   VARCHAR(11),
  dirproveedor   VARCHAR(128),
  telproveedor   VARCHAR(9),
  emailproveedor VARCHAR(64),
  estado         CHAR(1) NOT NULL DEFAULT '1'
);

-- ---------------------------------------------------------
-- Tabla: categorias
-- ---------------------------------------------------------
CREATE TABLE categorias (
  idcategoria  CHAR(2) PRIMARY KEY,
  nomcategoria VARCHAR(128) NOT NULL
);

-- ---------------------------------------------------------
-- Tabla: condicionventa
-- ---------------------------------------------------------
CREATE TABLE condicionventa (
  idcondicion  CHAR(2) PRIMARY KEY,
  nomcondicion VARCHAR(64) NOT NULL
);

-- ---------------------------------------------------------
-- Tabla: productos
-- ---------------------------------------------------------
CREATE TABLE productos (
  idproducto  VARCHAR(10) PRIMARY KEY,
  idproveedor VARCHAR(3) NOT NULL,
  nomproducto VARCHAR(128) NOT NULL,
  unimed      VARCHAR(15),
  stock       INT NOT NULL DEFAULT 0,
  cosuni      DECIMAL(10,4) NOT NULL DEFAULT 0,
  preuni      DECIMAL(10,4) NOT NULL DEFAULT 0,
  idcategoria CHAR(2) NOT NULL,
  estado      CHAR(1) NOT NULL DEFAULT '1',
  CONSTRAINT fk_producto_proveedor FOREIGN KEY (idproveedor) REFERENCES proveedores(idproveedor),
  CONSTRAINT fk_producto_categoria FOREIGN KEY (idcategoria) REFERENCES categorias(idcategoria)
);

-- ---------------------------------------------------------
-- Tabla: facturas (cabecera de venta)
-- ---------------------------------------------------------
CREATE TABLE facturas (
  idfactura   INT AUTO_INCREMENT PRIMARY KEY,
  fecha       DATE NOT NULL,
  idcliente   VARCHAR(10) NOT NULL,
  idusuario   VARCHAR(3) NOT NULL,
  fechareg    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  idcondicion CHAR(2) NOT NULL,
  valorventa  DECIMAL(10,4) NOT NULL DEFAULT 0,
  igv         DECIMAL(10,4) NOT NULL DEFAULT 0,
  CONSTRAINT fk_factura_cliente   FOREIGN KEY (idcliente)   REFERENCES clientes(idcliente),
  CONSTRAINT fk_factura_usuario   FOREIGN KEY (idusuario)   REFERENCES usuarios(idusuario),
  CONSTRAINT fk_factura_condicion FOREIGN KEY (idcondicion) REFERENCES condicionventa(idcondicion)
);

-- ---------------------------------------------------------
-- Tabla: detallefactura
-- ---------------------------------------------------------
CREATE TABLE detallefactura (
  iddetalle   INT AUTO_INCREMENT PRIMARY KEY,
  idfactura   INT NOT NULL,
  idproducto  VARCHAR(10) NOT NULL,
  cant        INT NOT NULL,
  cosuni      DECIMAL(19,4) NOT NULL,
  preuni      DECIMAL(10,4) NOT NULL,
  CONSTRAINT fk_detalle_factura  FOREIGN KEY (idfactura)  REFERENCES facturas(idfactura),
  CONSTRAINT fk_detalle_producto FOREIGN KEY (idproducto) REFERENCES productos(idproducto)
);

-- =========================================================
-- DATOS DE PRUEBA
-- =========================================================

-- Usuarios (3 registros) - password real: "123456" (hasheado con password_hash)
INSERT INTO usuarios (idusuario, nomusuario, password, apellidos, nombres, email, estado) VALUES
('U01', 'jvelasquez', '$2b$10$vFgmCw.g9hkqKHRBppLqzuB3kGNLeQBTmVdmTTlwUnarlyjfIOkoG', 'Velásquez Quille', 'Juaquín David', 'jvelasquez@correo.com', '1'),
('U02', 'aaraujo',    '$2b$10$vFgmCw.g9hkqKHRBppLqzuB3kGNLeQBTmVdmTTlwUnarlyjfIOkoG', 'Araujo Chavez',    'Aldair Alexander', 'aaraujo@correo.com', '1'),
('U03', 'lalvarez',   '$2b$10$vFgmCw.g9hkqKHRBppLqzuB3kGNLeQBTmVdmTTlwUnarlyjfIOkoG', 'Alvarez Calloapaza','Luis Angel', 'lalvarez@correo.com', '1');

-- Categorías (5 registros)
INSERT INTO categorias (idcategoria, nomcategoria) VALUES
('01', 'Abarrotes'),
('02', 'Bebidas'),
('03', 'Limpieza'),
('04', 'Lácteos'),
('05', 'Cuidado Personal');

-- CondicionVenta (2 registros)
INSERT INTO condicionventa (idcondicion, nomcondicion) VALUES
('01', 'Contado'),
('02', 'Crédito');

-- Clientes (10 registros)
INSERT INTO clientes (idcliente, nomcliente, ruccliente, dircliente, telcliente, emailcliente, estado) VALUES
('C001', 'Juan Pérez Gómez',        '10456789123', 'Av. Ejército 123, Arequipa',      '954123456', 'jperez@mail.com', '1'),
('C002', 'María López Torres',      '10456789124', 'Calle Mercaderes 45, Arequipa',    '954123457', 'mlopez@mail.com', '1'),
('C003', 'Carlos Ramírez Sosa',     '10456789125', 'Av. Dolores 200, Arequipa',        '954123458', 'cramirez@mail.com', '1'),
('C004', 'Ana Quispe Mamani',       '10456789126', 'Urb. San Isidro 300, Arequipa',    '954123459', 'aquispe@mail.com', '1'),
('C005', 'Pedro Flores Chura',      '10456789127', 'Calle Jerusalén 78, Arequipa',     '954123460', 'pflores@mail.com', '1'),
('C006', 'Lucía Salazar Vega',      '10456789128', 'Av. Parra 156, Arequipa',          '954123461', 'lsalazar@mail.com', '1'),
('C007', 'Miguel Torres Huamán',    '10456789129', 'Calle San Francisco 88, Arequipa', '954123462', 'mtorres@mail.com', '1'),
('C008', 'Rosa Mendoza Choque',     '10456789130', 'Av. La Marina 400, Arequipa',      '954123463', 'rmendoza@mail.com', '1'),
('C009', 'Jorge Vilca Apaza',       '10456789131', 'Calle Consuelo 25, Arequipa',      '954123464', 'jvilca@mail.com', '1'),
('C010', 'Elena Cárdenas Ríos',     '10456789132', 'Av. Ejército 500, Arequipa',       '954123465', 'ecardenas@mail.com', '1');

-- Proveedores (10 registros)
INSERT INTO proveedores (idproveedor, nomproveedor, rucproveedor, dirproveedor, telproveedor, emailproveedor, estado) VALUES
('P01', 'Distribuidora Andina S.A.C.',    '20456712301', 'Parque Industrial Mza A, Arequipa', '954111001', 'contacto@andina.com', '1'),
('P02', 'Alicorp S.A.A.',                 '20456712302', 'Av. Argentina 200, Arequipa',       '954111002', 'ventas@alicorp.com', '1'),
('P03', 'Gloria S.A.',                    '20456712303', 'Av. Aviación 300, Arequipa',        '954111003', 'ventas@gloria.com', '1'),
('P04', 'Backus y Johnston S.A.A.',       '20456712304', 'Av. Vidaurrázaga 150, Arequipa',    '954111004', 'contacto@backus.com', '1'),
('P05', 'Comercial del Sur E.I.R.L.',     '20456712305', 'Calle Consuelo 100, Arequipa',      '954111005', 'ventas@comsur.com', '1'),
('P06', 'Molitalia S.A.',                 '20456712306', 'Av. Metropolitana 400, Arequipa',   '954111006', 'contacto@molitalia.com', '1'),
('P07', 'Química Suiza S.A.',             '20456712307', 'Zona Industrial Río Seco, Arequipa','954111007', 'ventas@qsuiza.com', '1'),
('P08', 'Nestlé Perú S.A.',               '20456712308', 'Av. Kennedy 250, Arequipa',         '954111008', 'contacto@nestle.com', '1'),
('P09', 'Unión de Cervecerías Peruanas',  '20456712309', 'Carretera Variante 20, Arequipa',   '954111009', 'ventas@ucp.com', '1'),
('P10', 'Grupo Familia Perú S.A.',        '20456712310', 'Av. Andrés A. Cáceres 60, Arequipa','954111010', 'contacto@familia.com', '1');

-- Productos (10 registros)
INSERT INTO productos (idproducto, idproveedor, nomproducto, unimed, stock, cosuni, preuni, idcategoria, estado) VALUES
('PR0000001', 'P02', 'Arroz Costeño 5kg',          'BOLSA', 100, 12.5000, 16.9000, '01', '1'),
('PR0000002', 'P02', 'Aceite Primor 1L',           'BOTELLA', 80, 9.2000,  12.5000, '01', '1'),
('PR0000003', 'P04', 'Cerveza Pilsen 620ml',       'BOTELLA', 150, 4.5000, 6.5000,  '02', '1'),
('PR0000004', 'P09', 'Gaseosa Coca Cola 1.5L',     'BOTELLA', 120, 4.0000, 6.0000,  '02', '1'),
('PR0000005', 'P05', 'Detergente Ariel 800g',      'BOLSA', 60,  8.0000,  11.5000, '03', '1'),
('PR0000006', 'P05', 'Lejía Clorox 1L',            'BOTELLA', 90, 3.0000, 4.5000,  '03', '1'),
('PR0000007', 'P03', 'Leche Gloria Evaporada 400g', 'LATA',  200, 3.2000, 4.3000,  '04', '1'),
('PR0000008', 'P03', 'Yogurt Gloria 1L',           'BOTELLA', 70, 6.5000,  9.0000,  '04', '1'),
('PR0000009', 'P10', 'Papel Higiénico Suave x4',   'PAQUETE', 100, 5.0000, 7.5000,  '05', '1'),
('PR0000010', 'P07', 'Jabón Dove 90g',             'UNIDAD', 150, 2.0000, 3.2000,  '05', '1');
