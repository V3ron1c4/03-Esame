<?php
$cellulare = "(+39) 3388346897";
$email = "veronica.vitale.4@gmail.com";
$posizione = "Frascati 00044 (RM)";
$testoSocialMedia = "Seguimi sui social media per vedere parte dei miei lavori.";
?>

<section>
    <footer class="top">
        <div class="logo">
            <a href="#home" class="logomini-menu" title="Clicca per tornare alla home"><b>VV</b></a>
            <a href="#home" class="logo-menu" title="Clicca per tornare alla home">v3ron1c4 v1t4l3</a>
        </div>
        <div class="footer-contatti">
            <div class="contacts">
                <h2> Contatti </h2>
                <a> <?php echo $cellulare; ?> </a>
                <a> <?php echo $email; ?> </a>
                <a> <?php echo $posizione; ?> </a>
            </div>
            <div class="contacts socials">
                <h2>Social Media</h2>
                <p><?php echo $testoSocialMedia; ?></p>
                <div class="icone-socials">
                    <a href="http://www.instagram.com" title="Clicca per seguirmi su Instagram"><img src="./img/img-ig.png"
                                alt="Logo Instagram"></a>
                    <a href="http://www.facebook.com" title="Clicca per seguirmi su Facebook"><img src="./img/img-fb.png"
                                alt="Logo Facebook"></a>
                    <a href="http://www.youtube.com" title="Clicca per seguirmi su Youtube"><img src="./img/img-yt.png"
                                alt="Logo Youtube"></a>
                </div>
            </div>
        </div>
    </footer>
    <footer class="bottom">
        <p class="copyright"><?php echo "©" . date("Y") . " All rights reserved."; ?></p>
        <div class="legal">
            <a href="#" title="Clicca per la licenza"> Licenza </a>
            <a href="#" title="Clicca per i termini"> Termini </a>
            <a href="#" title="Clicca per la privacy"> Privacy policy</a>
            <a href="#" title="Clicca per i cookies"> Cookie policy </a>
        </div>
    </footer>
</section>
</body>

</html>