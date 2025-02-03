<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../config/conexion.php";

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("CALL sp_suma_pagos()");
if (!$stmt->execute()) {
    die(json_encode(["success" => false, "message" => "Error al ejecutar el procedimiento.", "error" => $stmt->errorInfo()]));
}

$sumas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$sumas) {
    die(json_encode(["success" => false, "message" => "No se encontraron datos en la base de datos."]));
}

echo json_encode($sumas);
?>
