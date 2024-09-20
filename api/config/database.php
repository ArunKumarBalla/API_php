<?php
class Database {
    private $host = 'sql12.freemysqlhosting.net';
    private $db_name = 'sql12731804';
    private $username = 'sql12731804';
    private $password = 'LWIs8RJEs9';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Connection Error: ' . $e->getMessage()]);
        }

        return $this->conn;
    }
}
?>
