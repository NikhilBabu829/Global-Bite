<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Global Bite</title>
  <link rel="stylesheet" href="../StyleSheets/loginPage.css">
</head>
<body>
<main class="mainContentLogin">
    <div class="login-container">
        <!-- Welcome Message -->
        <header class="login-header">
            <h1>Welcome Back</h1>
            <p>Log in to continue exploring delicious recipes.</p>
        </header>
        <!-- Login Form -->
        <form class="login-form" action="../../../backend/routes/login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <div class="form-options">
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit" class="login-button">Log In</button>
        </form>
        <!-- Footer -->
        <footer class="login-footer">
            <p>Don't have an account? <a href="./signup.php">Sign up now</a></p>
        </footer>
    </div>
</main>
</body>
</html>
