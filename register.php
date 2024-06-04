<?php
    require_once 'auth.php';

    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }
     
     // verifico che i campi non siano vuoti
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["name"]) && 
        !empty($_POST["surname"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]))
    {
        
        //dichiaro un vettore chiamato $error che conterrà tutti i messaggi di errore
        $error = array();
        //se i campi non sono vuoti apro una connessione con il db
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        //da qui in poi faremo una serie di verifiche su tutti i campi per la registrazione
        //se l'username che noi digitiamo in fase di registrazione non rispetta queste specifiche,
        //viene aggiunto un messaggio di errore all'array $error
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
            //altrimenti se l'username passa la verifica, viene fatto l'escape dell'username
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            //verifica l'unicita dell'username
            $query = "SELECT username FROM users WHERE username = '$username'";
            //ricerca della query
            $res = mysqli_query($conn, $query);
            //se la query ritorna 1 o + risultati significa che già ho usato quell'username e quindi mi darà un mess di errore
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        
        }
         // se la lunghezza della stringa è <8 mi dara errore
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 
        if (!preg_match('/[A-Z]/', $_POST["password"])) {
            $error[] = "La password deve contenere almeno una lettera maiuscola";
        }
        //confronto fra stringhe (fra la password e quella di conferma). se le due password non coincidono si aggiunge un errore all'array $error
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
         //controlla che l'email sia inserita nel formato corretto, se non è cosi,errore
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
            //altrimenti come per l'username fa l'escape per prevenire incorretta leggibilità della stringa
            //'strtolower'converte l'email in minuscolo
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            //verifica l'unicita dell'email e la ricerca di essa insieme
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            //se la query mi da 1 o + result allora errore
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }


        // verifico che l'array sia vuoto e che quindi non ci siano errori. se è cosi posso andare avanti
        if (count($error) == 0) {
            
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            //questa funzione 'crypt' serve per applicare vari algoritmi di hashing, incluso bcrypt.
            //Gli algoritmi di hashing sono funzioni crittografiche che trasformano dati di input (come una password)
            // in una stringa fissa di caratteri, tipicamente una sequenza alfanumerica.
            // Sono utilizzati per garantire la sicurezza delle informazioni, soprattutto nelle password
            $password = crypt($password, PASSWORD_BCRYPT);
             //inserisco nella tabella users tutti i campi
            $query = "INSERT INTO users(username, password, name, surname, email) VALUES('$username', '$password', '$name', '$surname', '$email')";
            //se l'inserimento ha succeso vengono impostate le variabili di sessione
            if (mysqli_query($conn, $query)) {
                $_SESSION["session_username"] = $_POST["username"];
                // 'mysqli_insert_id($conn)'--> sarebbe l'id gerenato automaticamente perchè è auto-increment
                $_SESSION["session_id"] = mysqli_insert_id($conn);
                //chiudo connessione
                mysqli_close($conn);
                //reindirizzo alla home
                header("Location: home.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    // altrimenti se ho inserito solo un campo stampa errore
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }


?>



<html>
    <head>
    <link rel="stylesheet" href="register.css?v=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;700&display=swap">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap">
    <meta charset="utf-8">
    <script src="register.js" defer></script>

        <title>Iscriviti - Gallery</title>
    </head>
    <body>
        <div id="sign">
            Gallery
        </div>
        <main>
        <section class="main">
            <h1>Cosa aspetti? è gratuito!</h1> 
            <!-- nome form e metodo di invio dati post(i dati in php vengono trasmessi tramite metodo post). il form serve per inserire i dati in input-->
            <form name='register' method='post' enctype="multipart/form-data" autocomplete="off">
                <div class="names">
                    <div class="name">
                        <label for='name'>Nome</label>
                        <!-- Se il submit non va a buon fine, il server reindirizza su questa stessa pagina, quindi va ricaricata con 
                            i valori precedentemente inseriti -->
                        <input type='text' name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                        <span> </span>
                    </div>
                    <div class="surname">
                        <label for='surname'>Cognome</label>
                        <input type='text' name='surname' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> >
                        <span> </span>
                    </div>
                </div>
                <div class="username">
                    <label for='username'>Nome utente</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    <span> </span>
                </div>
                <div class="email">
                    <label for='email'>Email</label>
                    <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                    <span> </span>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                   <span> </span>
                </div>
                <div class="confirm_password">
                    <label for='confirm_password'>Conferma Password</label>
                    <input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                    <span> </span>
                </div>
                <div class="allow"> 
                    <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                    <label for='allow'>Accetto i termini e condizioni d'uso di Gallery.</label>
                </div>
                 <?php if(isset($error)) {
                          foreach($error as $err) {
                        //classe error per gestire gli errori nel js
                        echo "<div class='error'><span>".$err."</span></div>";
                    }
                } ?>
                <div class="submit">
                    <input type='submit' value="Registrati" id="submit">
                </div>
            </form>
            <div class="register">Hai un account? <a href="login.php">Accedi</a>
        </section>
        </main>
    </body>
</html>