document.addEventListener('DOMContentLoaded', function () {
    const portfolioContainer = document.getElementById("portfolioContainer");

    // Effettua una richiesta al tuo server per ottenere i dati del portfolio
    fetch('get_portfolio.php')
        .then(response => response.json())
        .then(portfolioData => {
            portfolioData.forEach(item => {
                const singoloProgetto = document.createElement("div");
                singoloProgetto.className = "singolo-progetto";

                const testoMiniProgetti = document.createElement("div");
                testoMiniProgetti.className = "testo-mini-progetti";
                testoMiniProgetti.textContent = item.nome;

                const progettoLink = document.createElement("a");
                progettoLink.href = item.url;
                progettoLink.className = "progetto";
                progettoLink.title = item.title;

                const img = document.createElement("img");
                img.className = "img-progetto";
                img.src = item.urlimg;
                img.alt = item.alt;

                progettoLink.appendChild(img);
                singoloProgetto.appendChild(testoMiniProgetti);
                singoloProgetto.appendChild(progettoLink);
                portfolioContainer.appendChild(singoloProgetto);
            });
        })
        .catch(error => console.error('Errore durante il recupero dei dati del portfolio:', error));
});
