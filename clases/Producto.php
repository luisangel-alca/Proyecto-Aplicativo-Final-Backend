<?php
require_once __DIR__ . '/../conexion/Conexion.php';

class Producto
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    // Listado con JOIN para mostrar nombre de proveedor y categoría
    public function listarProductos()
    {
        $sql = "SELECT p.*, pv.nomproveedor, c.nomcategoria
                FROM productos p
                INNER JOIN proveedores pv ON p.idproveedor = pv.idproveedor
                INNER JOIN categorias c ON p.idcategoria = c.idcategoria
                WHERE p.estado = '1'
                ORDER BY p.nomproducto ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId($idproducto)
    {
        $sql = "SELECT * FROM productos WHERE idproducto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idproducto]);
        return $stmt->fetch();
    }

    public function generarCodigo()
    {
        $sql = "SELECT idproducto FROM productos ORDER BY idproducto DESC LIMIT 1";
        $ultimo = $this->pdo->query($sql)->fetch();
        if (!$ultimo) {
            return 'PR0000001';
        }
        $numero = (int) substr($ultimo->idproducto, 2) + 1;
        return 'PR' . str_pad($numero, 7, '0', STR_PAD_LEFT);
    }

    public function agregar($datos)
    {
        $idproducto = $this->generarCodigo();
        $sql = "INSERT INTO productos (idproducto, idproveedor, nomproducto, unimed, stock, cosuni, preuni, idcategoria, estado)
                VALUES (:id, :idproveedor, :nombre, :unimed, :stock, :costo, :precio, :idcategoria, '1')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $idproducto,
            ':idproveedor' => $datos['idproveedor'],
            ':nombre'      => $datos['nomproducto'],
            ':unimed'      => $datos['unimed'],
            ':stock'       => $datos['stock'],
            ':costo'       => $datos['cosuni'],
            ':precio'      => $datos['preuni'],
            ':idcategoria' => $datos['idcategoria'],
        ]);
    }

    public function actualizar($idproducto, $datos)
    {
        $sql = "UPDATE productos
                SET idproveedor = :idproveedor, nomproducto = :nombre, unimed = :unimed,
                    cosuni = :costo, preuni = :precio, idcategoria = :idcategoria
                WHERE idproducto = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $idproducto,
            ':idproveedor' => $datos['idproveedor'],
            ':nombre'      => $datos['nomproducto'],
            ':unimed'      => $datos['unimed'],
            ':costo'       => $datos['cosuni'],
            ':precio'      => $datos['preuni'],
            ':idcategoria' => $datos['idcategoria'],
        ]);
    }

    public function eliminar($idproducto)
    {
        $sql = "UPDATE productos SET estado = '0' WHERE idproducto = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idproducto]);
    }

    // Descontar stock al registrar una venta
    public function descontarStock($idproducto, $cantidad)
    {
        $sql = "UPDATE productos SET stock = stock - :cant WHERE idproducto = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':cant' => $cantidad, ':id' => $idproducto]);
    }

    // Consulta: stock de productos (requerimiento funcional #6)
    public function listarStock()
    {
        $sql = "SELECT idproducto, nomproducto, unimed, stock, preuni
                FROM productos WHERE estado = '1' ORDER BY nomproducto";
        return $this->pdo->query($sql)->fetchAll();
    }
}
