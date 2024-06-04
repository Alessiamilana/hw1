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
    <title>Page-Sculptures</title>
    <link rel="stylesheet" href="sculptures.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Work+Sans&display=swap" rel="stylesheet">
    <script src="sculptures.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar">
              <!--freccia a sinistra-->
              <a href="home.php" id="back-to-home" title="Torna alla home">
                &#x2190; <!-- Codice HTML per una freccia a sinistra -->
            </a>
            <a id="home">SCULPTURE GALLERY</a>
        </nav>
        <ul id="sculptur">
            <li value="moses scultura">Moses</li>
            <li value="il david scultura">Il David</li>
            <li value="la pieta scultura">La Pietà</li>
            <li value="cristo redentore scultura">Cristo Redentore</li>
            <li value="nike scultura">Nike</li>
            <li value="discobolo scultura">Discobolo</li>
        </ul>
    </header>

    <div id="result-view">
        <!-- Qui verranno visualizzati i risultati delle sculture -->
    </div>

    <article id="modale" class="hidden">
        <!-- Qui c'è la sezione dove si andrà ad espandere la modale -->
    </article>

    <footer>
        <span>This sculpture exhibition belongs to the UNESCO world heritage site</span>
    </footer>
</body>
</html>