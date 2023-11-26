<?php
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_aggiungi"])) {
    if (isset($_POST["nuovo_nome"], $_POST["nuovo_url"], $_POST["nuova_classe"], $_POST["nuovo_title"])) {
        $nuovoNome = $_POST["nuovo_nome"];
        $nuovoUrl = $_POST["nuovo_url"];
        $nuovaClasse = $_POST["nuova_classe"];
        $nuovoTitle = $_POST["nuovo_title"];

        // Esegui l'operazione di inserimento utilizzando prepared statements
        $sql_create = $conn->prepare("INSERT INTO categorie_menu (nome, url, class, title) VALUES (?, ?, ?, ?)");
        $sql_create->bind_param("ssss", $nuovoNome, $nuovoUrl, $nuovaClasse, $nuovoTitle);

        if ($sql_create->execute()) {
            echo "Inserimento riuscito!";
        } else {
            echo "Errore durante l'inserimento: " . $sql_create->error;
        }

        $sql_create->close();
    }
}


// READ
$sql_read = "SELECT * FROM categorie_menu";
$result_read = $conn->query($sql_read);

if ($result_read->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>NOME</th><th>URL</th><th>CLASS</th><th>TITLE</th><th>AZIONI</th></tr>";

    // Output dei dati di ogni riga
    while ($row = $result_read->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td id='nome_" . $row["id"] . "'>" . $row["nome"] . "</td>";
        echo "<td id='url_" . $row["id"] . "'>" . $row["url"] . "</td>";
        echo "<td id='class_" . $row["id"] . "'>" . $row["class"] . "</td>";
        echo "<td id='title_" . $row["id"] . "'>" . $row["title"] . "</td>";

        // Aggiungi link per la modifica ed eliminazione
        echo "<td><a href='area_riservata.php#menu' onclick='editRow(" . $row["id"] . ")'>Modifica</a> | <a href='area_riservata.php#menu' onclick='deleteRow(" . $row["id"] . ")'>Elimina</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nessun risultato trovato.";
}


// UPDATE
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_modifica"])) {
    if (isset($_POST["id_modifica"], $_POST["modifica_nome"], $_POST["modifica_url"], $_POST["modifica_classe"], $_POST["modifica_title"])) {
        $id_modifica = $_POST["id_modifica"];
        $modifica_nome = $_POST["modifica_nome"];
        $modifica_url = $_POST["modifica_url"];
        $modifica_classe = $_POST["modifica_classe"];
        $modifica_title = $_POST["modifica_title"];

        // Esegui l'operazione di aggiornamento utilizzando prepared statements
        $sql_update = $conn->prepare("UPDATE categorie_menu SET 
                       nome = ?, 
                       url = ?, 
                       class = ?, 
                       title = ? 
                       WHERE id = ?");
        $sql_update->bind_param("ssssi", $modifica_nome, $modifica_url, $modifica_classe, $modifica_title, $id_modifica);

        if ($sql_update->execute()) {
            echo "Aggiornamento riuscito!";
        } else {
            echo "Errore durante l'aggiornamento: " . $sql_update->error;
        }

        $sql_update->close();
    }
}

// DELETE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_elimina"])) {
    $id_elimina = $_POST["id_elimina"];

    // Esegui l'operazione di eliminazione utilizzando prepared statements
    $sql_delete = $conn->prepare("DELETE FROM categorie_menu WHERE id = ?");
    $sql_delete->bind_param("i", $id_elimina);

    if ($sql_delete->execute()) {
        echo "Eliminazione riuscita!";
    } else {
        echo "Errore durante l'eliminazione: " . $sql_delete->error;
    }

    $sql_delete->close();
}

// Chiudi la connessione
$conn->close()
?>




<!-- HTML Form per l'inserimento-->
<div class="gestione-form">
    <form method="post" action="area_riservata.php#menu" onsubmit="return aggiungiRow()">
        <input type="text" id="nuovo_nome" name="nuovo_nome" placeholder="Nuovo Nome">
        <input type="text" id="nuovo_url" name="nuovo_url" placeholder="Nuova URL">
        <input type="text" id="nuova_classe" name="nuova_classe" placeholder="Nuova Classe">
        <input type="text" id="nuovo_title" name="nuovo_title" placeholder="Nuovo Titolo">
        <input type="submit" name="submit_aggiungi" value="Aggiungi">
    </form>

    <!-- HTML Form per la modifica -->
    <form method="post" action="area_riservata.php#menu" onsubmit="return modificaRow()">
        <input type="hidden" id="id_modifica" name="id_modifica">
        <input type="text" id="modifica_nome" name="modifica_nome" placeholder="Modifica Nome">
        <input type="text" id="modifica_url" name="modifica_url" placeholder="Modifica URL">
        <input type="text" id="modifica_classe" name="modifica_classe" placeholder="Modifica Classe">
        <input type="text" id="modifica_title" name="modifica_title" placeholder="Modifica Titolo">
        <input type="submit" name="submit_modifica" value="Modifica">
        <input type="button" onclick="resetForm()" value="Reset">
    </form>

    <!-- Form nascosto per l'eliminazione -->
    <form id="form_elimina" method="post" action="area_riservata.php#menu">
        <input type="hidden" id="id_elimina" name="id_elimina">
    </form>
</div>

<script>
    function editRow(id) {
        // Recupera i dati dalla riga e popola i campi di modifica
        var nome = document.getElementById('nome_' + id).innerHTML;
        var url = document.getElementById('url_' + id).innerHTML;
        var classe = document.getElementById('class_' + id).innerHTML;
        var title = document.getElementById('title_' + id).innerHTML;

        // Imposta i valori nei campi di input di modifica
        document.getElementById('id_modifica').value = id;
        document.getElementById('modifica_nome').value = nome;
        document.getElementById('modifica_url').value = url;
        document.getElementById('modifica_classe').value = classe;
        document.getElementById('modifica_title').value = title;
    }

    function deleteRow(id) {
        // Chiedi conferma prima di procedere con l'eliminazione
        var conferma = confirm("Sei sicuro di voler eliminare questa riga?");

        if (conferma) {
            // Imposta il valore dell'ID da eliminare in un campo nascosto
            document.getElementById('id_elimina').value = id;

            // Invia il modulo per l'eliminazione
            document.getElementById('form_elimina').submit();
        }
    }

    function resetForm() {
        // Resetta i valori dei campi al loro stato iniziale o vuoto
        document.getElementById('id_modifica').value = '';
        document.getElementById('modifica_nome').value = '';
        document.getElementById('modifica_url').value = '';
        document.getElementById('modifica_classe').value = '';
        document.getElementById('modifica_title').value = '';
    }

    function aggiungiRow() {
        // Esegui azioni aggiuntive per l'aggiunta prima dell'invio del form
        var nuovoNome = document.getElementById('nuovo_nome').value;
        var nuovoUrl = document.getElementById('nuovo_url').value;
        var nuovoClasse = document.getElementById('nuova_classe').value;
        var nuovoTitle = document.getElementById('nuovo_title').value;

        if (nuovoNome === '' || nuovoUrl === '' || nuovoClasse === '' || nuovoTitle === '') {
            alert('Compila tutti i campi prima di aggiungere.');
            return false; // Blocca l'invio del form
        }

        return true; // Continua con la sottomissione del form
    }

    function modificaRow() {
        // Esegui azioni aggiuntive per la modifica prima dell'invio del form
        var modificaNome = document.getElementById('modifica_nome').value;
        var modificaUrl = document.getElementById('modifica_url').value;
        var modificaClasse = document.getElementById('modifica_classe').value;
        var modificaTitle = document.getElementById('modifica_title').value;

        if (modificaNome === '' || modificaUrl === '' || modificaClasse === '' || modificaTitle === '') {
            alert('Compila tutti i campi prima di modificare.');
            return false; // Blocca l'invio del form
        }

        return true; // Continua con la sottomissione del form
    }
</script>