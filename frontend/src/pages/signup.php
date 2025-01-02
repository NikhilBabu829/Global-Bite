<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Global Bite</title>
  <link rel="stylesheet" href="../StyleSheets/signupPage.css">
</head>
<body>

<!-- Signup Page Container -->
<main class="mainContentSignUp">

  <div class="signup-container">

    <!-- Logo and Welcome Message -->
  <header class="signup-header">
    <!-- <img src="https://via.placeholder.com/150x50?text=Recipe+Hub" alt="Recipe Hub Logo" class="logo"> -->
    <h2>Join Recipe Hub</h2>
    <p>Create an account to save your favorite recipes and get personalized recommendations.</p>
  </header>

  <!-- Signup Form -->
  <form class="signup-form" id="signupForm" action="../../../backend/routes/signup.php" method="POST">

    <!-- Full Name Field -->
    <label for="full-name">Full Name</label>
    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>

    <!-- Email Field -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <!-- Password Field -->
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Create a password" required>
    
    <!-- Confirm Password Field -->
    <label for="confirm-password">Confirm Password</label>
    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>

    <!-- Dietary Preferences Dropdown -->
    <label for="dietary-preferences">Dietary Preferences</label>
    <div class="dropdown">
      <!-- Hidden Checkbox to Control Dropdown Display -->
      <input type="checkbox" id="dropdown-toggle" class="dropdown-toggle">
      <label for="dropdown-toggle" class="dropdown-label">Select Preferences</label>
      
      <div class="dropdown-menu">
        <!-- General Diet Types -->
        <label><input type="checkbox" name="dietary" value="vegetarian"> Vegetarian</label>
        <label><input type="checkbox" name="dietary" value="vegan"> Vegan</label>
        <label><input type="checkbox" name="dietary" value="pescatarian"> Pescatarian</label>
        <label><input type="checkbox" name="dietary" value="flexitarian"> Flexitarian</label>

        <!-- Medical & Allergen-Specific Diets -->
        <label><input type="checkbox" name="dietary" value="gluten-free"> Gluten-Free</label>
        <label><input type="checkbox" name="dietary" value="dairy-free"> Dairy-Free</label>
        <label><input type="checkbox" name="dietary" value="nut-free"> Nut-Free</label>
        <label><input type="checkbox" name="dietary" value="egg-free"> Egg-Free</label>
        <label><input type="checkbox" name="dietary" value="soy-free"> Soy-Free</label>
        <label><input type="checkbox" name="dietary" value="shellfish-free"> Shellfish-Free</label>
        <label><input type="checkbox" name="dietary" value="sesame-free"> Sesame-Free</label>

        <!-- Health & Lifestyle Diets -->
        <label><input type="checkbox" name="dietary" value="keto"> Keto</label>
        <label><input type="checkbox" name="dietary" value="paleo"> Paleo</label>
        <label><input type="checkbox" name="dietary" value="low-carb"> Low-Carb</label>
        <label><input type="checkbox" name="dietary" value="low-fat"> Low-Fat</label>
        <label><input type="checkbox" name="dietary" value="whole30"> Whole30</label>
        <label><input type="checkbox" name="dietary" value="mediterranean"> Mediterranean</label>
        <label><input type="checkbox" name="dietary" value="raw-food"> Raw Food</label>

        <!-- Religious & Cultural Dietary Restrictions -->
        <label><input type="checkbox" name="dietary" value="halal"> Halal</label>
        <label><input type="checkbox" name="dietary" value="kosher"> Kosher</label>

        <!-- Other Dietary Needs -->
        <label><input type="checkbox" name="dietary" value="fodmap"> Low FODMAP</label>
        <label><input type="checkbox" name="dietary" value="diabetic-friendly"> Diabetic-Friendly</label>
        <label><input type="checkbox" name="dietary" value="high-protein"> High-Protein</label>
      </div>
    </div>

    <!-- Agree to Terms Checkbox -->
    <div class="terms">
      <input type="checkbox" id="agree-terms" name="agree-terms" required>
      <label for="agree-terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
    </div>

    <!-- Sign Up Button -->
    <button type="submit" class="signup-button">Sign Up</button>

  </form>

  <!-- Footer Links -->
  <footer class="signup-footer">
    <p>Already have an account? <a href="./login.php">Log in</a></p>
    <p><a href="#">Help</a> | <a href="#">Contact Support</a></p>
  </footer>

  </div>

</main>
</body>
</html>
