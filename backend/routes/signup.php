<?php

include '../config.php';

header('Access-Control-Allow-Origin: *'); // Replace '*' with your frontend URL in production
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract values with null checks
    $full_name = $_POST['full_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $dietary_preferences = isset($_POST['dietary_preferences']) ? json_encode($_POST['dietary_preferences']) : null;

    // Validate input
    if (!$full_name || !$email || !$password) {
        echo json_encode(['error' => 'Full name, email, and password are required']);
        http_response_code(400); // Bad Request
        exit;
    }

    try {
        // Check if email already exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // Email already exists
            echo json_encode(['error' => 'Email is already registered']);
            http_response_code(409); // Conflict
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, dietary_preferences) VALUES (:full_name, :email, :password, :dietary_preferences)");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':dietary_preferences', $dietary_preferences);

        if ($stmt->execute()) {
            header('Location: ../../index.html');
            echo json_encode(['message' => 'User registered successfully']);
        } else {
            echo json_encode(['error' => 'Registration failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500); // Internal Server Error
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
    http_response_code(405); // Method Not Allowed
}

?>
