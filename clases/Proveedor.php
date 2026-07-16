<?php
require_once __DIR__ . '/../conexion/Conexion.php';

class Proveedor
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    public function listarProveedores()
    {
        $sql = "SELECT * FROM proveedores WHERE estado = '1' ORDER BY nomproveedor ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId($idproveedor)
    {
        $sql = "SELECT * FROM proveedores WHERE idproveedor = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idproveedor]);
        return $stmt->fetch();
    }

    public function generarCodigo()
    {
        $sql = "SELECT idproveedor FROM proveedores ORDER BY idproveedor DESC LIMIT 1";
        $ultimo = $this->pdo->query($sql)->fetch();
        if (!$ultimo) {
            return 'P01';
        }
        $numero = (int) substr($ultimo->idproveedor, 1) + 1;
        return 'P' . str_pad($numero, 2, '0', STR_PAD_LEFT);
    }

    public function agregar($datos)
    {
        $idproveedor = $this->generarCodigo();
        $sql = "INSERT INTO proveedores (idproveedor, nomproveedor, rucproveedor, dirproveedor, telproveedor, emailproveedor, estado)
                VALUES (:id, :nombre, :ruc, :direccion, :telefono, :email, '1')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'        => $idproveedor,
            ':nombre'    => $datos['nomproveedor'],
            ':ruc'       => $datos['rucproveedor'],
            ':direccion' => $datos['dirproveedor'],
            ':telefono'  => $datos['telproveedor'],
            ':email'     => $datos['emailproveedor'],
        ]);
    }

    public function actualizar($idproveedor, $datos)
    {
        $sql = "UPDATE proveedores
                SET nomproveedor = :nombre, rucproveedor = :ruc, dirproveedor = :direccion,
                    telproveedor = :telefono, emailproveedor = :email
                WHERE idproveedor = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'        => $idproveedor,
            ':nombre'    => $datos['nomproveedor'],
            ':ruc'       => $datos['rucproveedor'],
            ':direccion' => $datos['dirproveedor'],
            ':telefono'  => $datos['telproveedor'],
            ':email'     => $datos['emailproveedor'],
        ]);
    }

    public function eliminar($idproveedor)
    {
        $sql = "UPDATE proveedores SET estado = '0' WHERE idproveedor = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idproveedor]);
    }
}
