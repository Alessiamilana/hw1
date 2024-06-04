<?php
// OAuth credentials
$client_id = '3ef19451e3018877e118';
$client_secret = 'abeecbde8b8ec852a77efbb5c47aba93';

// URL for token request
$token_url = "https://api.artsy.net/api/tokens/xapp_token?client_id=$client_id&client_secret=$client_secret";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);


$response = curl_exec($ch);


if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Set response header
header('Content-Type: application/json');
echo $response;

//l'api_token.php richiede il token OAuth2.0 da Artsy e lo restituisce come JSON.