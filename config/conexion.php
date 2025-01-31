<?php
class Database {
    private $host = "srv1281.hstgr.io";  // Cambiar si el host es diferente
    private $db_name = "u451524807_app_cobranza1"; // Nombre de la base de datos
    private $username = "u451524807_B0nat3rraCl0ud"; // Usuario de la BD
    private $password = "hola+2025+ROJM"; // Contraseña de la BD
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES utf8mb4"); // Soporte para caracteres especiales
        } catch (PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage(), 0);
            die("Error de conexión con la base de datos. Intente más tarde.");
        }

        return $this->conn;
    }
}
?>
