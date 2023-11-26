<?php
//COOKIE
$default = [
    'nome' => '',
    'cognome' => '',
    'email' => '',
 ];

$_POST = array_replace( $default, $_POST );

$cookieName = "userName";
$cookieNameValue = $_POST['nome'];
$cookieSurname = "userSurname";
$cookieSurnameValue = $_POST['cognome'];
$cookieEmail = "userEmail";
$cookieEmailValue = $_POST['email'];
$scadenza = strtotime("+1 day");

setcookie($cookieName, $cookieNameValue, $scadenza);
setcookie($cookieSurname, $cookieSurnameValue, $scadenza);
setcookie($cookieEmail, $cookieEmailValue, $scadenza);

?>
<!-- Head -->
<?php require("head.php"); ?>
<!-- Head -->

<!-- Header -->
<?php require("header.php"); ?>
<!-- Header -->

<!-- Main -->
<main class="main-container">
    <div class="display-container" id="home">
        <img class="img-home" src="./img/img-display.jpg" alt="Lavanda">
        <div class="display-middle">
            <h1 class="display-scritta">
                <span class="logo-mini"><b>VV</b></span>
                <span class="testo-mini">Web Developer Freelance</span>
            </h1>
        </div>
    </div>

    <!-- Chi sono -->
    <?php require("chisono.php"); ?>
    <!-- Chi sono -->

    <!-- Progetti -->
    <?php require("progetti.php"); ?>
    <!-- Progetti -->

    <!-- Contatti -->
    <?php require("contatti.php"); ?>
    <!-- Contatti -->

    <!-- Footer -->
    <?php require("footer.php"); ?>
    <!-- Footer -->