<?php
// Función para hacer la llamada RPC
function rpcCall($url, $method, $params) {
    // Crear el payload con los datos de la solicitud
    $payload = json_encode([
        "method" => $method,
        "params" => $params
    ]);

    // Crear el contexto para la solicitud HTTP
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $payload
        ]
    ]);

    // Enviar la solicitud y capturar la respuesta
    $response = @file_get_contents($url, false, $context);

    // Manejo de errores si la solicitud falla
    if ($response === false) {
        $error = error_get_last();
        die("Error en la solicitud: " . $error['message']);
    }

    // Devolver la respuesta decodificada
    return json_decode($response, true);
}

// Definir la URL del servidor RPC
$url = "http://localhost:8000/rpc_server.php";  // Asegúrate de que esta URL es correcta

// Llamar al método 'add' con los parámetros 5 y 3
$response = rpcCall($url, "add", [5, 3]);
echo "Resultado de la suma: " . $response['result'] . "\n";

// Llamar al método 'subtract' con los parámetros 10 y 4
$response = rpcCall($url, "subtract", [10, 4]);
echo "Resultado de la resta: " . $response['result'] . "\n";
