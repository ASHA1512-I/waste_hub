<?php
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'wastehub';
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$isLocalHost = in_array(strtolower($_SERVER['SERVER_NAME'] ?? ''), ['localhost', '127.0.0.1'], true);

if ($username === false && $password === false && $isLocalHost) {
    $username = 'root';
    $password = '';
}

if ($username === false || $password === false) {
    error_log('Database credentials are not configured.');
    http_response_code(500);
    exit('Service temporarily unavailable.');
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Service temporarily unavailable.');
}
?>