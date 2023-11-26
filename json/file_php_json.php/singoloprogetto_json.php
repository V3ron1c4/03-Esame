<?php

$file2JSON = "singoloprogetto.json";


/* Creo questa parte così se vorrò creare le pagine per gli altri progetti 
posso copiare e mofidicare solo titolo, testo */
$h3Titolo = "Progetto Centro Commerciale";
$testoProgettoSingolo = "Sito internet dinamico per un centro commerciale. <br> Mi sono occupata dello sviluppo del
template grafico, della struttura delle pagine e della versione responsive.";


/**
 * Funzione per leggere del testo da un file JSON
 */
function leggiTestoJSON($fileJSON)
{
    if (file_exists($fileJSON)) {
        if (file_get_contents($fileJSON)) {
            echo "Questo file $fileJSON è leggibile.<br>";
        } else {
            echo "Questo file $fileJSON non è leggibile.<br>";
        }
    } else {
        echo "Questo file $fileJSON non esiste.<br>";
    }
    return $fileJSON;
}

$jsonData2 = file_get_contents($file2JSON);
$json2 = json_decode($jsonData2, true);
$output = array_slice($json2, 0, 4);
$output2 = array_slice($json2, 4, 4);

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
        <div class="display-singoloprogetto">

            <?php

            foreach ($output as $value) {
                printf(
                    '<div class="singolo-progetto">
                <a href="%s?selezionato=%u%s" class="progetto" title="%s">
                <img class="img-progetto" src="%s" alt="%s"></a></div>',
                    $value['url'],
                    $value['id'],
                    $value['anchor'],
                    $value['title'],
                    $value['urlimg'],
                    $value['alt']
                );
            }
            ?>

            <div class="singolo-progetto">
                <div class="singoloprogetto-testo">
                    <p><?php echo $testoProgettoSingolo; ?></p>
                </div>
            </div>

            <?php

            foreach ($output2 as $value) {
                printf(
                    '<div class="singolo-progetto">
                <a href="%s?selezionato=%u%s" class="progetto" title="%s">
                <img class="img-progetto" src="%s" alt="%s"></a></div>',
                    $value['url'],
                    $value['id'],
                    $value['anchor'],
                    $value['title'],
                    $value['urlimg'],
                    $value['alt']
                );
            }
            ?>

        </div>
    </div>

</main>

<!-- Footer -->
<?php require("footer.php"); ?>
<!-- Footer -->