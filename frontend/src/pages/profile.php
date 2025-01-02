<?php
// Start the session
session_start();

include '../../.././backend/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Fetch the logged-in user's details
try {
    $stmt = $pdo->prepare("SELECT full_name, email, dietary_preferences, created_at FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
} catch (PDOException $e) {
    die("Failed to fetch user details: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .profile {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            max-width: 500px;
            margin: auto;
        }
        .profile h1 {
            text-align: center;
        }
        .profile p {
            margin: 10px 0;
        }
        .profile strong {
            display: inline-block;
            width: 150px;
        }
        .json-content {
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="profile">
        <h1>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Dietary Preferences:</strong> 
            <span class="json-content"><?php echo htmlspecialchars($user['dietary_preferences'] ?? '{}'); ?></span>
        </p>
        <p><strong>Account Created:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
    </div>
</body>
</html>
