document.addEventListener('DOMContentLoaded', function () {
    // Prendi i dati dal database riguardo il menu
    fetch('get_menu.php')
        .then(response => response.json())
        .then(menuData => {

            const menuContainer = document.getElementById('menu');
            const menuBtn = document.getElementById('menu-btn');

            menuData.forEach(item => {
                const menuItem = document.createElement('li');
                const menuLink = document.createElement('a');
                menuLink.href = item.url;
                menuLink.textContent = item.nome;
                menuItem.appendChild(menuLink);
                menuContainer.appendChild(menuItem);

                // Listener per chiudere il menu al clic su un elemento
                menuLink.addEventListener('click', () => {
                    menuBtn.checked = false; // Chiudi il menu
                    location.reload(); // Ricarica la pagina
                });
            });
        })
        .catch(error => console.error('Errore durante il recupero dei dati del menu:', error));


});