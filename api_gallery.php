<?php
function getAccessToken() {
    // URL for getting the token
    $client_id = '3ef19451e3018877e118';
    $client_secret = 'abeecbde8b8ec852a77efbb5c47aba93';
    $token_url = "https://api.artsy.net/api/tokens/xapp_token?client_id=$client_id&client_secret=$client_secret";

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    // Execute cURL request and capture the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        return null;
    }

    curl_close($ch);

    $token_data = json_decode($response, true);
    return $token_data['token'] ?? null;
}

if (isset($_GET['artist_id'])) {
    $artist_id = urlencode($_GET['artist_id']);

    // URL for artwork request
    $api_url = "https://api.artsy.net/api/artworks?artist_id=" . $artist_id;

    // Get the token
    $token = getAccessToken();
    if (!$token) {
        echo json_encode(['error' => 'Token non trovato']);
        exit;
    }

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-Xapp-Token: ' . $token
    ]);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Segui i reindirizzamenti
    // Execute cURL request and capture the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Set response header
    header('Content-Type: application/json');
    echo $response;
} else {
    echo json_encode(['error' => 'Nessun artist_id fornito']);
}


//mentre 'api_artist.php' utilizza il token per richiedere le opere dell'artista da Artsy 
//e restituisce la risposta come JSON.

//importante : In questo modo, le richieste effettive ai provider sono fatte dal server tramite PHP, 
//mantenendo sicure le tue credenziali e i token, e gli errori sono gestiti direttamente 
