//1. richiesta js al php
// Aggiungi l'URL al file PHP
const phpEndpoint = 'api_sculptures.php'; // Assicurati che il percorso sia corretto

// seleziona tutti gli elementi della lista
const sculpturListItems = document.querySelectorAll('#sculptur li');

// Aggiungi un event listener a ciascun elemento
sculpturListItems.forEach(item => {
    item.addEventListener('click', searchSculptures);
});

function searchSculptures(event) {
    // Impedisco il comportamento di default di caricamento della pagina
    event.preventDefault();

    // Leggo il valore del campo di testo
    const sculpturName = this.getAttribute('value');
    console.log('Eseguo ricerca per:', sculpturName);

    // Preparo la richiesta all'endpoint PHP
    const restUrl = phpEndpoint + '?query=' + encodeURIComponent(sculpturName);
    console.log('URL: ' + restUrl);

    // Eseguo fetch all'endpoint php
    fetch(restUrl)
         .then(JsonResponse) // Utilizza JsonResponse per gestire la risposta
         .then(onJson2)
}

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

function onJson2(json) {
    // Serve per verificare che la risposta ricevuta è nulla
    if (!json) {
        console.log("Nessuna risposta");
        return;
    }
    console.log('JSON ricevuto');

    // Svuoto la visualizzazione delle sculture
    const sculpturesView = document.querySelector('#result-view');
    sculpturesView.innerHTML = '';

    const items = json.items;
    items.forEach(item => {
        // Creo un elemento per l'opera d'arte
        if (item.edmIsShownBy) {
            console.log("Aggiungo classe sculpture");
            const itemElement = document.createElement('div');
            itemElement.classList.add('sculpture');

            // L'URL dell'immagine è ottenuto da edmIsShownBy nell'oggetto item
            const imageUrl = item.edmIsShownBy[0]; // Uso il primo URL disponibile
            const image = document.createElement('img');
            image.src = imageUrl;
            console.log("Aggiungo al click => aprimodale");
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


//La funzione searchSculptures fa una richiesta al file PHP con la query appropriata.
//Il file PHP esegue la richiesta all'API di Europeana e restituisce i dati.
//Il JavaScript riceve questi dati e li elabora per visualizzare le sculture.
//Questo approccio migliora la sicurezza poiché la chiave API è mantenuta sul server,
// non esposta nel client-side, e risolve potenziali problemi di CORS poiché le richieste API 
//sono fatte dal server.
