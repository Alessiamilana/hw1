<?php
//Controlla se il parametro query è stato passato nella richiesta GET.
// Se non è presente, restituisce un errore JSON.
if (isset($_GET['query'])) {
    //Codifica la query per essere sicuri che sia valida come parte di un URL.
    $sculpturName = urlencode($_GET['query']);
    $api_key = 'ineousionjo'; //imposta la chiave api
    //prepara l'url per la richiesta api ad europeana con la query codificata
    $restUrl = 'https://api.europeana.eu/record/search.json?query=' . $sculpturName . '&wskey=' . $api_key;


    $ch = curl_init();    //Inizializza una nuova sessione cURL.
    curl_setopt($ch, CURLOPT_URL, $restUrl);//imposta l'URL che cURL deve richiedere. 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//imposta cURL per restituire il risultato come stringa

    // Esegui la richiesta e memorizza la risposta nella variabile $response
    $response = curl_exec($ch);

    // Verifica se ci sono errori di cURL(se ci sono errori, vengono restutuiti in formato json e termina lo script)
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit; //termina script
    }

    curl_close($ch); //Chiude la sessione cURL per liberare le risorse.

    // Imposta l'header della risposta HTTP per indicare che il contenuto è di tipo JSON.
    header('Content-Type: application/json');
    echo $response; //Stampa la risposta dell'API di Europeana, e viene restituita come risposta al client.
   
    // altrimenti Se il parametro query non è presente nella richiesta GET, 
    //restituisce un messaggio di errore in formato JSON.
} else { 
    echo json_encode(['error' => 'Nessuna query fornita']);
}


//Con queste righe, il tuo script PHP prende una query dal client, 
//effettua una richiesta all'API di Europeana usando cURL, 
//e restituisce la risposta al client come JSON.


