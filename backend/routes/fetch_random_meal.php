<?php
session_start();
include './backend/helper/sessionCheck.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../../frontend/src/pages/login.php");
    exit;
}

// Define the API endpoint
$apiUrl = "https://www.themealdb.com/api/json/v1/1/random.php";

try {
    // Fetch data from the API
    $response = file_get_contents($apiUrl);

    // Decode the JSON response
    $mealData = json_decode($response, true);

    // Extract meal details
    if (isset($mealData['meals'][0])) {
        $meal = $mealData['meals'][0];
    } else {
        throw new Exception("Failed to fetch meal data.");
    }
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Meal</title>
    <link rel="stylesheet" href="../../frontend/src/StyleSheets/styleRandomMeal.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="../../index.php">Global Bite</a>
        <ul class="nav-links">
          <li><a href="../../frontend/src/pages/about.php">About</a></li>
          <li><a href="../../frontend/src/pages/login.php" class="btn-login">Login</a></li>
        </ul>
    </nav>

    <!-- Page Content -->
    <header>
        <h1>Your Random Meal</h1>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php else: ?>
            <article class="recipeCard">
                <h2><?php echo htmlspecialchars($meal['strMeal']); ?></h2>
                <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($meal['strArea']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($meal['strCategory']); ?></p>
                <p><strong>Instructions:</strong> <?php echo htmlspecialchars($meal['strInstructions']); ?></p>
                <img src="<?php echo htmlspecialchars($meal['strMealThumb']); ?>" alt="<?php echo htmlspecialchars($meal['strMeal']); ?>" style="max-width: 300px; border-radius: 8px;">
                <p><strong>Ingredients:</strong></p>
                <ul>
                    <?php for ($i = 1; $i <= 20; $i++): ?>
                        <?php if (!empty($meal["strIngredient$i"])): ?>
                            <li><?php echo htmlspecialchars($meal["strIngredient$i"] . " - " . $meal["strMeasure$i"]); ?></li>
                        <?php endif; ?>
                    <?php endfor; ?>
                </ul>
            </article>
        <?php endif; ?>
        <a href="fetch_random_meal.php">Get Another Random Meal</a>
    </main>
</body>
</html>
