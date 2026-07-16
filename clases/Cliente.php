<?php
require_once __DIR__ . '/../conexion/Conexion.php';

class Cliente
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    // Listar todos los clientes activos
    public function listarClientes()
    {
        $sql = "SELECT * FROM clientes WHERE estado = '1' ORDER BY nomcliente ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Obtener un cliente por su id
    public function obtenerPorId($idcliente)
    {
        $sql = "SELECT * FROM clientes WHERE idcliente = :idcliente";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idcliente', $idcliente);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Generar el siguiente código de cliente (C001, C002, ...)
    public function generarCodigo()
    {
        $sql = "SELECT idcliente FROM clientes ORDER BY idcliente DESC LIMIT 1";
        $stmt = $this->pdo->query($sql);
        $ultimo = $stmt->fetch();

        if (!$ultimo) {
            return 'C001';
        }
        $numero = (int) substr($ultimo->idcliente, 1) + 1;
        return 'C' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }

    // Registrar nuevo cliente
    public function agregar($datos)
    {
        $idcliente = $this->generarCodigo();

        $sql = "INSERT INTO clientes (idcliente, nomcliente, ruccliente, dircliente, telcliente, emailcliente, estado)
                VALUES (:idcliente, :nomcliente, :ruccliente, :dircliente, :telcliente, :emailcliente, '1')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idcliente'    => $idcliente,
            ':nomcliente'   => $datos['nomcliente'],
            ':ruccliente'   => $datos['ruccliente'],
            ':dircliente'   => $datos['dircliente'],
            ':telcliente'   => $datos['telcliente'],
            ':emailcliente' => $datos['emailcliente'],
        ]);
    }

    // Actualizar cliente existente
    public function actualizar($idcliente, $datos)
    {
        $sql = "UPDATE clientes
                SET nomcliente = :nomcliente,
                    ruccliente = :ruccliente,
                    dircliente = :dircliente,
                    telcliente = :telcliente,
                    emailcliente = :emailcliente
                WHERE idcliente = :idcliente";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idcliente'    => $idcliente,
            ':nomcliente'   => $datos['nomcliente'],
            ':ruccliente'   => $datos['ruccliente'],
            ':dircliente'   => $datos['dircliente'],
            ':telcliente'   => $datos['telcliente'],
            ':emailcliente' => $datos['emailcliente'],
        ]);
    }

    // "Eliminar" cliente = cambiar su estado a inactivo (borrado lógico)
    public function eliminar($idcliente)
    {
        $sql = "UPDATE clientes SET estado = '0' WHERE idcliente = :idcliente";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':idcliente' => $idcliente]);
    }

    // Buscar ventas de un cliente (para el módulo de consultas)
    public function buscarPorNombre($texto)
    {
        $sql = "SELECT * FROM clientes WHERE estado = '1' AND nomcliente LIKE :texto ORDER BY nomcliente";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':texto', '%' . $texto . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
