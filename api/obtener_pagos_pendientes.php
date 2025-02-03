<?php
require_once "../config/conexion.php";

header("Content-Type: application/json");

if (!isset($_GET["id_lote"]) || empty($_GET["id_lote"])) {
    echo json_encode(["success" => false, "message" => "ID de lote no proporcionado."]);
    exit;
}

$id_lote = $_GET["id_lote"];

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Consulta para obtener pagos pendientes del lote
    $stmt = $conn->prepare("SELECT id_cuenta, fecha_pago, monto_pago, monto_pagado 
                            FROM cuentas_por_cobrar 
                            WHERE id_lote = ? AND estado_pago IN ('pendiente', 'vencido')
                            ORDER BY fecha_pago ASC");

    $stmt->execute([$id_lote]);
    $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$pagos) {
        echo json_encode(["success" => true, "message" => "No hay pagos pendientes para este lote.", "data" => []]);
        exit;
    }

    echo json_encode(["success" => true, "data" => $pagos]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error en la consulta SQL", "error" => $e->getMessage()]);
}
?>
