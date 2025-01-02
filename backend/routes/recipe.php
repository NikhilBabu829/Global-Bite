<?php
session_start();
include '../config.php';
$isLoggedIn = isset($_SESSION['user_id']);
// Fetch all recipes
try {
    $stmt = $conn->query("SELECT id, name, chef, preparation_time, preparation_steps, allergens, cuisine, dietary_info, created_at FROM recipes");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch recipes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Page</title>
    <link rel="stylesheet" href="../../frontend/src/StyleSheets/style.css">
    <link rel="stylesheet" href="../../frontend/src/StyleSheets/recipePage.css">
</head>
<body>
    <nav class="navbar">
        <a href="../../index.php">Global Bite</a>
        <ul class="nav-links">
            <li><a href="./frontend/src/pages/about.php">About</a></li>
            <?php if (!$isLoggedIn): ?>
                <li><a href="./frontend/src/pages/login.php" class="btn-login">Login</a></li>
            <?php else: ?>
                <li><a href="./frontend/src/pages/profile.php">Profile</a></li>
                <li><a href="./backend/routes/logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <h1>Recipe Collection</h1>
    <div class="container">
        <?php if (!empty($recipes)): ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card">
                        <div class="recipe-header"><?php echo htmlspecialchars($recipe['name']); ?></div>
                        <div class="recipe-content">
                            <p><strong>Chef:</strong> <?php echo htmlspecialchars($recipe['chef'] ?? 'Unknown'); ?></p>
                            <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($recipe['cuisine'] ?? 'Unspecified'); ?></p>
                            <p><strong>Preparation Time:</strong> <?php echo htmlspecialchars($recipe['preparation_time']); ?> minutes</p>
                            <p><strong>Preparation Steps:</strong> <?php echo nl2br(htmlspecialchars($recipe['preparation_steps'])); ?></p>
                            <p><strong>Allergens:</strong> 
                                <span class="json-content"><?php echo htmlspecialchars($recipe['allergens'] ?? '{}'); ?></span>
                            </p>
                            <p><strong>Dietary Info:</strong> 
                                <span class="json-content"><?php echo htmlspecialchars($recipe['dietary_info'] ?? '{}'); ?></span>
                            </p>
                            <p><strong>Created At:</strong> <?php echo htmlspecialchars($recipe['created_at']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #6c757d;">No recipes found.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        &copy; <?php echo date('Y'); ?> GLobal Bite. All rights reserved.
    </div>
</body>
</html>
