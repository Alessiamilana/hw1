<?php
//viene incluso per accedere alla funzione checkAuth()
include 'auth.php';

// La funzione checkAuth() viene chiamata per verificare se l'utente è autenticato
if(checkAuth()){
    //reindirizzamento
    header('location: home.php'); 
    exit;
}

//verifico che i campi username e password non sono vuoti(se non sono vuoti)
if(!empty($_POST["username"]) && !empty($_POST["password"])){

    //apro una CONNESSIONE CON IL DATABASE
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    //effettua un corretto escape delle stringhe
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    //VIENE PREPARATA LA QUERY
    $query = "SELECT * FROM users WHERE username = '".$username."'";
    //VIENE ESEGUITA LA QUERY,se la query ha successo, i risultati vengono memorizzati nella variabile $res, altimenti viene restituito un mess di errore e die() interrompera lo script
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    //verifica che la query abbia restituito almeni un risultato
    if (mysqli_num_rows($res) > 0)
    {
       
        //ESTRAZIONE DEI RISULTATI/RECORD i risultati vengono estratti e messi nella variabile '$entry'
        $entry = mysqli_fetch_assoc($res);

  
        // verifico che la password inserita dall'utente come primo ARG corrisposta alla password mem nel db come secondo ARG
        $hashed_password = $entry['password'];

        // Verify the password
        if (password_verify($_POST['password'], $hashed_password)) 
         {
          
             //se la condizione è vera Imposto una sessione per l'utente/gli utenti trovato/i nel db
            $_SESSION["session_username"] = $entry['username'];
            $_SESSION["session_id"] = $entry['id'];
            header("Location: home.php");
            //libero lo spazio occupato dai riusltati della query
            mysqli_free_result($res);
            //chiudo la connessione
            mysqli_close($conn);
            exit;
        }
    }
    //se c'è qualche errore nelle condizioni precedenti, viene visualizzato un mess di errore
    $error = "Username e/o password errati.";
}
//altrimenti se non è stato compilato uno dei due campi fra username o password, viene visualizzato un altro mess di errore
else if (isset($_POST["username"]) || isset($_POST["password"])) {
    $error = "Inserisci username e password.";
}

    ?>
    




    <html>
    <head>
        <link rel='stylesheet' href='login.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>login - Gallery</title>
        
    </head>
    <body>
        <main class="login">
        <section class="main">
            <h1>Gallery</h1>
            <?php
                if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
                
            ?>
            <form name='login' method='post'>
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>
                <div class="submit-container">
                    <div class="login-btn">
                        <input type='submit' value="LOGIN">
                    </div>
                </div>
            </form>
            <div class="signup"><h4>Non hai un account?</h4></div>
            <div class="signup-btn-container"><a class="signup-btn" href="register.php">SIGNUP</a></div>
        </section>
        </main>
    </body>
</html>






















    










