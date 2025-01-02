<?php

include '../config.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$pathInfo = isset($_GET['id']) ? $_GET['id'] : null;

switch ($requestMethod) {
    case 'POST': // Create a new recipe
        $data = json_decode(file_get_contents('php://input'), true);

        $name = $data['name'] ?? null;
        $chef = $data['chef'] ?? null;
        $preparation_time = $data['preparation_time'] ?? null;
        $preparation_steps = $data['preparation_steps'] ?? null;
        $allergens = isset($data['allergens']) ? json_encode($data['allergens']) : null;
        $cuisine = $data['cuisine'] ?? null;
        $dietary_info = isset($data['dietary_info']) ? json_encode($data['dietary_info']) : null;

        if (!$name || !$preparation_time || !$preparation_steps) {
            echo json_encode(['error' => 'Name, preparation time, and preparation steps are required']);
            http_response_code(400); // Bad Request
            exit;
        }

        try {
            $stmt = $conn->prepare("INSERT INTO recipes (name, chef, preparation_time, preparation_steps, allergens, cuisine, dietary_info)
                                    VALUES (:name, :chef, :preparation_time, :preparation_steps, :allergens, :cuisine, :dietary_info)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':chef', $chef);
            $stmt->bindParam(':preparation_time', $preparation_time);
            $stmt->bindParam(':preparation_steps', $preparation_steps);
            $stmt->bindParam(':allergens', $allergens);
            $stmt->bindParam(':cuisine', $cuisine);
            $stmt->bindParam(':dietary_info', $dietary_info);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Recipe created successfully', 'recipe_id' => $conn->lastInsertId()]);
            } else {
                echo json_encode(['error' => 'Failed to create recipe']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
            http_response_code(500);
        }
        break;

    case 'GET': // Retrieve recipes
        if ($pathInfo) { // Get single recipe
            try {
                $stmt = $conn->prepare("SELECT * FROM recipes WHERE id = :id");
                $stmt->bindParam(':id', $pathInfo);
                $stmt->execute();
                $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($recipe) {
                    echo json_encode($recipe);
                } else {
                    echo json_encode(['error' => 'Recipe not found']);
                    http_response_code(404);
                }
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
                http_response_code(500);
            }
        } else { // Get all recipes
            try {
                $stmt = $conn->prepare("SELECT id, name, chef, cuisine FROM recipes");
                $stmt->execute();
                $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($recipes);
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
                http_response_code(500);
            }
        }
        break;

    case 'PUT': // Update a recipe
        if (!$pathInfo) {
            echo json_encode(['error' => 'Recipe ID is required']);
            http_response_code(400);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? null;
        $chef = $data['chef'] ?? null;
        $preparation_time = $data['preparation_time'] ?? null;
        $preparation_steps = $data['preparation_steps'] ?? null;
        $allergens = isset($data['allergens']) ? json_encode($data['allergens']) : null;
        $cuisine = $data['cuisine'] ?? null;
        $dietary_info = isset($data['dietary_info']) ? json_encode($data['dietary_info']) : null;

        try {
            $stmt = $conn->prepare("UPDATE recipes SET 
                                    name = :name, 
                                    chef = :chef, 
                                    preparation_time = :preparation_time,
                                    preparation_steps = :preparation_steps,
                                    allergens = :allergens,
                                    cuisine = :cuisine,
                                    dietary_info = :dietary_info
                                    WHERE id = :id");
            $stmt->bindParam(':id', $pathInfo);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':chef', $chef);
            $stmt->bindParam(':preparation_time', $preparation_time);
            $stmt->bindParam(':preparation_steps', $preparation_steps);
            $stmt->bindParam(':allergens', $allergens);
            $stmt->bindParam(':cuisine', $cuisine);
            $stmt->bindParam(':dietary_info', $dietary_info);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Recipe updated successfully']);
            } else {
                echo json_encode(['error' => 'Failed to update recipe']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
            http_response_code(500);
        }
        break;

    case 'DELETE': // Delete a recipe
        if (!$pathInfo) {
            echo json_encode(['error' => 'Recipe ID is required']);
            http_response_code(400);
            exit;
        }

        try {
            $stmt = $conn->prepare("DELETE FROM recipes WHERE id = :id");
            $stmt->bindParam(':id', $pathInfo);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Recipe deleted successfully']);
            } else {
                echo json_encode(['error' => 'Failed to delete recipe']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
            http_response_code(500);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid request method']);
        http_response_code(405); // Method Not Allowed
        break;
}

?>
