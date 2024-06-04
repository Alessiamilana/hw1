
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#acquisto-form");

    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Previeni l'invio del form

        // Recupera i valori dei campi del form
        const cardOwnerName = document.querySelector("#card_owner_name").value;
        const cardOwnerSurname = document.querySelector("#card_owner_surname").value;
        const email = document.querySelector("#email").value;
        const numberCard= document.querySelector("#card_number").value;
        const expiryDate = document.querySelector("#expiry_date").value;
        const pin = document.querySelector("#pin").value;
        


        // Validazione del nome e del cognome
        const namePattern = /^[a-zA-Z]+$/;
        if (!namePattern.test(cardOwnerName)) {
            alert("Inserisci un nome valido");
            return;
        }

        if (!namePattern.test(cardOwnerSurname)) {
            alert("Inserisci un cognome valido");
            return;
        }


             // Validazione dell'email
             const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
             if (!emailPattern.test(email)) {
                 alert("Inserisci un email valida");
                 return;
             }


                // Validazione del numero della carta
        const cardNumberPattern = /^[0-9]{16}$/;
        if (!cardNumberPattern.test(numberCard)) {
            alert("Inserisci un numero di carta valido (deve contenere 16 numeri)");
            return;
        }


          // Validazione della data di scadenza della carta
          const expiryPattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
          if (!expiryPattern.test(expiryDate)) {
          alert("Inserisci una data di scadenza valida");
              return;
          }
  
     
        // Validazione del PIN della carta
        const pinPattern = /^[0-9]{3}$/;
        if (!pinPattern.test(pin)) {
            alert("Inserire un CVC della carta valido (deve contenere 3 numeri)");
            return;
        }
      
        console.log("ciao2");
        // Invio del form se tutti i campi sono validi
       
        console.log("ciao3");
    });
});