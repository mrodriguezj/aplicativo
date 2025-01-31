<?php
require_once "../config/conexion.php";

if (isset($_GET["id_lote"])) {
    $id_lote = $_GET["id_lote"];

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("CALL sp_obtener_propiedad(?)");
    $stmt->execute([$id_lote]);
    $propiedad = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($propiedad) {
        echo json_encode(["success" => true] + $propiedad);
    } else {
        echo json_encode(["success" => false, "message" => "Lote no encontrado."]);
    }
}
?>
