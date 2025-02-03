<?php
require_once "../config/conexion.php";

$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->prepare("UPDATE cuentas_por_cobrar 
                            SET estado_pago = 'vencido' 
                            WHERE estado_pago = 'pendiente' AND fecha_pago < CURDATE()");
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Pagos vencidos actualizados."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>
