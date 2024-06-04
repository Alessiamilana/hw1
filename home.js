
/*1*/
const logoMano = document.querySelector('#logo-mano img'); /* seleziono l immagine all interno dell id logo-fb*/
logoMano.addEventListener('click', CambiaImmagine); /*in modo che quando l utente clicca sull immagine, viene chiamata la funzione CambiaImmgine*/


function CambiaImmagine(event) { /* viene eseguita quando l utente clicca sull immagine*/
    const image = event.currentTarget;
    image.removeEventListener('click', CambiaImmagine); /*rimuoviamo l eventListener per evitare che la funzione venga eseguita piu volte*/

    const logoMano = document.querySelector('#logo-mano'); /*seleziono l elemento con logo fb */
    const logoEmoij = document.querySelector('#logo-emoij'); /*seleziono elemento con logo insta*/

    logoMano.classList.add('hidden'); /*nascondo il logo fb quando clicco il logo, aggiungendo la classe hidden*/
    logoEmoij.classList.remove('hidden'); /*mostro il logo instagram rimuovendo la classe hidden*/
}





/*2*/
// Seleziona lo span "Privacy Policy" nel footer
const privacyPolicy = document.querySelector('footer span:nth-child(2)'); // Seleziona il secondo span nel footer
// Aggiungi un gestore di eventi per il clic sullo span "Privacy Policy"
privacyPolicy.addEventListener('click',reindirizzamento);


function reindirizzamento(event){
    const privacyPolicy = event.currentTarget;
    privacyPolicy.removeEventListener('click', CambiaImmagine);
        // Reindirizza alla pagina della privacy policy
    window.location.href = 'https://www.nicolettaceccoli.com/privacy-policy/'; // Sostituisci con l'URL della tua pagina della privacy policy
    }






/*3*/
document.addEventListener('DOMContentLoaded', function() { //si accerta che prima venga caricato interamente il documento html prima che lo script.js venga eseguito
    // Seleziono il footer
    var footer = document.querySelector('footer');
    var div = document.createElement('div');
    div.id = 'bottone';

    var testo = document.createElement('button');
    testo.textContent = 'mostra di piu';
    div.appendChild(testo);
    footer.appendChild(div);
    div.addEventListener('click', clickbutton);
});
    function clickbutton(event){
        const footer = event.currentTarget;
        footer.removeEventListener('click', clickbutton);
        var ulterioriInformazioni = document.createElement('p');
        ulterioriInformazioni.textContent = 'questo sito è stato creato da Alessia Milana';
        footer.appendChild(ulterioriInformazioni);

        // rimuovo il pilsante mostra di piu quando clicco
        div.style.display = 'none';
    }






 /*4*/   

setInterval(cambiaImmagineDiSfondo, 3000); //cambia l immagine di sfondo ogni 3s: SrtInterval è una funzione di sistema
let currentIndex = 0;
const immagini = [ //lista
    'url("images/van-gogh.jpg")',
    'url("images/monet.jpg")',
    'url("images/Vangogh.jpg")', 
    'url("images/klimt.jpg")'  
];

// Funzione per cambiare l'immagine di sfondo
function cambiaImmagineDiSfondo() {
    const body = document.body;
    body.style.backgroundImage = immagini[currentIndex];
    currentIndex = (currentIndex + 1) % immagini.length; // Avanza all'immagine successiva, ripartendo dall'inizio quando raggiungi la fine
}



//5
const navElement = document.getElementById('services'); // Seleziona l'elemento con id "services"

navElement.addEventListener('mouseover', MouseOver);
navElement.addEventListener('mouseout', MouseOut);

function MouseOver(event) {
    const menu = event.currentTarget.querySelector('.menu');
    if (menu) {
        menu.style.display = 'block';
    }
}

function MouseOut(event) {
    const menu = event.currentTarget.querySelector('.menu');
    if (menu) {
        menu.style.display = 'none';
    }
}




/*
//CODICE VECCHIO
//6. utenticazione OAUTH2.0
function onJson1(json) {
  //serve per verificare che la risposta ricevuta è nulla
  if(!json){
    console.log("risposta non trovata");
    return;
  }
  else console.log('JSON ricevuto');
  // Svuoto la galleria
  const gallery = document.querySelector('#result-view');
  gallery.innerHTML = '';

  // Processo le opere d'arte dell'artista
  const artworks = json._embedded.artworks;
  artworks.forEach(artwork => {
      // Creo un elemento per l'opera d'arte
      const artworkElement = document.createElement('div');
      artworkElement.classList.add('artwork');


      // L'URL dell'immagine è ottenuto da uno degli elementi di
      const imageUrl = artwork._links.thumbnail.href;
      const image = document.createElement('img');
      image.src = imageUrl;
      image.addEventListener('click', apriModale);
      artworkElement.appendChild(image);

       // Aggiungo informazioni sull'opera d'arte
       const title = document.createElement('h3');
       title.textContent = artwork.title;
       artworkElement.appendChild(title);

      // Aggiungo l'opera d'arte alla galleria
      gallery.appendChild(artworkElement);
  });
     // Aggiungo una classe per mostrare lo sfondo bianco
     gallery.classList.add('show-background');
}



   const artistListItems = document.querySelectorAll('#artist li');
   artistListItems.forEach(item => {
    item.addEventListener('click',searchartist)
    function searchartist(event) {
      // Impedisco il comportamento predefinito del link
      event.preventDefault(); 
      // Ottengo il valore dell'elemento cliccato
      const artistName = this.getAttribute('value');
      console.log('Eseguo ricerca per:', artistName);
   
   // Effettuo una richiesta per ottenere le opere dell'artista
   fetch("https://api.artsy.net/api/artworks?artist_id=" + encodeURIComponent(artistName), 
    {
      headers:
      {
        'X-Xapp-Token':  token //gli passo il token
      }
    }
   )
   .then(JsonResponse,onError)
   .then(onJson1)

  };
});


function JsonResponse(response) {
  //serve per gestire l'errore 404(file non trovato) che non viene gestito con la 'Onerror'
  if(!response.ok){
    console.log("error:"+ response);
    alert("Ops, errore...");
    return null;
  } 
  else return response.json();
}

function onError(error){
console.log('Error: ' + error);

}

function onTokenJson(json) {
  // Imposto il token globale
  token = json.token;

}


// OAuth credentials
const client_id = '3ef19451e3018877e118';
const client_secret = 'abeecbde8b8ec852a77efbb5c47aba93';
let token;
// All'apertura della pagina, richiedo il token
fetch("https://api.artsy.net/api/tokens/xapp_token?client_id="+client_id+"&client_secret="+client_secret, {
  method: "post",
})
  .then(JsonResponse,onError)
  .then(onTokenJson);

*/




/* CODICE VECCHIO
  //7. autenticazione api key
  const api_key=' ineousionjo';
  const sculpturListItems = document.querySelectorAll('#sculptur li');
  sculpturListItems.forEach(item => {
  item.addEventListener('click',searchSculptures)
});
  
  
function searchSculptures(event) {
  // Impedisco il comportamento di default
  event.preventDefault();
  // Leggo il valore del campo di testo
  const sculpturName = this.getAttribute('value');
  console.log('Eseguo ricerca per:', sculpturName);
  // Preparo la richiesta
  const restUrl = 'https://api.europeana.eu/record/search.json?query=' + sculpturName + '&wskey=' + api_key;
  console.log('URL: ' + restUrl);
  // Eseguo fetch
  fetch(restUrl)
    .then(JsonResponse,onError)
    .then(onJson2)
    

};


function onJson2(json) {
  //serve per verificare che la risposta ricevuta è nulla
  if(!json){
    console.log("nessuna risposta");
    return;
  }
  console.log('JSON ricevuto');
  // Svuoto la visualizzazione delle sculture
  const sculpturesView = document.querySelector('#result-view');
  sculpturesView.innerHTML = '';
  const items = json.items;
  items.forEach(item => {
    // Creo un elemento per l'opera d'arte
    if(item.edmIsShownBy)
    {
    console.log("Aggiungo classe sculpture");
    const itemElement = document.createElement('div');
    itemElement.classList.add('sculpture');

    // L'URL dell'immagine è ottenuto da edmIsShownBy nell'oggetto item
    const imageUrl = item.edmIsShownBy[0]; // Uso il primo URL disponibile
    const image = document.createElement('img');
    image.src = imageUrl;
    console.log("aggiungo  al click => aprimodale");
    image.addEventListener('click', apriModale);

    itemElement.appendChild(image);

    // Aggiungo il titolo dell'opera d'arte
    const title = document.createElement('h3');
    title.textContent = item.title[0]; // Uso il primo titolo disponibile
    itemElement.appendChild(title);

    // Aggiungo l'opera d'arte alla visualizzazione delle sculture
    sculpturesView.appendChild(itemElement);

  }
  });
  // Aggiungo una classe per mostrare lo sfondo
  sculpturesView.classList.add('show-background');
}

//al click di uno dei contenuti trovati chiamo la funzione'apriModale'
function apriModale(event) {
  console.log("sono nell apri modale");
	//creo un nuovo elemento img
	const image = document.createElement('img');
	//setto l'ID di questo img come immagine_post, a cui attribuisco alcune caratteristiche CSS
	image.id = 'immagine_post';
	//associo all'attributo src, l'src cliccato
	image.src = event.currentTarget.src;
  console.log(event.currentTarget.src);
	//appendo quest'immagine alla view modale
	modale.appendChild(image);
	//rendo la modale visibile
	modale.classList.remove('hidden');
	//blocco lo scroll della pagina
	document.body.classList.add('no-scroll');
};

const modale = document.querySelector('#modale');
//creo il pulsante per la chiusura del post 
modale.addEventListener('click', chiudiModale);

function chiudiModale(event) {
	console.log(event);
  //aggiungo la classe hidden 
  console.log(modale);
  modale.classList.add('hidden');
  //prendo il riferimento dell'immagine dentro la modale
  img = modale.querySelector('img');
  //e la rimuovo 
  img.remove();
  //riabilito lo scroll
  document.body.classList.remove('no-scroll');
}
*/

 // Aspetta che il DOM sia completamente caricato
    document.addEventListener('DOMContentLoaded', function() {
        // Seleziona il pulsante di chiusura
        const closeButton = document.getElementById('close-button');
        // Aggiungi un gestore di eventi per il clic sul pulsante di chiusura
        closeButton.addEventListener('click', function() {
            // Nascondi il messaggio di stato
            document.getElementById('status-message').style.display = 'none';
        });
    });