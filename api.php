<?php
// URL base de la API
$api_url = "https://api.desdksamarket.com/v1/inventory/";

// Clave de la API
$api_key = "7uBtYp2rKsQ6vDg9F3xM1wP5oZ8nA0eL";

// Construimos la URL completa con la clave como parámetro
$url = $api_url . "?key=" . $api_key;

// Inicializamos una sesión cURL
$ch = curl_init($url);

// Configuramos las opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Realizamos la solicitud GET a la API
$response = curl_exec($ch);

// Verificamos si la solicitud fue exitosa
if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
    // Decodificamos los datos de respuesta
    $data = json_decode($response, true);

    // Guardamos los datos en un archivo de texto con codificación UTF-8
    $file = fopen("products.txt", "w");
    foreach ($data as $product) {
        fwrite($file, "Name: " . utf8_encode($product['Product_title']) . "\n");
        fwrite($file, "Description: " . utf8_encode($product['Product_info']) . "\n");
        fwrite($file, "Price: " . utf8_encode($product['Product_price']) . "\n\n");
    }
    fclose($file);

    echo "The products have been saved in products.txt";
} else {
    echo "Error in the request: Code " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

// Cerramos la sesión cURL
curl_close($ch);
?>
