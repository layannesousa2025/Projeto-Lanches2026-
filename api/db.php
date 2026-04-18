<?php
// api/db.php - Database connection using PDO

$host = '127.0.0.1'; // Use IP instead of 'localhost' for better compatibility
$db   = 'hero_burgers';
$port = '3306'; // Default MySQL port
$user = 'root';
$pass = ''; // Default XAMPP/WAMP password is empty
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Return JSON error if connection fails
     header('Content-Type: application/json; charset=utf-8');
     http_response_code(500);
     echo json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados.']);
     exit();
}
?>
