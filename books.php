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
    <link rel="stylesheet" href="books.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Work+Sans&display=swap" rel="stylesheet">
    <title>Page-Books</title>
    <script src="books.js"></script>
    </head>
<body>
<header>
        <nav class="navbar">
            <a href="home.php" id="back-to-home" title="Torna alla home">
                &#x2190; <!-- Codice HTML per una freccia a sinistra -->
            </a>
            <a id="home">BOOKS GALLERY</a>
            <div class="nav-right">
                <span class="navElements">
                    <a href="books_preferiti.php" class="preferiti-link">PREFERITI</a>
                </span>
                <span class="navElements">
                    <a href="books_carrello.php" class="carrello-link">CARRELLO</a>
                </span>
                <span class="navElements">
                    <form class="books-form">
                        <input type="text" id="author" name="author" placeholder="Inserisci autore">
                        <button type="submit">Cerca</button>
                    </form>
                </span>
            </div>
        </nav>
    </header>
    
    <div id="result-view">
        <!-- Qui verranno visualizzati i risultati dei libri-->
 
    </div>

    <article id="modale" class="hidden">
        <!-- Qui c'è la sezione dove si andrà ad espandere la modale -->
    </article>

    <footer>
        <span>browse, read, and let yourself be carried away by the magic of words</span>
    </footer>
</body>
</html>


