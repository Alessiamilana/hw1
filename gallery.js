
//1. utenticazione OAUTH2.0
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
   const apiEndpoint = 'api_gallery.php?artist_id=' + encodeURIComponent(artistName);
            console.log('API Endpoint:', apiEndpoint); // Log dell'URL per il debug

            fetch(apiEndpoint)
                .then(JsonResponse)
                .then(onJson1)
                .then(null, onError); // Gestione degli errori qui
    }
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


function onJson1(json) {
  // Serve per verificare che la risposta ricevuta è nulla
  if (!json || !json._embedded || !json._embedded.artworks) {
      console.log("Risposta non trovata");
      return;
  } else {
      console.log('JSON ricevuto');
  }

  // Svuoto la galleria
  const gallery = document.querySelector('#result-view');
  gallery.innerHTML = '';

  // Processo le opere d'arte dell'artista
  const artworks = json._embedded.artworks;
  artworks.forEach(artwork => {
      // Creo un elemento per l'opera d'arte
      const artworkElement = document.createElement('div');
      artworkElement.classList.add('artwork');

      // Verifica che l'oggetto artwork contenga la proprietà _links.thumbnail
      if (artwork._links && artwork._links.thumbnail && artwork._links.thumbnail.href) {
          // L'URL dell'immagine è ottenuto da uno degli elementi di
          const imageUrl = artwork._links.thumbnail.href;
          const image = document.createElement('img');
          image.src = imageUrl;
          image.addEventListener('click', apriModale);
          artworkElement.appendChild(image);
      }

      // Aggiungo informazioni sull'opera d'arte
      const title = document.createElement('h3');
      title.textContent = artwork.title || "Titolo non disponibile"; // Assicurati che artwork.title sia definito
      artworkElement.appendChild(title);

      // Aggiungo l'opera d'arte alla galleria
      gallery.appendChild(artworkElement);
  });

  // Aggiungo una classe per mostrare lo sfondo bianco
  gallery.classList.add('show-background');
}
//in sintesi il js Fa le richieste fetch ai file PHP api_token.php e api_artist.php.



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