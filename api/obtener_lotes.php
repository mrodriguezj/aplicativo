<?php
require_once "../config/conexion.php";

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_listar_lotes_disponibles()");
$stmt->execute();
$lotes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($lotes);
?>
