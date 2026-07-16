<?php
/**
 * Clase Conexion
 * Maneja la conexión PDO a la base de datos MySQL usando el patrón Singleton
 * (una sola instancia de conexión reutilizada en todo el sistema).
 */
class Conexion
{
    private static $instancia = null;

    // ---- Configuración de la base de datos (ajustar según tu XAMPP) ----
    private $host   = 'localhost';
    private $dbname = 'facturacion';
    private $user   = 'root';
    private $pass   = '';
    // ---------------------------------------------------------------------

    private $pdo;

    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    // Evita clonar la instancia (Singleton)
    private function __clone() {}

    public static function getConexion()
    {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia->pdo;
    }
}
