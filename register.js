//1.questa funzione 'verifyName' controlla se il campo del nome è stato compilato dall'utente 
//e aggiunge o rimuove una classe CSS per segnalare visivamente se il campo è valido o meno.
function VerifyName(event) {
    const input = event.currentTarget;
    //se il campo è stato riempito(quando la lunghezza della stringa è>0)
    //rimuove la classe css che segnala la presenza di un errore
    if (formStatus[input.name] = input.value.length > 0) {
        input.parentNode.classList.remove('error');
        //altrimenti aggiunge la classe e segnala in tempo reale la presenza del campo vuoto
    } else {
        input.parentNode.querySelector('.name span').textContent="aggiungi un name";
        input.parentNode.classList.add('error');
    }
}


//2. stessa cosa con il surname
function VerifySurname(event) {
    const input = event.currentTarget;
    
    if (formStatus[input.surname] = input.value.length > 0) {
        input.parentNode.classList.remove('error');
    } else {
        input.parentNode.querySelector('.surname span').textContent="aggiungi un surname";
        input.parentNode.classList.add('error');
    }
}

//3.
//arrivati qui se l username non e presente nel db allora rimuove la classe di errore

function jsonVerifyUsername(json) { //il parametro in ingresso è un oggetto 'json'ricevuto in risposta ad una richiesta
    if (formStatus.username = !json.exists) {
        document.querySelector('.username').classList.remove('error');
    } else {
        //altrimenti se esiste gia un usurname uguale nel db,stampa l errore aggiungendolo alla classe di errori
        document.querySelector('.username span').textContent = "Ops... utente già utilizzato";
        document.querySelector('.username').classList.add('error');
    }
}

//4. STEP 3 (ULTIMO)
//arrivati qui,se la mail non è presente(non esiste nel db), allora elimina la classe error
function jsonVerifyEmail(json) {
    if (formStatus.email =!json.exists) {
        document.querySelector('.email').classList.remove('error');
    } else {
        //altrimenti la aggiunge e stampa l errore
        document.querySelector('.email span').textContent = "Ops...email già utilizzata";
        document.querySelector('.email').classList.add('error');
    }
}


function fetchResponse(response) {
    if (!response.ok) return null;
    return response.text();
}

//5. 
function VerifyUsername() {
    const input = document.querySelector('.username input');
//l'username deve contenere solo lettere (maiuscole o minuscole), numeri e underscore. 
//inoltre deve avere una lunghezza compresa fra 1 e 15 caratteri. se non viene soffisfatto questo mi stampa il messaggio di errore
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
        input.parentNode.querySelector('span').textContent = "aggiungi un nome utente in cui sono ammesse lettere, numeri e underscore. MAX 15 caratteri";
        input.parentNode.classList.add('error');
        formStatus.username = false;
//altrimenti viene fatta una richiesta fetch
    } else {
        
       fetch("Verify_username.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonVerifyUsername);
    
    }    
}

//6 verifica la validità dell'indirizzo email secondo vari criteri standard per le email.
// in sisntesi la funzione checkEmail verifica prima se l'email inserita è valida 
// Se l'email non è valida, mostra un messaggio di errore e segnala visivamente l'errore.
// Se l'email è valida, invia una richiesta al server per verificare se l'email è disponibile 
//e gestisce la risposta per aggiornare l'interfaccia utente di conseguenza.

//STEP 1
function VerifyEmail() {
    const emailInput = document.querySelector('.email input');
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) {
        document.querySelector('.email span').textContent = "aggiungi un email valida ";
        document.querySelector('.email').classList.add('error');
        formStatus.email = false;

    } else {
    //invia una richiesta al server per verificare se l'email è disponibile (cioe che non e presente nel db)
    //qual ora fosse presente nel db non potrebbe essere utilizzata.
    fetch("Verify_email.php?q="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonVerifyEmail);
    }
}

//7 verifica che la password in imput sia almeno di 8 caratteri e in base a cio elimina o aggiunge una classe di errore
function VerifyPassword() {
    const passwordInput = document.querySelector('.password input');
    const passwordValue= passwordInput.value;
    if (formStatus.password = (passwordValue.length >= 8 && /[A-Z]/.test(passwordValue))) {
        document.querySelector('.password').classList.remove('error');
    } else {
        document.querySelector('.password span').textContent="aggiungi una password che contenga almeno 8 caratteri e una lettera maiuscola";
        document.querySelector('.password').classList.add('error');
    }

}

//8 verifica che la password di conferma sia uguale a quella originale e in base a cio aggiunge o elimina la classe di errore
function VerifyConfirmPassword() {
    const confirmPasswordInput = document.querySelector('.confirm_password input');
    if (formStatus.confirmPassord = confirmPasswordInput.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password').classList.remove('error');
    } else {
        document.querySelector('.confirm_password span').textContent="le password sono diverse";
        document.querySelector('.confirm_password').classList.add('error');
    }
}



//9 la funzione verificare se tutti i campi del modulo di registrazione sono stati
// compilati correttamente prima di permettere l'invio del modulo
function VerifySignup(event) {
    //verifica che il campo'accetto termini e condizioni sia stato selezionato
    const checkbox = document.querySelector('.allow input');
    formStatus[checkbox.name] = checkbox.checked;
    //controlla se sono stati compilati tutti e 8 i campi di input o che un campo non e stato compilato correttamente
    if (Object.keys(formStatus).length !== 8 || Object.values(formStatus).includes(false)) {
        //se almeno una delle condizioni sopra è verificata allora impredisce l'invio dell modulo con preventdefault
        event.preventDefault();
    }
}



const formStatus = {'upload': true};
document.querySelector('.name input').addEventListener('blur', VerifyName);
document.querySelector('.surname input').addEventListener('blur', VerifySurname);
document.querySelector('.username input').addEventListener('blur', VerifyUsername);
document.querySelector('.email input').addEventListener('blur', VerifyEmail);
document.querySelector('.password input').addEventListener('blur', VerifyPassword);
document.querySelector('.confirm_password input').addEventListener('blur', VerifyConfirmPassword);
document.querySelector('.register form').addEventListener('submit', VerifySignup);
