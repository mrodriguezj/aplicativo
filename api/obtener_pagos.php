<?php
require_once "../config/conexion.php";

$estado = isset($_GET["estado"]) ? $_GET["estado"] : NULL;

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_listar_pagos(?)");
$stmt->execute([$estado]);
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($pagos);
?>
