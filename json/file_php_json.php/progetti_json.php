<!-- Progetti -->
<?php
$file1JSON = "portfolio.json";


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

$jsonData1 = file_get_contents($file1JSON);
$json1 = json_decode($jsonData1, true);

?>


<div class="section-container" id="progetti">
    <h3 class="main-testo">Progetti</h3>
</div>
<div class="miei-progetti">
    <div class="display-main">

        <?php

        foreach ($json1 as $value) {
            printf('<div class="singolo-progetto"><div class="testo-mini-progetti">%s</div><a href="%s?selezionato=%s%s" class="progetto" title="Clicca per vedere il progetto"><img class="img-progetto" src="%s" alt="%s"></a></div>',
            $value['nome'], 
            $value['url'], 
            $value['nome'], 
            $value['anchor'], 
            $value['urlimg'], 
            $value['alt']);
        }
        ?>

        
    </div>
</div>
<!-- Progetti -->