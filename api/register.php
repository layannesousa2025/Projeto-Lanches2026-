<?php
// Define base CORS and session parameters
session_start();
header('Access-Control-Allow-Origin: *'); // Note: In production, sessions with CORS need specific origin and credentials
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit();
}

require_once 'db.php';

// Get POST data
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

// Basic validation
if (empty($name) || empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.'], JSON_UNESCAPED_UNICODE);
    exit();
}

try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        http_response_code(409); // Conflict
        echo json_encode(['success' => false, 'message' => 'Este e-mail já está cadastrado.'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Create new user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
    
    if ($stmt->execute([$name, $email, $hashedPassword])) {
        $userId = $pdo->lastInsertId();
        
        // Auto-login after registration
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = 'user';

        echo json_encode([
            'success' => true, 
            'message' => 'Cadastro realizado com sucesso!',
            'user' => ['name' => $name, 'role' => 'user']
        ], JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("Erro ao inserir usuário.");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno ao salvar o usuário.'], JSON_UNESCAPED_UNICODE);
}
?>
