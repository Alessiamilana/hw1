<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['isbn'])) {
    

    // Connetti al database
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    
    $userid = mysqli_real_escape_string($conn, $userid);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);

    // Controlla se il libro è presente nella lista dei preferiti dell'utente
    $query = "SELECT * FROM books_favorites WHERE id_user = '$userid' AND isbn = '$isbn'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
   

    if (mysqli_num_rows($res)=== 0) {
        // Il libro non è presente nella lista dei preferiti, quindi non possiamo rimuoverlo
        echo json_encode(array('error' => "Il libro non è presente nei preferiti"));
        mysqli_close($conn);
        exit;
    }

    // Rimuovi il libro dai preferiti dell'utente
    
    $query = "DELETE FROM books_favorites WHERE id_user = '$userid' AND isbn = '$isbn'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        echo json_encode(array('ok' => true));
        mysqli_close($conn);
        exit;
    }

    
    mysqli_close($conn);
} else {
    echo json_encode(array('error ' => "ISBN o titolo non forniti"));
}
?>