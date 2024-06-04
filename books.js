document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.books-form');
    if (form) {
        form.addEventListener('submit', search);
    } else {
        console.error("Elemento .books-form non trovato nel DOM");
    }
});

function search(event) {
    event.preventDefault();
    const author_input = document.querySelector('#author');
    const author_value = encodeURIComponent(author_input.value);
    console.log('Eseguo ricerca: ' + author_value);

    const rest_url = 'api_books.php?author=' + author_value;
    console.log('URL: ' + rest_url);

    fetch(rest_url).then(JsonResponse).then(onJson);
}

function JsonResponse(response) {
    if (!response.ok) {
        console.log("Error: " + response.statusText);
        alert("Ops, errore...");
        return null;
    } else {
        return response.json();
    }
}

function onError(error) {
    console.log('Error: ' + error);
}

function onJson(json) {
    if (!json) {
        console.log("Nessuna risposta");
        return;
    }
    console.log('JSON ricevuto');

    const booksView = document.querySelector('#result-view');
    booksView.innerHTML = '';

    if (json.docs.length === 0) {
        const noResultMessage = document.createElement('span');
        noResultMessage.classList.add('no-results');
        noResultMessage.textContent = 'Ops... Nessun risultato trovato per ' + document.querySelector('#author').value + '!';
        booksView.appendChild(noResultMessage);
        return;
    }

    let items = json.num_found;
    if (items > 10) items = 10;

    for (let i = 0; i < items; i++) {
        const doc = json.docs[i];
        const title = doc.title || 'Titolo non disponibile';
        const isbn = doc.isbn ? doc.isbn[0] : 'N/A';
        if(isbn!='N/A')
        {
            const publish_year = doc.publish_year ? doc.publish_year[0] : 'N/A';

            const cover_url = 'http://covers.openlibrary.org/b/isbn/' + isbn + '-M.jpg';
            const book = document.createElement('div');
            book.classList.add('book');

            const img = document.createElement('img');
            img.src = cover_url;
            img.addEventListener('click', apriModale);
            book.appendChild(img);

            const didascaly = document.createElement('h3');
            didascaly.textContent = title;
            book.appendChild(didascaly);

            const publishYearText = document.createElement('p');
            publishYearText.textContent = 'Anno di pubblicazione: ' + publish_year;
            book.appendChild(publishYearText);

            const price = document.createElement('p');
            price.textContent = 'Prezzo: ' + generaPrezzoCasuale();
            book.appendChild(price);

            const favoriteIcon = document.createElement('img');
            favoriteIcon.src = 'images/cuore.png';
            favoriteIcon.alt = 'Cuore';
            favoriteIcon.classList.add('favorite-icon');
            favoriteIcon.dataset.bookId = isbn; //id libro
            favoriteIcon.dataset.title = title; //titolo libro
            favoriteIcon.addEventListener('click', toggleFavorite);
        
            book.appendChild(favoriteIcon);
            fetch('checkfavoritebook.php?isbn=' +encodeURIComponent(String(isbn).toLowerCase())).then(result => fetchResponseFavorite(result, favoriteIcon), onError);

            const carrelloIcon = document.createElement('img');
            carrelloIcon.src = 'images/carrello_vuoto.png';
            carrelloIcon.alt = 'carrello_vuoto';
            carrelloIcon.classList.add('carrello');
            carrelloIcon.dataset.bookId = isbn; //id libro
            carrelloIcon.dataset.title = title; //titolo libro
            carrelloIcon.addEventListener('click', toggleCarrello);
            book.appendChild(carrelloIcon );
            fetch('checkcarrellobook.php?isbn=' +encodeURIComponent(String(isbn).toLowerCase())).then(result => fetchResponseCarrello(result, carrelloIcon), onError);

            booksView.appendChild(book);
        }
    }

    booksView.classList.add('show-background');
}

function fetchResponseFavorite(response,favoriteIcon) {
    return response.json().then(result =>verifybookFavorite(result,favoriteIcon));
}

function verifybookFavorite(result,favoriteIcon)
{
    console.log(result);
    if (result.red)
    {
        console.log("verifybook result rosso");
        favoriteIcon.classList.add('favorite');
        favoriteIcon.src='images/cuoreRosso.png';
    }
    else{
        console.log("verifybook result blu");
        favoriteIcon.classList.remove('favorite');
        favoriteIcon.src='images/cuore.png';
    }
    
}

function fetchResponseCarrello(response,favoriteIcon) {
    return response.json().then(result =>verifybookCarrello(result,favoriteIcon));
}

function verifybookCarrello(result,favoriteIcon)
{
    console.log(result);
    if (result.pieno)
    {
        console.log("verifybook result pieno");
        favoriteIcon.classList.add('carrello');
        favoriteIcon.src='images/carrello_pieno.png';
    }
    else{
        console.log("verifybook result vuoto");
        favoriteIcon.classList.remove('carrello');
        favoriteIcon.src='images/carrello_vuoto.png';
    }
    
}



function apriModale(event) {
    const img = document.createElement('img');
    img.id = 'immagine_post';
    img.src = event.currentTarget.src;
    console.log(event.currentTarget.src);
    const modale = document.querySelector('#modale');
    modale.appendChild(img);
    modale.classList.remove('hidden');
    document.body.classList.add('no-scroll');
}

document.addEventListener('DOMContentLoaded', function() {
    const modale = document.querySelector('#modale');
    modale.addEventListener('click', chiudiModale);
});

function chiudiModale(event) {
    console.log(event);
    const modale = document.querySelector('#modale');
    modale.classList.add('hidden');
    const img = modale.querySelector('img');
    img.remove();
    document.body.classList.remove('no-scroll');
}

//genera prezzo casuale
function generaPrezzoCasuale() {
    return (Math.random() * (50 - 10) + 10).toFixed(2) + ' €';
}



//questa funzione viene utilizzata per aggiungere o rimuovere un libro dalla lista dei preferiti di un utente.
function toggleFavorite(event) {
    const icon = event.currentTarget;
    const isbn = icon.dataset.bookId;
    const title=icon.dataset.title;
    const cover_url='http://covers.openlibrary.org/b/isbn/' + isbn + '-M.jpg';
   console.log(cover_url);
    const formData = new FormData();;
    formData.append('isbn',isbn);
    formData.append('title',title);
    formData.append('cover_url',cover_url);


    if (icon.classList.contains('favorite')) {

        fetch('remove_favorite.php', {method: 'post', body: formData}).then(result => dispatchResponseRemove(result, icon), onError);
    } else {
       
        fetch('add_favorite.php', {method: 'post', body: formData}).then(result => dispatchResponseAdd(result, icon), onError);

    }
}
function dispatchResponseAdd(response,icon) {
    console.log(response);
    return response.json().then(risultato =>databaseResponseAdd(risultato,icon));
  }


  function dispatchResponseRemove(response,icon) {
    console.log(response);
    return response.json().then(risultato =>databaseResponseRemove(risultato,icon));
  }


  function databaseResponseAdd(result,icon) {
    if (result.ok) {    
        console.log("databaseresponse result ok");
        icon.classList.add('favorite');
        icon.src = 'images/cuoreRosso.png'; // Cambia l'immagine del cuore al colore rosso
        updateFavoritesList();
    }
}

function databaseResponseRemove(result,icon) {
    if (result.ok) {    
        console.log("databaseresponse result ok");
        icon.classList.remove('favorite');
        icon.src = 'images/cuore.png'; // Cambia l'immagine del cuore al cuore originale
        updateFavoritesList();
    }
}


//questa funzione viene utilizzata per aggiungere o rimuovere un libro dal carrello di un utente.
function toggleCarrello(event) {
    const icon = event.currentTarget;
    const isbn = icon.dataset.bookId;
    const title=icon.dataset.title;
    const cover_url='http://covers.openlibrary.org/b/isbn/' + isbn + '-M.jpg';
    console.log(cover_url);
    const formData = new FormData();;
    formData.append('isbn',isbn);
    formData.append('title',title);
    formData.append('cover_url',cover_url);

    if (icon.classList.contains('carrello')) {
        fetch('remove_book_carrello.php', {method: 'post', body: formData}).then(result => dispatchResponseCarrelloRemove(result, icon), onError);
    } else {
        fetch('add_book_carrello.php', {method: 'post', body: formData}).then(result => dispatchResponseCarrelloAdd(result, icon), onError);
    }
}
function dispatchResponseCarrelloAdd(response,icon) {
    console.log(response);
    return response.json().then(risultato =>databaseResponseCarrelloAdd(risultato,icon));
  }


  function dispatchResponseCarrelloRemove(response,icon) {
    console.log(response);
    return response.json().then(risultato =>databaseResponseCarrelloRemove(risultato,icon));
  }


  function databaseResponseCarrelloAdd(result,icon) {
    if (result.ok) {    
        console.log("databaseresponse result ok");
        icon.classList.add('carrello');
        icon.src = 'images/carrello_pieno.png'; // Cambia l'immagine del carrello pieno
        updateCarrelloList();
    }
}

function databaseResponseCarrelloRemove(result,icon) {
    if (result.ok) {    
        console.log("databaseresponse result ok");
        icon.classList.remove('carrello');
        icon.src = 'images/carrello_vuoto.png'; // Cambia l'immagine del carrello vuoto
        updateCarrelloList();
    }
}

function updateFavoritesList() {
    
fetch('get_favorites.php', {method: 'post'}).then(res => dispatchResponseListbook(res), onError);
}

function dispatchResponseListbook(risultato){
    console.log("sonodentro la dispatchResponseListbook",risultato);
    return risultato.json().then(result=>addListbook(result));
}

function addListbook(response){
    console.log("sono dentro l'addlist",response);
    if(response.ok)
    {
        const preferitiList = document.querySelector('#preferiti-list');
        preferitiList.innerHTML = ''; // Svuota la lista attuale

        // Aggiungi i nuovi libri preferiti alla lista
        data.forEach(book => {
        const listItemtitle = document.createElement('div');
        listItemtitle.textContent = book.titolo;
        listItemtitle.classList.add('book-title'); // Aggiungi la classe per lo stile del titolo
        preferitiList.appendChild(listItemtitle);
        

        });
    }
}

function updateCarrelloList() {
    
    fetch('get_books_carrello.php', {method: 'post'}).then(res => dispatchResponseListbookCarrello(res), onError);
    }
    
    function dispatchResponseListbookCarrello(risultato){
        console.log("sonodentro la dispatchResponseListbookCarrello",risultato);
        return risultato.json().then(result=>addListbookCarrello(result));
    }
    
    function addListbookCarrello(response)
    {console.log("sono dentro l'addlist carrello",response);
    if(response.ok)
    {
        const preferitiList = document.querySelector('#books-carrello-list');
        preferitiList.innerHTML = ''; // Svuota la lista attuale
    
        // Aggiungi i nuovi libri del carrello alla lista
        data.forEach(book => {
            
        const listItemtitle = document.createElement('div');
        listItemtitle.textContent = book.titolo;
        listItemtitle.classList.add('book-title'); // Aggiungi la classe per lo stile del titolo
        preferitiList.appendChild(listItemtitle);
    
    
        });
    }


}
        
       