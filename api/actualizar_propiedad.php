<?php
require_once "../config/conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_actualizar_propiedad(?, ?, ?, ?, ?, ?)");
$success = $stmt->execute([
    $data["id_lote"],
    $data["dimensiones"],
    $data["precio"],
    $data["tipo"],
    $data["disponibilidad"],
    $data["observaciones"]
]);

echo json_encode(["success" => $success, "message" => $success ? "Propiedad actualizada correctamente." : "Error al actualizar."]);
?>
