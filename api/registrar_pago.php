<?php
require_once "../config/conexion.php";

header("Content-Type: application/json");

// Verificar si los datos fueron enviados correctamente
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["id_lote"], $data["monto_pagado"], $data["metodo_pago"], $data["fecha_pago_efectivo"])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    exit;
}

$id_lote = $data["id_lote"];
$monto_a_pagar = floatval($data["monto_pagado"]);
$metodo_pago = $data["metodo_pago"];
$fecha_pago_efectivo = $data["fecha_pago_efectivo"];
$folio_pago = isset($data["folio_pago"]) ? $data["folio_pago"] : null;
$comentarios = isset($data["comentarios"]) ? $data["comentarios"] : null;

try {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->beginTransaction();

    // 1️⃣ Obtener todas las cuotas pendientes del lote, ordenadas por fecha
    $stmt = $conn->prepare("SELECT id_cuenta, monto_pago, monto_pagado 
                            FROM cuentas_por_cobrar 
                            WHERE id_lote = ? AND estado_pago IN ('pendiente', 'vencido')
                            ORDER BY fecha_pago ASC");
    $stmt->execute([$id_lote]);
    $cuotas_pendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$cuotas_pendientes) {
        echo json_encode(["success" => false, "message" => "No hay pagos pendientes para este lote."]);
        exit;
    }

    // 2️⃣ Aplicar el pago en las cuotas pendientes
    foreach ($cuotas_pendientes as $cuota) {
        if ($monto_a_pagar <= 0) {
            break;
        }

        $id_cuenta = $cuota["id_cuenta"];
        $saldo_restante = $cuota["monto_pago"] - $cuota["monto_pagado"];

        if ($monto_a_pagar >= $saldo_restante) {
            // Pago total de la cuota
            $nuevo_monto_pagado = $cuota["monto_pagado"] + $saldo_restante;
            $estado_pago = "pagado";
            $monto_a_pagar -= $saldo_restante;
        } else {
            // Pago parcial de la cuota
            $nuevo_monto_pagado = $cuota["monto_pagado"] + $monto_a_pagar;
            $estado_pago = "pendiente";
            $monto_a_pagar = 0;
        }

        // 3️⃣ Actualizar la cuota en cuentas_por_cobrar
        $stmt = $conn->prepare("UPDATE cuentas_por_cobrar SET monto_pagado = ?, estado_pago = ? WHERE id_cuenta = ?");
        $stmt->execute([$nuevo_monto_pagado, $estado_pago, $id_cuenta]);

        // 4️⃣ Registrar el pago en pagos_realizados
        $stmt = $conn->prepare("INSERT INTO pagos_realizados (id_cuenta, monto_pagado, fecha_pago_efectivo, metodo_pago, folio_pago, comentarios) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_cuenta, $nuevo_monto_pagado, $fecha_pago_efectivo, $metodo_pago, $folio_pago, $comentarios]);
    }

    $conn->commit();
    echo json_encode(["success" => true, "message" => "Pago registrado con éxito."]);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["success" => false, "message" => "Error al registrar el pago: " . $e->getMessage()]);
}
?>
