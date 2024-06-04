<?php
//Controlla se il parametro query è stato passato nella richiesta GET.
// Se non è presente, restituisce un errore JSON.
if (isset($_GET['author'])) {
    //Codifica l'autore per essere sicuri che sia valido come parte di un URL.
    $author = urlencode($_GET['author']);

    // URL dell'API di Open Library con l'autore passato come parametro GET
    $url = 'http://openlibrary.org/search.json?author=' . $author;

    // Esegui la richiesta e memorizza la risposta nella variabile $response
    $response = file_get_contents($url);

    // Verifica se la risposta è stata ricevuta correttamente
    if ($response === FALSE) {
        // Restituisci un errore in formato JSON
        echo json_encode(['error' => 'Errore nella richiesta']);
        exit; // Termina lo script
    }

    // Imposta l'header della risposta HTTP per indicare che il contenuto è di tipo JSON.
    header('Content-Type: application/json');
    echo $response; //Stampa la risposta dell'API di Open Library, e viene restituita come risposta al client.
   
} else { 
    // Se il parametro author non è presente nella richiesta GET, 
    // restituisce un messaggio di errore in formato JSON.
    echo json_encode(['error' => 'Nessun autore fornito']);
}?>
