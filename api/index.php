<?php
require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'views/response.php';

// Initialize DB connection
$database = new Database();
$db = $database->connect();

// Create AuthController instance
$authController = new AuthController($db);

// Get request method and input data
$request_method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

// Route the request
if ($request_method === 'POST') {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'register') {
            // Call register method
            $result = $authController->register($input);
            jsonResponse($result);
        } elseif ($_GET['action'] === 'login') {
            // Call login method
            $result = $authController->login($input);
            jsonResponse($result);
        } else {
            jsonResponse(['status' => 'error', 'message' => 'Invalid action']);
        }
    } else {
        jsonResponse(['status' => 'error', 'message' => 'Action not specified']);
    }
} else {
    jsonResponse(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
