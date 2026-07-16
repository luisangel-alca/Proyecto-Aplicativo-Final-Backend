<?php
require_once __DIR__ . '/../conexion/Conexion.php';

class Categoria
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    public function listarCategorias()
    {
        $sql = "SELECT * FROM categorias ORDER BY nomcategoria ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId($idcategoria)
    {
        $sql = "SELECT * FROM categorias WHERE idcategoria = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idcategoria]);
        return $stmt->fetch();
    }

    public function generarCodigo()
    {
        $sql = "SELECT idcategoria FROM categorias ORDER BY idcategoria DESC LIMIT 1";
        $ultimo = $this->pdo->query($sql)->fetch();
        if (!$ultimo) {
            return '01';
        }
        $numero = (int) $ultimo->idcategoria + 1;
        return str_pad($numero, 2, '0', STR_PAD_LEFT);
    }

    public function agregar($nomcategoria)
    {
        $idcategoria = $this->generarCodigo();
        $sql = "INSERT INTO categorias (idcategoria, nomcategoria) VALUES (:id, :nombre)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idcategoria, ':nombre' => $nomcategoria]);
    }

    public function actualizar($idcategoria, $nomcategoria)
    {
        $sql = "UPDATE categorias SET nomcategoria = :nombre WHERE idcategoria = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idcategoria, ':nombre' => $nomcategoria]);
    }

    public function eliminar($idcategoria)
    {
        // No tiene columna estado en el diseño original: se elimina físicamente
        $sql = "DELETE FROM categorias WHERE idcategoria = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idcategoria]);
    }
}
