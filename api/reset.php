<?php
// api/reset.php - Verify PIN and reset password
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'db.php';

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$email = trim($data['email'] ?? '');
$pin = trim($data['pin'] ?? '');
$new_password = $data['new_password'] ?? '';

if (empty($email) || empty($pin) || empty($new_password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.'], JSON_UNESCAPED_UNICODE);
    exit();
}

try {
    // Check if token matches and is not expired
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$email, $pin]);
    if ($stmt->fetch()) {
        // Update password and clear token
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?");
        $stmt->execute([$hashedPassword, $email]);

        echo json_encode(['success' => true, 'message' => 'Senha alterada com sucesso!'], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Código inválido ou expirado.'], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno no servidor.'], JSON_UNESCAPED_UNICODE);
}
?>
