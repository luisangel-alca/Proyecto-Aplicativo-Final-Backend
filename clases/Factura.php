<?php
require_once __DIR__ . '/../conexion/Conexion.php';

class Factura
{
    private $pdo;
    const IGV_PORCENTAJE = 0.18;

    public function __construct()
    {
        $this->pdo = Conexion::getConexion();
    }

    /**
     * Registra una venta completa (cabecera + detalle) en una transacción.
     * $detalle es un arreglo de items: [ ['idproducto'=>..,'cant'=>..,'preuni'=>..,'cosuni'=>..], ... ]
     */
    public function registrarVenta($idcliente, $idusuario, $idcondicion, $detalle)
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Calcular totales
            $subtotal = 0;
            foreach ($detalle as $item) {
                $subtotal += $item['cant'] * $item['preuni'];
            }
            $igv = round($subtotal * self::IGV_PORCENTAJE, 4);
            $valorventa = $subtotal + $igv;

            // 2. Insertar cabecera de factura
            $sql = "INSERT INTO facturas (fecha, idcliente, idusuario, fechareg, idcondicion, valorventa, igv)
                    VALUES (CURDATE(), :idcliente, :idusuario, NOW(), :idcondicion, :valorventa, :igv)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':idcliente'   => $idcliente,
                ':idusuario'   => $idusuario,
                ':idcondicion' => $idcondicion,
                ':valorventa'  => $valorventa,
                ':igv'         => $igv,
            ]);
            $idfactura = $this->pdo->lastInsertId();

            // 3. Insertar detalle y descontar stock
            $sqlDetalle = "INSERT INTO detallefactura (idfactura, idproducto, cant, cosuni, preuni)
                           VALUES (:idfactura, :idproducto, :cant, :cosuni, :preuni)";
            $stmtDetalle = $this->pdo->prepare($sqlDetalle);

            $sqlStock = "UPDATE productos SET stock = stock - :cant WHERE idproducto = :idproducto";
            $stmtStock = $this->pdo->prepare($sqlStock);

            foreach ($detalle as $item) {
                $stmtDetalle->execute([
                    ':idfactura'  => $idfactura,
                    ':idproducto' => $item['idproducto'],
                    ':cant'       => $item['cant'],
                    ':cosuni'     => $item['cosuni'],
                    ':preuni'     => $item['preuni'],
                ]);
                $stmtStock->execute([
                    ':cant'       => $item['cant'],
                    ':idproducto' => $item['idproducto'],
                ]);
            }

            $this->pdo->commit();
            return $idfactura;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Consulta: listado de ventas de un día específico (requerimiento #7)
    public function ventasPorDia($fecha)
    {
        $sql = "SELECT f.idfactura, f.fecha, c.nomcliente, f.valorventa, cv.nomcondicion
                FROM facturas f
                INNER JOIN clientes c ON f.idcliente = c.idcliente
                INNER JOIN condicionventa cv ON f.idcondicion = cv.idcondicion
                WHERE f.fecha = :fecha
                ORDER BY f.idfactura DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':fecha' => $fecha]);
        return $stmt->fetchAll();
    }

    // Consulta: listado de ventas entre fechas (requerimiento #7)
    public function ventasEntreFechas($fechaInicio, $fechaFin)
    {
        $sql = "SELECT f.idfactura, f.fecha, c.nomcliente, f.valorventa, cv.nomcondicion
                FROM facturas f
                INNER JOIN clientes c ON f.idcliente = c.idcliente
                INNER JOIN condicionventa cv ON f.idcondicion = cv.idcondicion
                WHERE f.fecha BETWEEN :inicio AND :fin
                ORDER BY f.fecha ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $fechaInicio, ':fin' => $fechaFin]);
        return $stmt->fetchAll();
    }

    // Consulta: ventas por cliente (requerimiento #8)
    public function ventasPorCliente($idcliente)
    {
        $sql = "SELECT f.idfactura, f.fecha, f.valorventa, cv.nomcondicion
                FROM facturas f
                INNER JOIN condicionventa cv ON f.idcondicion = cv.idcondicion
                WHERE f.idcliente = :idcliente
                ORDER BY f.fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idcliente' => $idcliente]);
        return $stmt->fetchAll();
    }

    // Consulta: ventas por producto (requerimiento #9)
    public function ventasPorProducto($idproducto)
    {
        $sql = "SELECT f.idfactura, f.fecha, c.nomcliente, df.cant, df.preuni,
                       (df.cant * df.preuni) AS importe
                FROM detallefactura df
                INNER JOIN facturas f ON df.idfactura = f.idfactura
                INNER JOIN clientes c ON f.idcliente = c.idcliente
                WHERE df.idproducto = :idproducto
                ORDER BY f.fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idproducto' => $idproducto]);
        return $stmt->fetchAll();
    }

    // Consulta: ranking de ventas por importe (requerimiento #10)
    public function rankingVentas($limite = 10)
    {
        $sql = "SELECT f.idfactura, f.fecha, c.nomcliente, f.valorventa
                FROM facturas f
                INNER JOIN clientes c ON f.idcliente = c.idcliente
                ORDER BY f.valorventa DESC
                LIMIT :limite";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerDetalle($idfactura)
    {
        $sql = "SELECT df.*, p.nomproducto
                FROM detallefactura df
                INNER JOIN productos p ON df.idproducto = p.idproducto
                WHERE df.idfactura = :idfactura";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idfactura' => $idfactura]);
        return $stmt->fetchAll();
    }
}
