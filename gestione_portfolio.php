<?php
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_aggiungi_portfolio"])) {
    if (isset($_POST["nuovo_nome_portfolio"], $_POST["nuovo_url_portfolio"], $_POST["nuovo_title_portfolio"], $_POST["nuovo_urlimg_portfolio"], $_POST["nuovo_alt_portfolio"])) {
        $nuovo_nome_portfolio = $_POST["nuovo_nome_portfolio"];
        $nuovo_url_portfolio = $_POST["nuovo_url_portfolio"];
        $nuovo_title_portfolio = $_POST["nuovo_title_portfolio"];
        $nuovo_urlimg_portfolio = $_POST["nuovo_urlimg_portfolio"];
        $nuovo_alt_portfolio = $_POST["nuovo_alt_portfolio"];

        // Esegui l'operazione di inserimento utilizzando prepared statements
        $sql_create_portfolio = $conn->prepare("INSERT INTO portfolio (nome, url, title, urlimg, alt) VALUES (?, ?, ?, ?, ?)");
        $sql_create_portfolio->bind_param("sssss", $nuovo_nome_portfolio, $nuovo_url_portfolio, $nuovo_title_portfolio, $nuovo_urlimg_portfolio, $nuovo_alt_portfolio);

        if ($sql_create_portfolio->execute()) {
            echo "Inserimento riuscito!";
        } else {
            echo "Errore durante l'inserimento: " . $sql_create_portfolio->error;
        }

        $sql_create_portfolio->close();
    }
}

// READ
$sql_read_portfolio = "SELECT * FROM portfolio";
$result_read_portfolio = $conn->query($sql_read_portfolio);

if ($result_read_portfolio->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>NOME</th><th>URL</th><th>TITLE</th><th>URL IMG</th><th>ALT</th><th>AZIONI</th></tr>";

    // Output dei dati di ogni riga
    while ($row_portfolio = $result_read_portfolio->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row_portfolio["id"] . "</td>";
        echo "<td id='nome_portfolio_" . $row_portfolio["id"] . "'>" . $row_portfolio["nome"] . "</td>";
        echo "<td id='url_portfolio_" . $row_portfolio["id"] . "'>" . $row_portfolio["url"] . "</td>";
        echo "<td id='title_portfolio_" . $row_portfolio["id"] . "'>" . $row_portfolio["title"] . "</td>";
        echo "<td id='urlimg_portfolio_" . $row_portfolio["id"] . "'>" . $row_portfolio["urlimg"] . "</td>";
        echo "<td id='alt_portfolio_" . $row_portfolio["id"] . "'>" . $row_portfolio["alt"] . "</td>";

        // Aggiungi link per la modifica ed eliminazione
        echo "<td><a href='area_riservata.php#portfolio' onclick='editRowPortfolio(" . $row_portfolio["id"] . ")'>Modifica</a> | <a href='area_riservata.php#portfolio' onclick='deleteRowPortfolio(" . $row_portfolio["id"] . ")'>Elimina</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nessun risultato trovato.";
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_modifica_portfolio"])) {
    if (isset($_POST["id_modifica_portfolio"], $_POST["modifica_nome_portfolio"], $_POST["modifica_url_portfolio"], $_POST["modifica_title_portfolio"], $_POST["modifica_urlimg_portfolio"], $_POST["modifica_alt_portfolio"])) {
        $id_modifica_portfolio = $_POST["id_modifica_portfolio"];
        $modifica_nome_portfolio = $_POST["modifica_nome_portfolio"];
        $modifica_url_portfolio = $_POST["modifica_url_portfolio"];
        $modifica_title_portfolio = $_POST["modifica_title_portfolio"];
        $modifica_urlimg_portfolio = $_POST["modifica_urlimg_portfolio"];
        $modifica_alt_portfolio = $_POST["modifica_alt_portfolio"];

        // Esegui l'operazione di aggiornamento utilizzando prepared statements
        $sql_update_portfolio = $conn->prepare("UPDATE portfolio SET 
                       nome = ?, 
                       url = ?, 
                       title = ?, 
                       urlimg = ?, 
                       alt = ? 
                       WHERE id = ?");
        $sql_update_portfolio->bind_param("sssssi", $modifica_nome_portfolio, $modifica_url_portfolio, $modifica_title_portfolio, $modifica_urlimg_portfolio, $modifica_alt_portfolio, $id_modifica_portfolio);

        if ($sql_update_portfolio->execute()) {
            echo "Aggiornamento riuscito!";
        } else {
            echo "Errore durante l'aggiornamento: " . $sql_update_portfolio->error;
        }

        $sql_update_portfolio->close();
    }
}

// DELETE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_elimina_portfolio"])) {
    $id_elimina_portfolio = $_POST["id_elimina_portfolio"];

    // Esegui l'operazione di eliminazione utilizzando prepared statements
    $sql_delete_portfolio = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
    $sql_delete_portfolio->bind_param("i", $id_elimina_portfolio);

    if ($sql_delete_portfolio->execute()) {
        echo "Eliminazione riuscita!";
    } else {
        echo "Errore durante l'eliminazione: " . $sql_delete_portfolio->error;
    }

    $sql_delete_portfolio->close();
}

// Chiudi la connessione
$conn->close();
?>


<!-- HTML Form per l'inserimento-->
<div class="gestione-form">
    <form method="post" action="area_riservata.php#portfolio" onsubmit="return aggiungiRowPortfolio()">
        <input type="text" id="nuovo_nome_portfolio" name="nuovo_nome_portfolio" placeholder="Nuovo Nome">
        <input type="text" id="nuovo_url_portfolio" name="nuovo_url_portfolio" placeholder="Nuova URL">
        <input type="text" id="nuovo_title_portfolio" name="nuovo_title_portfolio" placeholder="Nuovo Titolo">
        <input type="text" id="nuovo_urlimg_portfolio" name="nuovo_urlimg_portfolio" placeholder="Nuova URL Img">
        <input type="text" id="nuovo_alt_portfolio" name="nuovo_alt_portfolio" placeholder="Nuovo Alt">
        <input type="submit" name="submit_aggiungi_portfolio" value="Aggiungi">
    </form>

    <!-- HTML Form per la modifica -->
    <form method="post" action="area_riservata.php#portfolio" onsubmit="return modificaRowPortfolio()">
        <input type="hidden" id="id_modifica_portfolio" name="id_modifica_portfolio">
        <input type="text" id="modifica_nome_portfolio" name="modifica_nome_portfolio" placeholder="Modifica Nome">
        <input type="text" id="modifica_url_portfolio" name="modifica_url_portfolio" placeholder="Modifica URL">
        <input type="text" id="modifica_title_portfolio" name="modifica_title_portfolio" placeholder="Modifica Titolo">
        <input type="text" id="modifica_urlimg_portfolio" name="modifica_urlimg_portfolio" placeholder="Modifica URL Img">
        <input type="text" id="modifica_alt_portfolio" name="modifica_alt_portfolio" placeholder="Modifica Alt">
        <input type="submit" name="submit_modifica_portfolio" value="Modifica">
        <input type="button" onclick="resetFormPortfolio()" value="Reset">
    </form>

    <!-- Form nascosto per l'eliminazione -->
    <form id="form_elimina_portfolio" method="post" action="area_riservata.php#portfolio">
        <input type="hidden" id="id_elimina_portfolio" name="id_elimina_portfolio">
    </form>
</div>

<script>
    function editRowPortfolio(id) {
        var nome_portfolio = document.getElementById('nome_portfolio_' + id).innerHTML;
        var url_portfolio = document.getElementById('url_portfolio_' + id).innerHTML;
        var title_portfolio = document.getElementById('title_portfolio_' + id).innerHTML;
        var urlimg_portfolio = document.getElementById('urlimg_portfolio_' + id).innerHTML;
        var alt_portfolio = document.getElementById('alt_portfolio_' + id).innerHTML;

        document.getElementById('id_modifica_portfolio').value = id;
        document.getElementById('modifica_nome_portfolio').value = nome_portfolio;
        document.getElementById('modifica_url_portfolio').value = url_portfolio;
        document.getElementById('modifica_title_portfolio').value = title_portfolio;
        document.getElementById('modifica_urlimg_portfolio').value = urlimg_portfolio;
        document.getElementById('modifica_alt_portfolio').value = alt_portfolio;
    }

    function deleteRowPortfolio(id) {
        var conferma = confirm("Sei sicuro di voler eliminare questa riga?");

        if (conferma) {
            document.getElementById('id_elimina_portfolio').value = id;
            document.getElementById('form_elimina_portfolio').submit();
        }
    }

    function resetFormPortfolio() {
        document.getElementById('id_modifica_portfolio').value = '';
        document.getElementById('modifica_nome_portfolio').value = '';
        document.getElementById('modifica_url_portfolio').value = '';
        document.getElementById('modifica_title_portfolio').value = '';
        document.getElementById('modifica_urlimg_portfolio').value = '';
        document.getElementById('modifica_alt_portfolio').value = '';
    }

    function aggiungiRowPortfolio() {
        var nuovo_nome_portfolio = document.getElementById('nuovo_nome_portfolio').value;
        var nuovo_url_portfolio = document.getElementById('nuovo_url_portfolio').value;
        var nuovo_title_portfolio = document.getElementById('nuovo_title_portfolio').value;


        var nuovo_urlimg_portfolio = document.getElementById('nuovo_urlimg_portfolio').value;
        var nuovo_alt_portfolio = document.getElementById('nuovo_alt_portfolio').value;

        if (nuovo_nome_portfolio === '' || nuovo_url_portfolio === '' || nuovo_title_portfolio === '' || nuovo_urlimg_portfolio === '' || nuovo_alt_portfolio === '') {
            alert('Compila tutti i campi prima di aggiungere.');
            return false;
        }

        return true;
    }

    function modificaRowPortfolio() {
        var modifica_nome_portfolio = document.getElementById('modifica_nome_portfolio').value;
        var modifica_url_portfolio = document.getElementById('modifica_url_portfolio').value;
        var modifica_title_portfolio = document.getElementById('modifica_title_portfolio').value;
        var modifica_urlimg_portfolio = document.getElementById('modifica_urlimg_portfolio').value;
        var modifica_alt_portfolio = document.getElementById('modifica_alt_portfolio').value;

        if (modifica_nome_portfolio === '' || modifica_url_portfolio === '' || modifica_title_portfolio === '' || modifica_urlimg_portfolio === '' || modifica_alt_portfolio === '') {
            alert('Compila tutti i campi prima di modificare.');
            return false;
        }

        return true;
    }
</script>