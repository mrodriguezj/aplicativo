<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../config/conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["nombre"], $data["apellido_paterno"], $data["correo_electronico"], $data["telefono"])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    exit();
}

$db = new Database();
$conn = $db->getConnection();

if (!$conn) {
    echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos."]);
    exit();
}

$stmt = $conn->prepare("CALL sp_insertar_cliente(?, ?, ?, ?, ?)");
$success = $stmt->execute([
    $data["nombre"],
    $data["apellido_paterno"],
    $data["apellido_materno"] ?? null,
    $data["correo_electronico"],
    $data["telefono"]
]);

echo json_encode(["success" => $success, "message" => $success ? "Cliente registrado con éxito." : "Error al registrar el cliente."]);
?>
