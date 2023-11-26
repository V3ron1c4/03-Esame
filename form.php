<!-- Form -->
<style>
    .error {
        color: #ff0000;
    }

    .input-container {
        margin-bottom: 10px;
    }

    .error-message {
        color: #ff0000;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    #conferma-msg {
        margin: 10px;
        padding: 10px;
        color: #c63dc6;
        text-align: center;
    }

    @media (max-width: 767px) {
        #conferma-msg {
            margin: 5px;
            padding: 5px;
        }
    }
</style>

<script src="form.js"></script>

<?php
require("funzioni.php");

use Classi\Functions as FT;

$inviato = FT::richiestaHTTP('inviato');
$inviato = ($inviato == null || $inviato != 1) ? false : true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valido = 0;

    //RECUPERO I DATI
    $nome = FT::richiestaHTTP("nome");
    $cognome = FT::richiestaHTTP("cognome");
    $email = FT::richiestaHTTP("email");
    $numero = FT::richiestaHTTP("numero");
    $oggetto = FT::richiestaHTTP("oggetto");
    $messaggio = FT::richiestaHTTP("messaggio");

    $Errore = ' class="error" ';

    //VALIDO I DATI
    if (($nome !== "") && FT::controllaRangeStringa($nome, 2, 25)) {
        $nomeErr = "";
    } else {
        $valido++;
        $nomeErr = $Errore;
        $nome = "";
    }

    if (($cognome !== "") && FT::controllaRangeStringa($cognome, 2, 25)) {
        $cognomeErr = "";
    } else {
        $valido++;
        $cognomeErr = $Errore;
        $cognome = "";
    }

    if (($email !== "") && FT::controllaRangeStringa($email, 10, 40) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "";
    } else {
        $valido++;
        $emailErr = $Errore;
        $email = "";
    }

    if (($numero == "" || is_numeric($numero))) {
        $numeroErr = "";
    } else {
        $valido++;
        $numeroErr = $Errore;
        $numero = "";
    }

    if (($oggetto !== "") && FT::controllaRangeStringa($oggetto, 5, 50)) {
        $oggettoErr = "";
    } else {
        $valido++;
        $oggettoErr = $Errore;
        $oggetto = "";
    }

    if (($messaggio !== "") && FT::controllaRangeStringa($messaggio, 5, 500)) {
        $messaggioErr = "";
    } else {
        $valido++;
        $messaggioErr = $Errore;
        $messaggio = "";
    }

    if ($valido === 0) {
        include('db.php');

        // Prepara la query di inserimento
        $query = "INSERT INTO contatti (nome, cognome, email, numero, oggetto, messaggio, data_inserimento) VALUES (?, ?, ?, ?, ?, ?, NOW())";

        // Prepara l'istruzione
        $stmt = $conn->prepare($query);

        // Associa i parametri
        $stmt->bind_param("ssssss", $nome, $cognome, $email, $numero, $oggetto, $messaggio);

        // Esegui l'istruzione
        $stmt->execute();

        // Chiudi la connessione
        $stmt->close();
        $conn->close();

        echo json_encode(['success' => true, 'message' => 'Grazie per avermi contattato!']);
        exit;
    } else {
        // Se ci sono errori di validazione, restituisci una risposta JSON con gli errori
        echo json_encode(['success' => false, 'errors' => 'Errore nella validazione dei dati.']);
        exit;
    }
} else {
    $nome = "";
    $cognome = "";
    $email = "";
    $numero = "";
    $oggetto = "";
    $messaggio = "";
    $nomeErr = "";
    $cognomeErr = "";
    $emailErr = "";
    $numeroErr = "";
    $oggettoErr = "";
    $messaggioErr = "";
}
?>

<div class="form">
    <div id="conferma-msg"></div>
    <form action="index.php?inviato=1#form" method="POST" class="form-container" novalidate id="form_da_validare">
        <div class="input-container">
            <label id="nomeLabel" <?php echo $nomeErr; ?>>NOME <span>*</span></label>
            <input type="text" placeholder="Il tuo nome" name="nome" id="nome" required minlength="2" maxlength="25" value="<?php echo $nome; ?>">
        </div>
        <div class="input-container">
            <label id="cognomeLabel" <?php echo $cognomeErr; ?>>COGNOME <span>*</span></label>
            <input type="text" placeholder="Il tuo cognome" name="cognome" id="cognome" required minlength="2" maxlength="25" value="<?php echo $cognome; ?>">
        </div>
        <div class="input-container">
            <label id="emailLabel" <?php echo $emailErr; ?>>EMAIL <span>*</span> </label>
            <input type="email" placeholder="La tua email" name="email" id="email" required minlength="10" maxlength="40" value="<?php echo $email; ?>">
        </div>
        <div class="input-container">
            <label id="numeroLabel" <?php echo $numeroErr; ?>>NUMERO </label>
            <input type="tel" placeholder="Il tuo numero" name="numero" id="numero" value="<?php echo $numero; ?>">
        </div>
        <div class="input-container">
            <label id="oggettoLabel" <?php echo $oggettoErr; ?>>OGGETTO <span>*</span></label>
            <input type="text" placeholder="Oggetto" name="oggetto" id="oggetto" required minlength="5" maxlength="50" value="<?php echo $oggetto; ?>">
        </div>
        <div class="input-container">
            <label id="messaggioLabel" <?php echo $messaggioErr; ?>>MESSAGGIO <span>*</span></label>
            <textarea name="messaggio" id="messaggio" cols="20" rows="5" placeholder="Scrivimi in cosa posso aiutarti..." required minlength="5" maxlength="500"><?php echo $messaggio; ?></textarea>
        </div>
        <span>* campi obbligatori</span>
        <button type="submit" name="submit" id="inviaBtn" value="invia">INVIA
            <img class="icone-contatti" src="./img/img-aereo.png" alt="aereodicarta">
        </button>

    </form>
</div>


<!-- Form -->