<!-- Contatti -->
<?php
$testoContatti = "Non esitare a contattarmi per avere maggiori informazioni
    e/o raccontarmi il tuo progetto. <br>Oppure compila il
    modulo sottostante e ti ricontatterò io il prima possibile.";
$cellulare = "(+39) 3388346897";
$email = "veronica.vitale.4@gmail.com";
$posizione = "Frascati 00044 (RM)";
?>

<div class="section-container" id="contatti">
        <h3 class="main-testo">Contatti</h3>
</div>
<div class="contatti-testo">
        <p><?php echo $testoContatti; ?></p>
</div>

<!-- Recapiti -->
<div class="span-contatti">
        <span class="contatti"><img class="icone-contatti" src="./img/img-telefono.png" alt="cellulare"><?php echo $cellulare; ?></span>
        <span class="contatti"><img class="icone-contatti" src="./img/img-email.png" alt="email"><?php echo $email; ?></span>
        <span class="contatti"><img class="icone-contatti" src="./img/img-posizione.png" alt="posizione"><?php echo $posizione; ?></span>
</div>
<!-- Recapiti -->

<div class="form-mappa" id="form">
        <div class="contatti-mappa">

                <!-- Form -->
                <?php require("form.php"); ?>
                <!-- Form -->

                <div class="mappa">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d23787.684600089873!2d12.68453847320435!3d41.818379527325966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sit!2sit!4v1693871299526!5m2!1sit!2sit" loading="lazy">
                        </iframe>
                </div>
        </div>
</div>
<!-- Contatti -->

</main>