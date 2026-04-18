<?php
// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed. Use POST.']);
    exit();
}

// Get POST data (e.g., from fetch body)
$data = json_decode(file_get_contents('php://input'), true);

// Example response simulating order processing
$response = [
    'success' => true,
    'message' => 'Pedido recebido com sucesso!',
    'orderId' => uniqid('ORDER-'),
    'timestamp' => date('Y-m-d H:i:s')
];

// Return JSON response
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
