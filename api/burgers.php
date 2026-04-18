<?php
// Set CORS headers so the frontend can access the API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// Static data simulating a database response
$burgers = [
    [
        'id' => 1,
        'title' => 'Clássico com Queijo',
        'description' => 'O original atemporal com cheddar derretido.',
        'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
        'price' => 25.90
    ],
    [
        'id' => 2,
        'title' => 'Vulcão Apimentado',
        'description' => 'Jalapeños e maionese picante para um toque extra.',
        'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
        'price' => 29.90
    ],
    [
        'id' => 3,
        'title' => 'Cogumelo Trufado',
        'description' => 'Blend gourmet com cogumelos assados e maionese trufada.',
        'image' => 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
        'price' => 34.90
    ]
];

// Return JSON response
echo json_encode($burgers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
