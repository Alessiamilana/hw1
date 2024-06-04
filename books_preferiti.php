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
    <title>books-preferiti</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="books_preferiti.css">
    <script src="books_preferiti.js" defer></script>
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
            <a href="books.php" id="back-to-books" title="Torna ai books">
                &#x2190; <!-- Codice HTML per una freccia a sinistra -->
            </a>
                <a id="home">favorite books</a>
            </nav>
        </header>
        <div class="icon-preferiti">
            <img src="images/pref.png" alt="Icona preferiti" class="pref-icon">
        </div>
        <!-- Lista dei libri preferiti -->
        <div id="preferiti-list">
            <!-- Questa sezione verrà popolata dinamicamente con i libri preferiti -->
        </div>
    </div>
</body>
</html>