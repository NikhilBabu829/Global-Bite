<?php
include '../config.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Function to validate input
function validateInput($data, $fields) {
    foreach ($fields as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}

// Handle the requests
if (preg_match('/^\/categories$/', $requestUri) && $requestMethod === 'POST') {
    // Create a new category
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'] ?? null;

    if (!$name) {
        echo json_encode(['error' => 'Category name is required']);
        http_response_code(400); // Bad Request
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $name);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Category created successfully', 'category_id' => $conn->lastInsertId()]);
        } else {
            echo json_encode(['error' => 'Failed to create category']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} elseif (preg_match('/^\/categories$/', $requestUri) && $requestMethod === 'GET') {
    // Retrieve all categories
    try {
        $stmt = $conn->prepare("SELECT id, name FROM categories");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($categories);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        http_response_code(500);
    }
} elseif (preg_match('/^\/recipes\/(\d+)\/categories$/', $requestUri, $matches)) {
    $recipeId = $matches[1];

    if ($requestMethod === 'POST') {
        // Assign categories to a recipe
        $data = json_decode(file_get_contents('php://input'), true);
        $categories = $data['categories'] ?? null;

        if (!$categories || !is_array($categories)) {
            echo json_encode(['error' => 'Categories array is required']);
            http_response_code(400); // Bad Request
            exit;
        }

        try {
            $stmt = $conn->prepare("INSERT INTO recipe_categories (recipe_id, category_id) VALUES (:recipe_id, :category_id)");
            foreach ($categories as $categoryId) {
                $stmt->bindParam(':recipe_id', $recipeId);
                $stmt->bindParam(':category_id', $categoryId);
                $stmt->execute();
            }

            echo json_encode(['message' => 'Categories assigned successfully']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
            http_response_code(500);
        }
    } elseif ($requestMethod === 'GET') {
        // Retrieve categories for a specific recipe
        try {
            $stmt = $conn->prepare("
                SELECT c.id, c.name
                FROM categories c
                JOIN recipe_categories rc ON c.id = rc.category_id
                WHERE rc.recipe_id = :recipe_id
            ");
            $stmt->bindParam(':recipe_id', $recipeId);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($categories);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
            http_response_code(500);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
        http_response_code(405); // Method Not Allowed
    }
} else {
    echo json_encode(['error' => 'Route not found']);
    http_response_code(404); // Not Found
}
?>
