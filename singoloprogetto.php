<?php

/* Creo questa parte così se vorrò creare le pagine per gli altri progetti 
posso copiarla e mofidicare solo titolo, testo */
$h3Titolo = "Progetto Centro Commerciale";
$testoProgettoSingolo = "Sito internet dinamico per un centro commerciale. <br> Mi sono occupata dello sviluppo del
template grafico, della struttura delle pagine e della versione responsive.";


?>

<!-- Head -->
<?php require("head.php"); ?>
<!-- Head -->

<!-- Header -->
<?php require("header.php"); ?>
<!-- Header -->
<main class="main-container">
    <div class="section-container" id="progetto">
        <h3 class="main-testo"><?php echo $h3Titolo; ?></h3>
    </div>
    <div class="progettosingolo">
        <div class="display-singoloprogetto" id="singoloProgettoContainer">
            <div class="singolo-progetto">
                <div class="singoloprogetto-testo">
                    <p><?php echo $testoProgettoSingolo; ?></p>
                </div>
            </div>
        </div>
        
        <script src="singoloprogetto.js"></script>
    </div>
</main>

<!-- Footer -->
<?php require("footer.php"); ?>
<!-- Footer -->