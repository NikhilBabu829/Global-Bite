<?php
session_start();
include '../config.php';

header('Access-Control-Allow-Origin: *'); // Replace '*' with your frontend URL in production
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request for login
    // Retrieve input data
    $data = json_decode(file_get_contents('php://input'), true);

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$email || !$password) {
        echo json_encode(['error' => 'Email and password are required']);
        http_response_code(400); // Bad Request
        exit;
    }

    try {
        // Check if the user exists
        $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Generate a basic session token (replace with JWT for production)
            $token = base64_encode(random_bytes(30));
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['logged_in_time'] = time();
            // Return success response
            echo json_encode([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'email' => $email
                ],
                'token' => $token
            ]);

            header("Location: ../../index.php");

        } else {
            echo json_encode(['error' => 'Invalid email or password']);
            http_response_code(401); // Unauthorized
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error']);
        http_response_code(500); // Internal Server Error
    }
} 
// elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     // Handle GET request for token validation
//     // Retrieve the token from headers
//     $headers = getallheaders();
//     $token = $headers['Authorization'] ?? null;

//     if (!$token) {
//         echo json_encode(['error' => 'Token is required']);
//         http_response_code(401); // Unauthorized
//         exit;
//     }

//     try {
//         // Decode and validate token (example logic, replace with JWT validation in production)
//         $decodedToken = base64_decode($token);
//         if (!$decodedToken) {
//             echo json_encode(['error' => 'Invalid token']);
//             http_response_code(401); // Unauthorized
//             exit;
//         }

//         // Fetch user data based on token/session (example logic)
//         $userId = 1; // Placeholder for extracted user ID

//         $stmt = $conn->prepare("SELECT id, full_name, email, dietary_preferences FROM users WHERE id = :id");
//         $stmt->bindParam(':id', $userId);
//         $stmt->execute();
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($user) {
//             if (!empty($user['dietary_preferences'])) {
//                 $user['dietary_preferences'] = json_decode($user['dietary_preferences']);
//             }
        
//             echo json_encode([
//                 'message' => 'User is logged in',
//                 'user' => $user
//             ]);
//         } else {
//             echo json_encode(['error' => 'User not found']);
//             http_response_code(404); // Not Found
//         }
//     } catch (Exception $e) {
//         echo json_encode(['error' => 'Internal server error']);
//         http_response_code(500); // Internal Server Error
//     }
// } else {
//     echo json_encode(['error' => 'Invalid request method']);
//     http_response_code(405); // Method Not Allowed
// }
?>