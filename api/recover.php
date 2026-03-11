<?php
// api/recover.php - Handle password reset request
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

if (empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'O campo e-mail é obrigatório.'], JSON_UNESCAPED_UNICODE);
    exit();
}

try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        // Generate a random 6-digit PIN
        $pin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Update user with token and expiration (1 hour)
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->execute([$pin, $email]);

        // In a real system, we would send an email here.
        // For simulation, we return the PIN in the response.
        echo json_encode([
            'success' => true,
            'message' => 'Código de recuperação gerado com sucesso! (Simulação)',
            'pin' => $pin // REMOVE THIS IN PRODUCTION
        ], JSON_UNESCAPED_UNICODE);
    } else {
        // For security, don't reveal if the email exists or not in a real system,
        // but for a small local app, a clearer message is often preferred.
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'E-mail não encontrado.'], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno no servidor.'], JSON_UNESCAPED_UNICODE);
}
?>
