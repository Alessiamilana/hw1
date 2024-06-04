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
    <link rel="stylesheet" href="contact.css">
    <title>Contatto</title>
    
</head>
<body>
    <div class="container">
    <a href="home.php" id="back-to-home" title="Torna ai books">
                &#x2190; 
            </a>
        <h1>Contact</h1>
        <div class="contact-info">
            <p><strong>Nome e Cognome:</strong> ALESSIA MILANA</p>
            <p><strong>Città di residenza:</strong> LICATA </p>
            <p><strong>Email:</strong> ALESSIAMILANA77@GMAIL.COM </p>
            <p><strong>Cellulare:</strong> +39 3887758616</p>
        </div>
        <div class="social-icons">
            <a href="https://www.facebook.com/login/"><img src="images/facebook.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/_aless02_/?hl=it"><img src="images/instagram.png" alt="Instagram"></a>
        </div>
    </div>
</body>

</html>