<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../config/conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    die(json_encode(["success" => false, "message" => "Error: No se recibieron datos."]));
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Iniciar la transacción
    $conn->beginTransaction();

    // Insertar la venta en la tabla 'ventas'
    $stmt = $conn->prepare("INSERT INTO ventas (id_cliente, id_lote, precio_venta, tipo_venta, fecha_venta, tipo_pago)
                            VALUES (?, ?, ?, ?, NOW(), ?)");
    $stmt->execute([
        $data["id_cliente"],
        $data["id_lote"],
        $data["precio_venta"],
        $data["tipo_venta"],
        ($data["tipo_venta"] === "contado" ? "contado" : "enganche")
    ]);

    // Obtener el ID de la venta recién insertada
    $id_venta = $conn->lastInsertId();

    // Insertar pagos en 'cuentas_por_cobrar' según el tipo de venta
    if ($data["tipo_venta"] === "contado") {
        for ($i = 0; $i < $data["num_pagos_contado"]; $i++) {
            $fecha_pago = date('Y-m-d', strtotime("+$i month", strtotime($data["fecha_pago_contado"])));
            $stmt = $conn->prepare("INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
                                    VALUES (?, ?, ?, ?, ?, 'contado', 'pendiente')");
            $stmt->execute([$id_venta, $data["id_cliente"], $data["id_lote"], $data["monto_pago_contado"], $fecha_pago]);
        }
    } else {
        // Insertar pagos de enganche
        for ($i = 0; $i < $data["num_enganche"]; $i++) {
            $fecha_pago = date('Y-m-d', strtotime("+$i month", strtotime($data["fecha_enganche"])));
            $stmt = $conn->prepare("INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
                                    VALUES (?, ?, ?, ?, ?, 'enganche', 'pendiente')");
            $stmt->execute([$id_venta, $data["id_cliente"], $data["id_lote"], $data["monto_enganche"], $fecha_pago]);
        }

        // Insertar pagos de mensualidad
        for ($i = 0; $i < $data["num_mensualidades"]; $i++) {
            $fecha_pago = date('Y-m-d', strtotime("+$i month", strtotime($data["fecha_mensualidad"])));
            $stmt = $conn->prepare("INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
                                    VALUES (?, ?, ?, ?, ?, 'mensualidad', 'pendiente')");
            $stmt->execute([$id_venta, $data["id_cliente"], $data["id_lote"], $data["monto_mensualidad"], $fecha_pago]);
        }

        // Insertar pagos de anualidad
        for ($i = 0; $i < $data["num_anualidades"]; $i++) {
            $fecha_pago = date('Y-m-d', strtotime("+$i year", strtotime($data["fecha_anualidad"])));
            $stmt = $conn->prepare("INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
                                    VALUES (?, ?, ?, ?, ?, 'anualidad', 'pendiente')");
            $stmt->execute([$id_venta, $data["id_cliente"], $data["id_lote"], $data["monto_anualidad"], $fecha_pago]);
        }
    }

    // Actualizar el estado de la propiedad vendida
    $stmt = $conn->prepare("UPDATE propiedades SET disponibilidad = 'vendido' WHERE id_lote = ?");
    $stmt->execute([$data["id_lote"]]);

    // Confirmar la transacción
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Venta registrada con éxito y lote marcado como vendido."]);

} catch (Exception $e) {
    // Si hay un error, revertir la transacción
    $conn->rollBack();
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
