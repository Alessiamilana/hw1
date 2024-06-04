
document.addEventListener('DOMContentLoaded', function() {
    updateCarrelloList();
});
console.log('sono fuori la update');




function onError(error) {
    console.log('Error: ' + error);
}   


function updateCarrelloList() {
    console.log('sono dentro la update');
    fetch('get_books_carrello.php', {method: 'post'}).then(res => dispatchResponseListbook(res), onError);
    }

    function dispatchResponseListbook(risultato){
        console.log(risultato);
        return risultato.json().then(result=>addListbook(result));
    }

    function addListbook(response)
    {
        if(response) 
        {
            const carrelloList = document.querySelector('#books-carrello-list');
            carrelloList.innerHTML = ''; 
    
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
              
    
                carrelloList.appendChild(listItemContainer);
            });
        }
    }
    



 