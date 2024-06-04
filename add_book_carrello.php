<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['isbn'], $_POST['title'], $_POST['cover_url']) ) {
    // Connetti al database
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);


    $userid = mysqli_real_escape_string($conn, $userid);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $cover = mysqli_real_escape_string($conn, $_POST['cover_url']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $qr="SELECT * FROM books WHERE isbn = '$isbn'";
    $result = mysqli_query($conn, $qr) or die(mysqli_error($conn));
    if(mysqli_num_rows($result) == 0) {
        // Aggiungi il libro ai preferiti dell'utente
        $qr= "INSERT INTO books (isbn,titolo,copertina) VALUES ('$isbn','$title','$cover')";
        $result=mysqli_query($conn, $qr) or die(mysqli_error($conn));
    }

    $query = "SELECT * FROM books_carrello WHERE id_user = '$userid' AND isbn = '$isbn'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if(mysqli_num_rows($res) > 0) {
        echo json_encode(array('error ' =>"Il libro è già nel carrello"));
        mysqli_close($conn);
        exit;
    }

    $query = "INSERT INTO books_carrello (id_user, isbn) VALUES ('$userid', '$isbn')";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if($res) {
        echo json_encode(['ok' => true]);
        mysqli_close($conn);
        exit;
    }
    mysqli_close($conn);
} else {
    echo json_encode(array('error ' => "ISBN non fornito"));
}
?>