<?php
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_aggiungi_singoli_progetti"])) {
    if (isset($_POST["nuovo_nome_singoli_progetti"], $_POST["nuovo_url_singoli_progetti"], $_POST["nuovo_title_singoli_progetti"], $_POST["nuovo_urlimg_singoli_progetti"], $_POST["nuovo_alt_singoli_progetti"])) {
        $nuovo_nome_singoli_progetti = $_POST["nuovo_nome_singoli_progetti"];
        $nuovo_url_singoli_progetti = $_POST["nuovo_url_singoli_progetti"];
        $nuovo_title_singoli_progetti = $_POST["nuovo_title_singoli_progetti"];
        $nuovo_urlimg_singoli_progetti = $_POST["nuovo_urlimg_singoli_progetti"];
        $nuovo_alt_singoli_progetti = $_POST["nuovo_alt_singoli_progetti"];

        // Esegui l'operazione di inserimento utilizzando prepared statements
        $sql_create_singoli_progetti = $conn->prepare("INSERT INTO dettagli_progetto (nome, url, title, urlimg, alt) VALUES (?, ?, ?, ?, ?)");
        $sql_create_singoli_progetti->bind_param("sssss", $nuovo_nome_singoli_progetti, $nuovo_url_singoli_progetti, $nuovo_title_singoli_progetti, $nuovo_urlimg_singoli_progetti, $nuovo_alt_singoli_progetti);

        if ($sql_create_singoli_progetti->execute()) {
            echo "Inserimento riuscito!";
        } else {
            echo "Errore durante l'inserimento: " . $sql_create_singoli_progetti->error;
        }

        $sql_create_singoli_progetti->close();
    }
}

// READ
$sql_read_singoli_progetti = "SELECT * FROM dettagli_progetto";
$result_read_singoli_progetti = $conn->query($sql_read_singoli_progetti);

if ($result_read_singoli_progetti->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>NOME</th><th>URL</th><th>TITLE</th><th>URLIMG</th><th>ALT</th><th>AZIONI</th></tr>";

    // Output dei dati di ogni riga
    while ($row_singoli_progetti = $result_read_singoli_progetti->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row_singoli_progetti["id"] . "</td>";
        echo "<td id='nome_singoli_progetti_" . $row_singoli_progetti["id"] . "'>" . $row_singoli_progetti["nome"] . "</td>";
        echo "<td id='url_singoli_progetti_" . $row_singoli_progetti["id"] . "'>" . $row_singoli_progetti["url"] . "</td>";
        echo "<td id='title_singoli_progetti_" . $row_singoli_progetti["id"] . "'>" . $row_singoli_progetti["title"] . "</td>";
        echo "<td id='urlimg_singoli_progetti_" . $row_singoli_progetti["id"] . "'>" . $row_singoli_progetti["urlimg"] . "</td>";
        echo "<td id='alt_singoli_progetti_" . $row_singoli_progetti["id"] . "'>" . $row_singoli_progetti["alt"] . "</td>";

        // Aggiungi link per la modifica ed eliminazione
        echo "<td><a href='area_riservata.php#singoli-progetti' onclick='editRowSingoliProgetti(" . $row_singoli_progetti["id"] . ")'>Modifica</a> | <a href='area_riservata.php#singoli-progetti' onclick='deleteRowSingoliProgetti(" . $row_singoli_progetti["id"] . ")'>Elimina</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nessun risultato trovato.";
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_modifica_singoli_progetti"])) {
    if (isset($_POST["id_modifica_singoli_progetti"], $_POST["modifica_nome_singoli_progetti"], $_POST["modifica_url_singoli_progetti"], $_POST["modifica_title_singoli_progetti"], $_POST["modifica_urlimg_singoli_progetti"], $_POST["modifica_alt_singoli_progetti"])) {
        $id_modifica_singoli_progetti = $_POST["id_modifica_singoli_progetti"];
        $modifica_nome_singoli_progetti = $_POST["modifica_nome_singoli_progetti"];
        $modifica_url_singoli_progetti = $_POST["modifica_url_singoli_progetti"];
        $modifica_title_singoli_progetti = $_POST["modifica_title_singoli_progetti"];
        $modifica_urlimg_singoli_progetti = $_POST["modifica_urlimg_singoli_progetti"];
        $modifica_alt_singoli_progetti = $_POST["modifica_alt_singoli_progetti"];

        // Esegui l'operazione di aggiornamento utilizzando prepared statements
        $sql_update_singoli_progetti = $conn->prepare("UPDATE dettagli_progetto SET 
                       nome = ?, 
                       url = ?, 
                       title = ?, 
                       urlimg = ?, 
                       alt = ? 
                       WHERE id = ?");
        $sql_update_singoli_progetti->bind_param("sssssi", $modifica_nome_singoli_progetti, $modifica_url_singoli_progetti, $modifica_title_singoli_progetti, $modifica_urlimg_singoli_progetti, $modifica_alt_singoli_progetti, $id_modifica_singoli_progetti);

        if ($sql_update_singoli_progetti->execute()) {
            echo "Aggiornamento riuscito!";
        } else {
            echo "Errore durante l'aggiornamento: " . $sql_update_singoli_progetti->error;
        }

        $sql_update_singoli_progetti->close();
    }
}


// DELETE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_elimina_singoli_progetti"])) {
    $id_elimina_singoli_progetti = $_POST["id_elimina_singoli_progetti"];

    // Esegui l'operazione di eliminazione utilizzando prepared statements
    $sql_delete_singoli_progetti = $conn->prepare("DELETE FROM dettagli_progetto WHERE id = ?");
    $sql_delete_singoli_progetti->bind_param("i", $id_elimina_singoli_progetti);

    if ($sql_delete_singoli_progetti->execute()) {
        echo "Eliminazione riuscita!";
    } else {
        echo "Errore durante l'eliminazione: " . $sql_delete_singoli_progetti->error;
    }

    $sql_delete_singoli_progetti->close();
}

// Chiudi la connessione
$conn->close();
?>


<!-- HTML Form per l'inserimento -->
<div class="gestione-form">
    <form method="post" action="area_riservata.php#singoli-progetti" onsubmit="return aggiungiRowSingoliProgetti()">
        <input type="text" id="nuovo_nome_singoli_progetti" name="nuovo_nome_singoli_progetti" placeholder="Nuovo Nome">
        <input type="text" id="nuovo_url_singoli_progetti" name="nuovo_url_singoli_progetti" placeholder="Nuovo URL">
        <input type="text" id="nuovo_title_singoli_progetti" name="nuovo_title_singoli_progetti" placeholder="Nuovo Titolo">
        <input type="text" id="nuovo_urlimg_singoli_progetti" name="nuovo_urlimg_singoli_progetti" placeholder="Nuovo URL Immagine">
        <input type="text" id="nuovo_alt_singoli_progetti" name="nuovo_alt_singoli_progetti" placeholder="Nuovo Alt Immagine">
        <input type="submit" name="submit_aggiungi_singoli_progetti" value="Aggiungi">
    </form>

    <!-- HTML Form per la modifica -->
    <form method="post" action="area_riservata.php#singoli-progetti" onsubmit="return modificaRowSingoliProgetti()">
        <input type="hidden" id="id_modifica_singoli_progetti" name="id_modifica_singoli_progetti">
        <input type="text" id="modifica_nome_singoli_progetti" name="modifica_nome_singoli_progetti" placeholder="Modifica Nome">
        <input type="text" id="modifica_url_singoli_progetti" name="modifica_url_singoli_progetti" placeholder="Modifica URL">
        <input type="text" id="modifica_title_singoli_progetti" name="modifica_title_singoli_progetti" placeholder="Modifica Titolo">
        <input type="text" id="modifica_urlimg_singoli_progetti" name="modifica_urlimg_singoli_progetti" placeholder="Modifica URL Immagine">
        <input type="text" id="modifica_alt_singoli_progetti" name="modifica_alt_singoli_progetti" placeholder="Modifica Alt Immagine">
        <input type="submit" name="submit_modifica_singoli_progetti" value="Modifica">
        <input type="button" onclick="resetForm()" value="Reset">
    </form>

    <!-- Form nascosto per l'eliminazione -->
    <form id="form_elimina_singoli_progetti" method="post" action="area_riservata.php#singoli-progetti">
        <input type="hidden" id="id_elimina_singoli_progetti" name="id_elimina_singoli_progetti">
    </form>
</div>

<script>
    function editRowSingoliProgetti(id) {
        // Recupera i dati dalla riga e popola i campi di modifica
        var nome_singoli_progetti = document.getElementById('nome_singoli_progetti_' + id).innerHTML;
        var url_singoli_progetti = document.getElementById('url_singoli_progetti_' + id).innerHTML;
        var title_singoli_progetti = document.getElementById('title_singoli_progetti_' + id).innerHTML;
        var urlimg_singoli_progetti = document.getElementById('urlimg_singoli_progetti_' + id).innerHTML;
        var alt_singoli_progetti = document.getElementById('alt_singoli_progetti_' + id).innerHTML;

        // Imposta i valori nei campi di input di modifica
        document.getElementById('id_modifica_singoli_progetti').value = id;
        document.getElementById('modifica_nome_singoli_progetti').value = nome_singoli_progetti;
        document.getElementById('modifica_url_singoli_progetti').value = url_singoli_progetti;
        document.getElementById('modifica_title_singoli_progetti').value = title_singoli_progetti;
        document.getElementById('modifica_urlimg_singoli_progetti').value = urlimg_singoli_progetti;
        document.getElementById('modifica_alt_singoli_progetti').value = alt_singoli_progetti;
    }

    function deleteRowSingoliProgetti(id) {
        // Chiedi conferma prima di procedere con l'eliminazione
        var conferma = confirm("Sei sicuro di voler eliminare questa riga?");

        if (conferma) {
            // Imposta il valore dell'ID da eliminare in un campo nascosto
            document.getElementById('id_elimina_singoli_progetti').value = id;

            // Invia il modulo per l'eliminazione
            document.getElementById('form_elimina_singoli_progetti').submit();
        }
    }

    function resetFormSingoliProgetti() {
        // Resetta i valori dei campi al loro stato iniziale o vuoto
        document.getElementById('id_modifica_singoli_progetti').value = '';
        document.getElementById('modifica_nome_singoli_progetti').value = '';
        document.getElementById('modifica_url_singoli_progetti').value = '';
        document.getElementById('modifica_title_singoli_progetti').value = '';
        document.getElementById('modifica_urlimg_singoli_progetti').value = '';
        document.getElementById('modifica_alt_singoli_progetti').value = '';
    }

    function aggiungiRowSingoliProgetti() {
        // Esegui azioni aggiuntive per l'aggiunta prima dell'invio del form
        var nuovo_nome_singoli_progetti = document.getElementById('nuovo_nome_singoli_progetti').value;
        var nuovo_url_singoli_progetti = document.getElementById('nuovo_url_singoli_progetti').value;
        var nuovo_title_singoli_progetti = document.getElementById('nuovo_title_singoli_progetti').value;
        var nuovo_urlimg_singoli_progetti = document.getElementById('nuovo_urlimg_singoli_progetti').value;
        var nuovo_alt_singoli_progetti = document.getElementById('nuovo_alt_singoli_progetti').value;

        if (nuovo_nome_singoli_progetti === '' || nuovo_url_singoli_progetti === '' || nuovo_title_singoli_progetti === '' || nuovo_urlimg_singoli_progetti === '' || nuovo_alt_singoli_progetti === '') {
            alert('Compila tutti i campi prima di aggiungere.');
            return false; // Blocca l'invio del form
        }

        return true; // Continua con la sottomissione del form
    }

    function modificaRowSingoliProgetti() {
        // Esegui azioni aggiuntive per la modifica prima dell'invio del form
        var modifica_nome_singoli_progetti = document.getElementById('modifica_nome_singoli_progetti').value;
        var modifica_url_singoli_progetti = document.getElementById('modifica_url_singoli_progetti').value;
        var modifica_title_singoli_progetti = document.getElementById('modifica_title_singoli_progetti').value;
        var modifica_urlimg_singoli_progetti = document.getElementById('modifica_urlimg_singoli_progetti').value;
        var modifica_alt_singoli_progetti = document.getElementById('modifica_alt_singoli_progetti').value;

        if (modifica_nome_singoli_progetti === '' || modifica_url_singoli_progetti === '' || modifica_title_singoli_progetti === '' || modifica_urlimg_singoli_progetti === '' || modifica_alt_singoli_progetti === '') {
            alert('Compila tutti i campi prima di modificare.');
            return false; // Blocca l'invio del form
        }

        return true; // Continua con la sottomissione del form
    }
</script>