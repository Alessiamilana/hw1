<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

// Connetti al database
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

if (!$conn) {  // Aggiunto controllo della connessione
    die("Connessione fallita: " . mysqli_connect_error());
}

$userid = mysqli_real_escape_string($conn, $userid);
$query = "SELECT titolo, books.isbn, books.copertina FROM books JOIN books_favorites ON books.isbn = books_favorites.isbn WHERE id_user = '$userid'";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

$favoriteBooks = [];
$uniqueIsbns = [];  // Array per tracciare gli ISBN unici

while ($row = mysqli_fetch_assoc($res)) {  
    if (!in_array($row['isbn'], $uniqueIsbns)) {
        $favoriteBooks[] = $row;
        $uniqueIsbns[] = $row['isbn'];
    }
}

echo json_encode($favoriteBooks);

mysqli_close($conn);
?>
