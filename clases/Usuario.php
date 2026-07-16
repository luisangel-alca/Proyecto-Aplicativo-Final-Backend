<?php
require_once __DIR__ . '/../conexion/Conexion.php';

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    // Autenticación de login
    public function login($nomusuario, $password)
    {
        $sql = "SELECT * FROM usuarios WHERE nomusuario = :usuario AND estado = '1'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario' => $nomusuario]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario->password)) {
            return $usuario;
        }
        return false;
    }

    public function listarUsuarios()
    {
        $sql = "SELECT idusuario, nomusuario, apellidos, nombres, email, estado
                FROM usuarios ORDER BY apellidos ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId($idusuario)
    {
        $sql = "SELECT * FROM usuarios WHERE idusuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idusuario]);
        return $stmt->fetch();
    }

    public function generarCodigo()
    {
        $sql = "SELECT idusuario FROM usuarios ORDER BY idusuario DESC LIMIT 1";
        $ultimo = $this->pdo->query($sql)->fetch();
        if (!$ultimo) {
            return 'U01';
        }
        $numero = (int) substr($ultimo->idusuario, 1) + 1;
        return 'U' . str_pad($numero, 2, '0', STR_PAD_LEFT);
    }

    public function agregar($datos)
    {
        $idusuario = $this->generarCodigo();
        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (idusuario, nomusuario, password, apellidos, nombres, email, estado)
                VALUES (:id, :usuario, :password, :apellidos, :nombres, :email, '1')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'        => $idusuario,
            ':usuario'   => $datos['nomusuario'],
            ':password'  => $hash,
            ':apellidos' => $datos['apellidos'],
            ':nombres'   => $datos['nombres'],
            ':email'     => $datos['email'],
        ]);
    }

    public function actualizar($idusuario, $datos)
    {
        $sql = "UPDATE usuarios
                SET apellidos = :apellidos, nombres = :nombres, email = :email
                WHERE idusuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'        => $idusuario,
            ':apellidos' => $datos['apellidos'],
            ':nombres'   => $datos['nombres'],
            ':email'     => $datos['email'],
        ]);
    }

    // Cambiar contraseña (módulo Herramientas > Cambiar Password)
    public function cambiarPassword($idusuario, $passwordActual, $passwordNueva)
    {
        $usuario = $this->obtenerPorId($idusuario);
        if (!$usuario || !password_verify($passwordActual, $usuario->password)) {
            return false;
        }
        $hash = password_hash($passwordNueva, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET password = :password WHERE idusuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':password' => $hash, ':id' => $idusuario]);
    }

    public function eliminar($idusuario)
    {
        $sql = "UPDATE usuarios SET estado = '0' WHERE idusuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $idusuario]);
    }
}
