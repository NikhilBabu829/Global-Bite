<?php
include '../config.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Retrieve the token from headers
$headers = getallheaders();
$token = $headers['Authorization'] ?? null;

// Function to validate token and get user ID
function getUserFromToken($token, $conn) {
    if (!$token) {
        echo json_encode(['error' => 'Authorization token is required']);
        http_response_code(401); // Unauthorized
        exit;
    }

    try {
        $decodedToken = base64_decode($token);
        if (!$decodedToken) {
            echo json_encode(['error' => 'Invalid token']);
            http_response_code(401); // Unauthorized
            exit;
        }

        // Replace with actual logic to extract user ID from token
        $userId = 1; // Placeholder
        return $userId;
    } catch (Exception $e) {
        echo json_encode(['error' => 'Invalid token']);
        http_response_code(401); // Unauthorized
        exit;
    }
}

// Handle routes
if (preg_match('/^\/recipes\/(\d+)\/reviews$/', $requestUri, $matches) && $requestMethod === 'POST') {
    // Add a review
    $recipeId = $matches[1];
    $userId = getUserFromToken($token, $conn);

    $data = json_decode(file_get_contents('php://input'), true);
    $rating = $data['rating'] ?? null;
    $description = $data['description'] ?? null;

    if (!$rating || $rating < 1 || $rating > 5) {
        echo json_encode(['error' => 'Rating is required and must be between 1 and 5']);
        http_response_code(400); // Bad Request
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO reviews (recipe_id, user_id, rating, description)
                                VALUES (:recipe_id, :user_id, :rating, :description)");
        $stmt->bindParam(':recipe_id', $recipeId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Review added successfully']);
        } else {
            echo json_encode(['error' => 'Failed to add review']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} elseif (preg_match('/^\/recipes\/(\d+)\/reviews$/', $requestUri, $matches) && $requestMethod === 'GET') {
    // Retrieve all reviews for a recipe
    $recipeId = $matches[1];

    try {
        $stmt = $conn->prepare("SELECT r.id, r.rating, r.description, u.full_name AS reviewer, r.created_at
                                FROM reviews r
                                JOIN users u ON r.user_id = u.id
                                WHERE r.recipe_id = :recipe_id");
        $stmt->bindParam(':recipe_id', $recipeId);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($reviews);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} elseif (preg_match('/^\/reviews\/(\d+)$/', $requestUri, $matches) && $requestMethod === 'PUT') {
    // Update a specific review
    $reviewId = $matches[1];
    $userId = getUserFromToken($token, $conn);

    $data = json_decode(file_get_contents('php://input'), true);
    $rating = $data['rating'] ?? null;
    $description = $data['description'] ?? null;

    if (!$rating || $rating < 1 || $rating > 5) {
        echo json_encode(['error' => 'Rating is required and must be between 1 and 5']);
        http_response_code(400); // Bad Request
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE reviews SET rating = :rating, description = :description
                                WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $reviewId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Review updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update review']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} elseif (preg_match('/^\/reviews\/(\d+)$/', $requestUri, $matches) && $requestMethod === 'DELETE') {
    // Delete a specific review
    $reviewId = $matches[1];
    $userId = getUserFromToken($token, $conn);

    try {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $reviewId);
        $stmt->bindParam(':user_id', $userId);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Review deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete review']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} else {
    echo json_encode(['error' => 'Route not found']);
    http_response_code(404);
}
?>
