<?php
require_once "../config/conexion.php";

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_listar_clientes()");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($clientes);
?>
