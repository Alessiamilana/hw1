
document.addEventListener('DOMContentLoaded', function() {
    updateFavoritesList();
});
console.log('sono fuori la update');




function onError(error) {
    console.log('Error: ' + error);
}   


function updateFavoritesList() {
    console.log('sono dentro la update');
    fetch('get_favorites.php', {method: 'post'}).then(res => dispatchResponseListbook(res), onError);
    }

    function dispatchResponseListbook(risultato){
        console.log(risultato);
        return risultato.json().then(result=>addListbook(result));
    }

    function addListbook(response)
    {
        if(response) 
        {
            const preferitiList = document.querySelector('#preferiti-list');
            preferitiList.innerHTML = ''; 
    
            response.forEach(book => {
                const listItemContainer = document.createElement('div'); 
                listItemContainer.classList.add('book-item'); 
    
                const listItemtitle = document.createElement('div');
                listItemtitle.textContent = book.titolo;
                listItemtitle.classList.add('book-title'); 

                const listItemImage = document.createElement('img');
                listItemImage.src = book.copertina; 
                listItemImage.classList.add('book-image'); 

                listItemContainer.appendChild(listItemtitle);
                listItemContainer.appendChild(listItemImage);
    
                preferitiList.appendChild(listItemContainer);
            });
        }
    }
    



 