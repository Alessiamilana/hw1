<?php
    // Include il file per l'autenticazione
    require_once 'auth.php';
    // Verifica se l'utente è autenticato
    if (!$userid = checkAuth()) {
        // Se l'utente non è autenticato, reindirizzalo alla pagina di login
        header("Location: login.php");
        exit;
    }
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CV.css">
    <title>About Me</title>
</head>
<body>
    <div id="container">
    <a href="home.php" id="back-to-home" title="Torna ai books">
                &#x2190; 
            </a>
        <div id="left">
            <img src="images/me.png" alt="Alessia Milana" style="max-width: 100%; height: auto;">
        </div>
        <div id="right">
            <h1 id="aboutMe">About Me</h1>
            <p id="presentation">
            Ciao, sono Alessia Milana, una giovane di 22 anni appassionata di arte e tecnologia. Originaria di Licata, ho intrapreso il mio percorso di studio presso il Liceo Scientifico, e attualmente sto frequentando il terzo anno di Ingegneria Informatica all'università.
            Una delle esperienze più significative del mio percorso accademico è stata la creazione del sito web "Golden Age Gallery", un progetto che ho sviluppato per ottenere i 12 CFU in Database e Web Programming. Non posso negare che il cammino non sia stato privo di sfide, ma la passione e la determinazione mi hanno spinto a superarle e a creare qualcosa di davvero speciale.
            Ho scelto di focalizzare il mio sito su opere artistiche, tra cui libri, quadri e sculture, perché il mondo dell'arte mi affascina profondamente. Adoro immergermi in un dipinto e lasciarmi trasportare dalla sua bellezza, così come amo perdersi tra le pagine di un buon libro.
            Questo progetto non solo mi ha permesso di mettermi alla prova e di sviluppare competenze nel campo della programmazione web, ma mi ha anche confermato che ho fatto la scelta giusta nel perseguire la mia passione per l'arte e la tecnologia.
            </p>
        </div>
    </div>
</body>
</html>