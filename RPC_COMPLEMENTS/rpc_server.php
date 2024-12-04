<?php
// Funciones disponibles para RPC
function add($a, $b) {
    return $a + $b;
}

function subtract($a, $b) {
    return $a - $b;
}

// Procesar solicitudes RPC
$requestPayload = json_decode(file_get_contents("php://input"), true);

if ($requestPayload && isset($requestPayload['method'], $requestPayload['params'])) {
    $method = $requestPayload['method'];
    $params = $requestPayload['params'];

    if (function_exists($method)) {
        $result = call_user_func_array($method, $params);
        echo json_encode(["result" => $result]);
    } else {
        echo json_encode(["error" => "Method not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
