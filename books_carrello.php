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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>carrello libri</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="books_carrello.css">
    <script src="books_carrello.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
            <a href="books.php" id="back-to-books" title="Torna ai books">
                &#x2190; <!-- Codice HTML per una freccia a sinistra -->
            </a>
                <a id="home">carrello libri</a>
            </nav>
        </header>
        <div class="icon-container">
            <img src="images/carrello_pieno.png" alt="Icona di acquisto" class="purchase-icon">
        </div>
        <!-- Pulsante acquista -->
        <div class="button-container">
            <a href="purchase_books.php" class="purchase-button">Acquista</a>
        </div>
        <!-- Lista dei libri del carrello -->
        <div id="books-carrello-list">
            <!-- Questa sezione verrà popolata dinamicamente con i libri del carrello -->
        </div>
    </div>
</body>
</html>