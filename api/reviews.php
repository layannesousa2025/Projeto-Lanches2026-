<?php
// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// Static reviews data
$reviews = [
    [
        'id' => 1,
        'text' => "O melhor hambúrguer que já comi. Sabor verdadeiramente explosivo!",
        'author' => "Alex J.",
        'rating' => 5
    ],
    [
        'id' => 2,
        'text' => "Qualidade e apresentação inacreditáveis. Uma experiência 10/10.",
        'author' => "Sarah M.",
        'rating' => 5
    ],
    [
        'id' => 3,
        'text' => "O cheeseburger duplo é de outro mundo. Super recomendo!",
        'author' => "David K.",
        'rating' => 5
    ]
];

// Return JSON response
echo json_encode($reviews, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
