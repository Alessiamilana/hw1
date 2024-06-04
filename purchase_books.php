<?php
require_once 'auth.php';
if (!$userid = checkAuth()) {
    header("Location: login.php");
    exit;
}

$error = array(); // Inizializza l'array degli errori

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se i campi obbligatori sono vuoti
    if (empty($_POST["card_owner_name"]) || empty($_POST["card_owner_surname"]) || empty($_POST["email"]) || empty($_POST["expiry_date"]) || empty($_POST["pin"]) || empty($_POST["card_number"])) {
        $error[] = "Riempi tutti i campi";
    } else {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        // Validazione del nome e del cognome
        $namePattern = '/^[a-zA-Z]+$/';
        if (!preg_match($namePattern, $_POST['card_owner_name'])) {
            $error[] = "Nome non valido";
        }

        if (!preg_match($namePattern, $_POST['card_owner_surname'])) {
            $error[] = "Cognome non valido";
        }

        // Validazione del numero della carta
        $numberPattern = '/^[0-9]{16}$/';
        if (!preg_match($numberPattern, $_POST['card_number'])) {
            $error[] = "Numero della carta non valido (16 numeri)";
        }

        // Validazione della data di scadenza della carta
        $expiryPattern = '/^(0[1-9]|1[0-2])\/\d{2}$/';
        if (!preg_match($expiryPattern, $_POST['expiry_date'])) {
            $error[] = "Data di scadenza della carta non valida";
        }

        // Validazione del PIN
        $pinPattern = '/^[0-9]{3}$/';
        if (!preg_match($pinPattern, $_POST['pin'])) {
            $error[] = "CVC non valido (3 numeri)";
        }

        // Controlla che l'email sia nel formato corretto
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        }

        // Se non ci sono errori, procedi con l'inserimento nel database
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['card_owner_name']);
            $surname = mysqli_real_escape_string($conn, $_POST['card_owner_surname']);
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
            $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
            $pin = mysqli_real_escape_string($conn, $_POST['pin']);
            
            // Controlla se il proprietario esiste già nella tabella card_owner
            $check_query = "SELECT id FROM card_owner WHERE email = '$email'";
            $check_result = mysqli_query($conn, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                $row = mysqli_fetch_assoc($check_result);
                $card_owner_id = $row['id'];
            } else {
                // Se il proprietario non esiste, inseriscilo nella tabella card_owner
                $insert_query = "INSERT INTO card_owner (user_id, card_owner_name, card_owner_surname, email) VALUES ('$userid', '$name', '$surname', '$email')";
                if (mysqli_query($conn, $insert_query)) {
                    $card_owner_id = mysqli_insert_id($conn);
                } else {
                    $error[] = "Errore durante l'inserimento del proprietario della carta";
                }
            }

            // Se non ci sono errori nell'inserimento del proprietario, procedi con l'inserimento dell'acquisto
            if (empty($error)) {
                // Inserisci l'acquisto nella tabella purchases
                $insert_purchase_query = "INSERT INTO purchases (card_owner_id, stato_ordine) VALUES ('$card_owner_id', 'fallito')";
                if (mysqli_query($conn, $insert_purchase_query)) {
                    $purchase_id = mysqli_insert_id($conn);

                    // Verifica se ci sono libri nel carrello
                    $isbn_query = "SELECT isbn FROM books_carrello WHERE id_user = '$userid'";
                    $isbn_result = mysqli_query($conn, $isbn_query);

                    if (mysqli_num_rows($isbn_result) > 0) {
                        // Se ci sono libri nel carrello, imposta lo stato dell'ordine su "successo" e svuota il carrello
                        $update_purchase_query = "UPDATE purchases SET stato_ordine = 'successo' WHERE id = '$purchase_id'";
                        if (mysqli_query($conn, $update_purchase_query)) {
                            $delete_query = "DELETE FROM books_carrello WHERE id_user = '$userid'";
                            if (!mysqli_query($conn, $delete_query)) {
                                $error[] = "Errore durante la cancellazione del carrello";
                            } else {
                                mysqli_close($conn);
                                $status="successo";
                                $url="home.php?status=" . urldecode($status);
                                //reindirizzamento
                                header("Location:" . $url);
                                exit;
                            }
                        } else {
                            $error[] = "Errore durante l'aggiornamento dello stato dell'ordine";
                        }
                    } else {
                        // Se non ci sono libri nel carrello, lo stato dell'ordine rimane "fallito"
                        mysqli_close($conn);
                        $status="fallito";
                        $url="home.php?status=" . urldecode($status);
                        header("Location:" . $url);
                        exit;
                    }
                } else {
                    $error[] = "Errore durante l'inserimento dell'acquisto";
                }
            }
        }

        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acquisto books</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap">
    <link rel="stylesheet" href="purchase_books.css">
    <!--<script src="purchase_books.js" defer></script>-->
</head>
<body>
    <main>
        <section class="main">
            <h1>Procedi con l'acquisto</h1>
            <a href="books_carrello.php" id="back-to-carrello" title="Torna ai books carrello">
                &#x2190; <!-- Codice HTML per una freccia a sinistra -->
            </a>
            <form id="acquisto-form" name="acquisto" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="names">
                    <div class="name">
                        <label for="card_owner_name">Nome intestatario carta</label>
                        <input type="text" id="card_owner_name" name="card_owner_name" <?php if(isset($_POST["card_owner_name"])){echo "value=".$_POST["card_owner_name"];} ?>>
                        <span></span>
                    </div>
                    <div class="surname">
                        <label for="card_owner_surname">Cognome intestatario carta</label>
                        <input type="text" id="card_owner_surname" name="card_owner_surname" <?php if(isset($_POST["card_owner_surname"])){echo "value=".$_POST["card_owner_surname"];} ?>>
                        <span></span>
                    </div>
                </div>
                <div class="email">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                    <span></span>
                </div>
                <div class="number">
                    <label for="card_number">Numero carta</label>
                    <input type="text" id="card_number" name="card_number" <?php if(isset($_POST["card_number"])){echo "value=".$_POST["card_number"];} ?>>
                    <span></span>
                </div>
                <div class="input-group">
                    <div class="date">
                        <label for="expiry_date">Data di scadenza (MM/YY)</label>
                        <input type="text" id="expiry_date" name="expiry_date" <?php if(isset($_POST["expiry_date"])){echo "value=".$_POST["expiry_date"];} ?>>
                        <span></span>
                    </div>
                    <div class="pin">
                        <label for="pin">CVC</label>
                        <input type="text" id="pin" name="pin" <?php if(isset($_POST["pin"])){echo "value=".$_POST["pin"];} ?>>
                        <span></span>
                    </div>
                </div>
                <?php if(!empty($error)) {
                    foreach($error as $err) {
                        echo "<div class='error'><span>".$err."</span></div>";
                    }
                } ?>
                <div class="submit">
                    <input type="submit" value="Conferma ordine" id="submit">
                </div>
            </form>
        </section>
    </main>
</body>
</html>
