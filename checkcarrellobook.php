<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['isbn']) ) {
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
$userid = mysqli_real_escape_string($conn, $userid);
$isbn = mysqli_real_escape_string($conn, $_GET['isbn']);
$query = "SELECT * FROM books_carrello WHERE id_user = '$userid' AND isbn = '$isbn'";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

if(mysqli_num_rows($res) > 0) {
    echo json_encode(['pieno' => true]);
    mysqli_close($conn);
    exit;
}
else{
    echo json_encode(['pieno' => false]);
    mysqli_close($conn);
    exit;
}
mysqli_close($conn);

}
?>