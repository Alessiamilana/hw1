<?php

// STEP 2


    require_once 'dbconfig.php';

    //// Controlla se la query string "q" è settata, altrimenti esce con un messaggio di errore
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }
// Imposta l'intestazione della risposta HTTP per specificare che il contenuto sarà JSON
    header('Content-Type: application/json');
// connessione al db
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
// Preleva l'email dalla query string e la sanitizza per evitare SQL injection
    $email = mysqli_real_escape_string($conn, $_GET["q"]);
//prepara la query per cercare la mail nel db
    $query = "SELECT email FROM users WHERE email = '$email'";
//eegue la query(ricerca)
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
//Converte il risultato della query in un array associativo e lo codifica in formato JSON
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
//chiude la connessione al db
    mysqli_close($conn);
?>

<!--in sintesi qui stiamo ricercando la mail se disponibile nel db (viene fatto tramite richiesta fetch al server-->