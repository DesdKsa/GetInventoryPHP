<?php
/*Get inventory*/
define("API_URL", "https://api.desdksamarket.com/v1/inventory/");
define("API_KEY", "your-api-key");

function fetchAndSaveData() {
    $url = API_URL . "?key=" . API_KEY;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
        $data = json_decode($response, true);

        $output = [];
        foreach ($data as $product) {
            $output[] = [
                'Name' => utf8_encode($product['Product_title']),
                'Description' => utf8_encode($product['Product_info']),
                'Price' => utf8_encode($product['Product_price'])
            ];
        }

        file_put_contents("products.json", json_encode($output, JSON_PRETTY_PRINT));
        echo "The products have been saved in products.json";
    } else {
        echo "Error in the request: Code " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    curl_close($ch);
}

fetchAndSaveData();
?>
