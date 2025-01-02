<?php
$host = 'sql200.infinityfree.com'; // Your database host
$dbname = 'if0_38027862_globalbite'; // Your database name
$username = 'if0_38027862'; // Your database username
$password = '05101970Host123 '; // Your database password (leave blank if no password)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

