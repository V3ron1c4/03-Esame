document.addEventListener('DOMContentLoaded', function () {
    const singoloProgettoContainer = document.getElementById("singoloProgettoContainer");

    // Effettua una richiesta al server per ottenere i dati del singolo progetto
    fetch('get_singolo_progetto.php')
        .then(response => response.json())
        .then(singoloProgettoData => {
            singoloProgettoData.forEach(item => {
                // Crea gli elementi HTML per visualizzare i dati del singolo progetto
                const singoloProgetto = document.createElement("div");
                singoloProgetto.className = "singolo-progetto";

                const singoloProgettoLink = document.createElement("a");
                singoloProgettoLink.href = item.url;
                singoloProgettoLink.className = "progetto";
                singoloProgettoLink.title = item.title;


                const imgElement = document.createElement("img");
                imgElement.className = "img-progetto";
                imgElement.src = item.urlimg;
                imgElement.alt = item.alt;

                singoloProgettoLink.appendChild(imgElement);
                singoloProgetto.appendChild(singoloProgettoLink);
                singoloProgettoContainer.appendChild(singoloProgetto);
            });
        })
        .catch(error => console.error('Errore durante il recupero dei dati del singolo progetto:', error));
});