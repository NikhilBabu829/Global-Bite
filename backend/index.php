<?php

$request = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch (true) {
    // User-related routes
    case $request === '/users/login' && $requestMethod === 'POST':
        require 'routes/login.php';
        break;

    case $request === '/users/signup' && $requestMethod === 'POST':
        require 'routes/signup.php';
        break;

    // Recipe-related routes
    case $request === '/recipes' && $requestMethod === 'GET':
        require 'routes/recipes.php';
        handleRecipes('GET');
        break;

    case $request === '/recipes' && $requestMethod === 'POST':
        require 'routes/recipes.php';
        handleRecipes('POST');
        break;

    case preg_match('/^\/recipes\/(\d+)$/', $request, $matches) && $requestMethod === 'GET':
        $_GET['id'] = $matches[1];
        require 'routes/recipes.php';
        handleRecipes('GET_SINGLE');
        break;

    case preg_match('/^\/recipes\/(\d+)$/', $request, $matches) && $requestMethod === 'PUT':
        $_GET['id'] = $matches[1];
        require 'routes/recipes.php';
        handleRecipes('PUT');
        break;

    case preg_match('/^\/recipes\/(\d+)$/', $request, $matches) && $requestMethod === 'DELETE':
        $_GET['id'] = $matches[1];
        require 'routes/recipes.php';
        handleRecipes('DELETE');
        break;
    
    // Category routes
    case $request === '/categories' && $requestMethod === 'POST':
        require 'routes/categories.php';
        break;

    case $request === '/categories' && $requestMethod === 'GET':
        require 'routes/categories.php';
        break;

    case preg_match('/^\/recipes\/(\d+)\/categories$/', $request, $matches) && $requestMethod === 'POST':
        $_GET['id'] = $matches[1];
        require 'routes/categories.php';
        break;

    case preg_match('/^\/recipes\/(\d+)\/categories$/', $request, $matches) && $requestMethod === 'GET':
        $_GET['id'] = $matches[1];
        require 'routes/categories.php';
        break;

    // Ingredient routes
    case preg_match('/^\/recipes\/(\d+)\/reviews$/', $request, $matches) && $requestMethod === 'POST':
        $_GET['id'] = $matches[1];
        require 'routes/reviews.php';
        break;
    
    case preg_match('/^\/recipes\/(\d+)\/reviews$/', $request, $matches) && $requestMethod === 'GET':
        $_GET['id'] = $matches[1];
        require 'routes/reviews.php';
        break;
    
    case preg_match('/^\/reviews\/(\d+)$/', $request, $matches) && $requestMethod === 'PUT':
        $_GET['id'] = $matches[1];
        require 'routes/reviews.php';
        break;
    
    case preg_match('/^\/reviews\/(\d+)$/', $request, $matches) && $requestMethod === 'DELETE':
        $_GET['id'] = $matches[1];
        require 'routes/reviews.php';
        break;
        

    // Default route for unmatched requests
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        break;
}

?>
