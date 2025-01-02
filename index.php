<?php
session_start();
include './backend/config.php';
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Bite</title>
    <link rel="stylesheet" href="./frontend/src/StyleSheets/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <nav class="navbar">
        <a href="./index.php">Global Bite</a>
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

    <header class="headerForIndex">
            <h1>Cook Globally, Eat Personally - Recipes Made Just for You!</h1>
            <p>Explore a world of flavors with recipes tailored to your ingredients, dietary needs, and personal tastes. From cherished family dishes to new culinary adventures, find meals crafted just for you, wherever you are!</p>
            <a href="./backend/routes/recipe.php">Start Exlporing</a>
    </header>

    <main>
        <section class="random-meal">
            <h2>Get Suggested a Random Meal Right Now!!</h2>
            <form action="./backend/routes/random_meal.php">
                <button class="random-meal-btn">Surprise Me!</button>
            </form>
        </section>

        <section class="testimonials">
            <h2>What Our Users Say</h2>
            <figure class="testimonial">
              <blockquote>"The recipes here are incredible! Perfect for quick family dinners."</blockquote>
              <figcaption>- Emily R.</figcaption>
            </figure>
            <figure class="testimonial">
              <blockquote>"My go-to site for healthy and delicious recipes. Highly recommended!"</blockquote>
              <figcaption>- James K.</figcaption>
            </figure>
            <figure class="testimonial">
                <blockquote>"This platform has transformed the way I cook! I love the ingredient-based search feature."</blockquote>
                <figcaption>- Sarah T.</figcaption>
            </figure>
            
            <figure class="testimonial">
                <blockquote>"The recipes here are so easy to follow. Even as a beginner, I've impressed my family with my cooking!"</blockquote>
                <figcaption>- David M.</figcaption>
            </figure>
            
            <figure class="testimonial">
                <blockquote>"I appreciate how inclusive this site is. It caters perfectly to my dietary restrictions."</blockquote>
                <figcaption>- Priya R.</figcaption>
            </figure>
            <figure class="testimonial">
                <blockquote>"The random meal suggestion feature has been a lifesaver on busy days. Highly innovative!"</blockquote>
                <figcaption>- Emily H.</figcaption>
            </figure>
            
            <figure class="testimonial">
                <blockquote>"A treasure trove of culinary inspiration. The personalized recommendations are spot on!"</blockquote>
                <figcaption>- Alex W.</figcaption>
            </figure>
        </section>

        <section class="sign-up-cta">
            <h2>Join Our Community</h2>
            <p>Save your favorite recipes, share your own, and get personalized meal suggestions.</p>
            <a href="./frontend/src/pages/signup.php" class="sign-up-button">Sign Up Now</a>
        </section>
        
    </main>

    <footer class="footerNavigation">
        <nav aria-label="Footer navigation">
            <ul class="footer-links">
              <li><a href="./frontend/src/pages/about.php">About Us</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>
          </nav>
    </footer>

</body>
</html>