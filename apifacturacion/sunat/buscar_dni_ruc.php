<?php
if (isset($_GET['numero']) && isset($_GET['tipo'])) {
    $numero = $_GET['numero'];
    $tipo = $_GET['tipo'];

    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImluZm9ybWF0aWNvdW5pQGdtYWlsLmNvbSJ9.t-qzqKwWXsBGTUP_z4jPclP9kiQ3HkLuzQFRVGkeRLg";

    // Definir URL según sea DNI o RUC
    if ($tipo === "dni") {
        $url = "https://dniruc.apisperu.com/api/v1/dni/$numero?token=$token";
    } elseif ($tipo === "ruc") {
        $url = "https://dniruc.apisperu.com/api/v1/ruc/$numero?token=$token";
    } else {
        echo json_encode(["error" => "Tipo de documento inválido"]);
        exit();
    }

    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Devolver la respuesta JSON
    header('Content-Type: application/json');
    echo $response;
    exit();
} else {
    echo json_encode(["error" => "No se recibió un número de documento"]);
}
?>
