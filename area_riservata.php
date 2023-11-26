<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Riservata</title>
    <link rel="stylesheet" href="./css/stile_area_riservata.css" type="text/css">
</head>

<body>
    <h1>AREA RISERVATA</h1>
    <div class="menu-areaRis" id="home_areaRis">
        <ul>
            <li><a href="area_riservata.php#utenti" class="a-areaRis" title="Clicca per andare nella sezione gestione degli utenti/admin">GESTISCI_LOGIN</a></li>
            <li><a href="area_riservata.php#menu" class="a-areaRis" title="Clicca per andare nella sezione gestione del menu">GESTISCI_MENU</a></li>
            <li><a href="area_riservata.php#portfolio" class="a-areaRis" title="Clicca per andare nella sezione gestione del portfolio">GESTISCI_PORTFOLIO</a></li>
            <li><a href="area_riservata.php#singoli-progetti" class="a-areaRis" title="Clicca per andare nella sezione gestione dei singoli progetti">GESTISCI_SINGOLI PROGETTI</a></li>
            <li><a href="area_riservata.php#contatti-form" class="a-areaRis" title="Clicca per andare nella sezione gestione dei messaggi di contatto">GESTISCI_CONTATTI FORM</a></li>
            <li><a href="index.php" class="a-areaRis" title="Clicca per tornare alla pagina del sito web">ESCI</a></li>
        </ul>
    </div>


    <div class="macro-sezione" id="utenti">
        <h2>LOGIN</h2>
        <a href="area_riservata.php#home_areaRis" title="Clicca per tornare al menu">Menu-></a>
        <!-- Includi il modulo per la gestione degli utenti che possono accedere all'area riservata -->
        <?php include 'gestione_utenti_admin.php'; ?>
    </div>

    <div class="macro-sezione" id="menu">
        <h2>MENU</h2>
        <a href="area_riservata.php#home_areaRis" title="Clicca per tornare al menu">Menu-></a>
        <!-- Includi il modulo per la gestione delle voci del menu -->
        <?php include 'gestione_menu.php'; ?>
    </div>

    <div class="macro-sezione" id="portfolio">
        <h2>PORTFOLIO</h2>
        <a href="area_riservata.php#home_areaRis" title="Clicca per tornare al menu">Menu-></a>
        <!-- Includi il modulo per la gestione del portfolio -->
        <?php include 'gestione_portfolio.php'; ?>
    </div>

    <div class="macro-sezione" id="singoli-progetti">
        <h2>SINGOLI PROGETTI</h2>
        <a href="area_riservata.php#home_areaRis" title="Clicca per tornare al menu">Menu-></a>
        <!-- Includi il modulo per la gestione dei singoli progetti -->
        <?php include 'gestione_singoli_progetti.php'; ?>
    </div>

    <div class="macro-sezione" id="contatti-form">
        <h2>CONTATTI</h2>
        <a href="area_riservata.php#home_areaRis" title="Clicca per tornare al menu">Menu-></a>
        <!-- Includi il modulo per la gestione dei messaggi di contatto -->
        <?php include 'gestione_contatti_form.php'; ?>
    </div>


</body>

</html>