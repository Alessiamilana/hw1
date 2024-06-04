<?php 
//recupera lo stato dell'ordine dopo l'insert in purchase_books.php
$status= isset($_GET['status']) ? $_GET['status'] : '';

//funzione che genera il messaggio a seconda dello stato
function generateMessage($status){
    switch($status){
        case 'successo':
            return "ordine effettuato con successo!";
        case 'fallito':
            return "si è verificato un errore durante l'elaborazione dell'ordine";
        default:
            return""; //nessun meggaggio di default
    }
}
//chiamo la funzione ottenendo lo stato
$message_status=generateMessage($status);

//viene incluso per accedere alla funzione checkAuth()
    require_once 'auth.php';
    // se l'utente non è loggato
    if (!$userid = checkAuth()) {
        //reindirizzamneto alla login
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="home.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Work+Sans&display=swap" rel="stylesheet">
    <script src="home.js?v=1" defer></script>
   
</head>

<body>
  <header>
    <nav class="navbar">
        <a id="home" >GOLDEN AGE GALLERY</a>
        <span class="navElements" > 
            <a href="gallery.php" class="gallery-link">GALLERY</a>
        </span>
        <span class="navElements">
            <a href="sculptures.php" class="sculptur-link">SCULPTURES</a>
        </span>
        
        <span class="navElements">
            <a href="books.php" class="books-link"> BOOKS</a></span>
        <span class="navElements" id="services">ABOUT
                <div class="menu">
                    <a href="CV.php">CV</a>
                    <a href="contact.php">CONTACT</a>
                </div>
            </span>
        <span class="navElements"><a href="logout.php" class="logout-link">LOGOUT</a></span>
    </nav>
</header>
<!--  in questa porzione di codice verrà visualizzato il messaggio all'utente sullo stato dell'acquisto -->
<?php if (isset($_GET['status']) && ($_GET['status'] === 'successo' || $_GET['status'] === 'fallito')) { ?>
    <div id="status-message">
        <?php if (!empty($message_status)): ?>
            <div><?php echo $message_status; ?></div>
        <?php endif; ?>
        <button id="close-button">Chiudi</button>
    </div>
<?php } ?>
    <footer >
      <span>Golden Age Gallery © 2018 All Rights Reserved</span>
      <span>Privacy Policy</span>
      <div id="logo-mano">
        <h1> clicca qui:</h1>
        <img src="images/indice.png" alt="Immagine1" style="width: 0.5cm; height: o.5cm;"/>
      </div>
      <div id="logo-emoij" class="hidden">
            <img src="images/smile.png" alt="Immagine2" style="width: 0.5cm; height: o.5cm;"/>
      </div>
    </footer>
</body>
</html>
