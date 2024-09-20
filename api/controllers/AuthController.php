<?php
require_once '../models/User.php';

class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register a new user
    public function register($data) {
        $user = new User($this->conn);
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        if ($user->register()) {
            return ['status' => 'success', 'message' => 'User registered successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Registration failed'];
        }
    }

    // Login user
    public function login($data) {
        $user = new User($this->conn);
        $user->email = $data['email'];
        $user->password = $data['password'];

        if ($user->login()) {
            return ['status' => 'success', 'message' => 'Login successful', 'user' => ['id' => $user->id, 'username' => $user->username]];
        } else {
            return ['status' => 'error', 'message' => 'Invalid credentials'];
        }
    }
}
?>
