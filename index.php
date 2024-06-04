<?php 
//viene incluso per accedere alla funzione checkAuth()
    require_once 'auth.php';
    // se l'utente non è loggato
    if (!$userid = checkAuth()) {
        //reindirizzamneto alla login
        header("Location: login.php");
        exit;
    }else  {
        //reindirizzamneto alla home
        header("Location: home.php");
        exit;
    }
?>