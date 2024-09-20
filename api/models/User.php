<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register a new user
    public function register() {
        $query = "INSERT INTO " . $this->table . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // Bind parameters
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Login user
    public function login() {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);

        // Bind email
        $stmt->bindParam(':email', $this->email);

        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                return true;
            }
        }

        return false;
    }
}
?>
