<?php
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_aggiungi_utente"])) {
    if (isset($_POST["nuovo_username"], $_POST["nuova_password"])) {
        $nuovo_username = $_POST["nuovo_username"];
        $nuova_password = password_hash($_POST["nuova_password"], PASSWORD_DEFAULT);
        $nuovo_isAdmin = isset($_POST["nuovo_isAdmin"]) ? 1 : 0;

        // Verifica se l'utente esiste già
        $sql_check_user = $conn->prepare("SELECT idUtente FROM utenti WHERE username = ?");
        $sql_check_user->bind_param("s", $nuovo_username);
        $sql_check_user->execute();
        $result_check_user = $sql_check_user->get_result();

        if ($result_check_user->num_rows > 0) {
            echo "Errore: Nome utente già esistente.";
        } else {
            // Esegui l'operazione di inserimento utilizzando prepared statements
            $sql_create_utente = $conn->prepare("INSERT INTO utenti (username, password, isAdmin) VALUES (?, ?, ?)");
            $sql_create_utente->bind_param("ssi", $nuovo_username, $nuova_password, $nuovo_isAdmin);

            if ($sql_create_utente->execute()) {
                echo "Inserimento riuscito!";
            } else {
                echo "Errore durante l'inserimento: " . $sql_create_utente->error;
            }

            $sql_create_utente->close();
        }

        $sql_check_user->close();
    }
}

// READ
$sql_read_utenti = "SELECT * FROM utenti";
$result_read_utenti = $conn->query($sql_read_utenti);

if ($result_read_utenti->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Username</th><th>Password</th><th>isAdmin</th><th>Azioni</th></tr>";

    // Output dei dati di ogni riga
    while ($row_utente = $result_read_utenti->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row_utente["idUtente"] . "</td>";
        echo "<td id='username_" . $row_utente["idUtente"] . "'>" . $row_utente["username"] . "</td>";
        echo "<td>***</td>"; // Non mostrare la password
        echo "<td id='isAdmin_" . $row_utente["idUtente"] . "'>" . ($row_utente["isAdmin"] ? 'Sì' : 'No') . "</td>";

        // Aggiungi link per la modifica ed eliminazione
        echo "<td><a href='area_riservata.php#utenti' onclick='editRowUtente(" . $row_utente["idUtente"] . ")'>Modifica</a> | <a href='area_riservata.php#utenti' onclick='deleteRowUtente(" . $row_utente["idUtente"] . ")'>Elimina</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nessun risultato trovato.";
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_modifica_utente"])) {
    if (isset($_POST["id_modifica_utente"], $_POST["modifica_username"])) {
        $id_modifica_utente = $_POST["id_modifica_utente"];
        $modifica_username = $_POST["modifica_username"];
        $modifica_password = !empty($_POST["modifica_password"]) ? password_hash($_POST["modifica_password"], PASSWORD_DEFAULT) : null;
        $modifica_isAdmin = isset($_POST["modifica_isAdmin"]) ? 1 : 0;

        // Esegui l'operazione di aggiornamento utilizzando prepared statements
        if ($modifica_password) {
            $sql_update_utente = $conn->prepare("UPDATE utenti SET username = ?, password = ?, isAdmin = ? WHERE idUtente = ?");
            $sql_update_utente->bind_param("ssii", $modifica_username, $modifica_password, $modifica_isAdmin, $id_modifica_utente);
        } else {
            $sql_update_utente = $conn->prepare("UPDATE utenti SET username = ?, isAdmin = ? WHERE idUtente = ?");
            $sql_update_utente->bind_param("sii", $modifica_username, $modifica_isAdmin, $id_modifica_utente);
        }

        if ($sql_update_utente->execute()) {
            echo "Aggiornamento riuscito!";
        } else {
            echo "Errore durante l'aggiornamento: " . $sql_update_utente->error;
        }

        $sql_update_utente->close();
    }
}

// DELETE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_elimina_utente"])) {
    $id_elimina_utente = $_POST["id_elimina_utente"];

    // Esegui l'operazione di eliminazione utilizzando prepared statements
    $sql_delete_utente = $conn->prepare("DELETE FROM utenti WHERE idUtente = ?");
    $sql_delete_utente->bind_param("i", $id_elimina_utente);

    if ($sql_delete_utente->execute()) {
        echo "Eliminazione riuscita!";
    } else {
        echo "Errore durante l'eliminazione: " . $sql_delete_utente->error;
    }

    $sql_delete_utente->close();
}

// Chiudi la connessione
$conn->close();

?>

<!-- HTML Form per l'inserimento -->
<div class="gestione-form">
    <form method="post" action="area_riservata.php#utenti" onsubmit="return aggiungiRowUtente()">
        <input type="text" id="nuovo_username" name="nuovo_username" placeholder="Nuovo Username" required>
        <input type="password" id="nuova_password" name="nuova_password" placeholder="Nuova Password" required>
        <label for="nuovo_isAdmin">isAdmin:</label>
        <input type="checkbox" id="nuovo_isAdmin" name="nuovo_isAdmin">
        <input type="submit" name="submit_aggiungi_utente" value="Aggiungi">
    </form>

    <!-- HTML Form per la modifica -->
    <form method="post" action="area_riservata.php#utenti" onsubmit="return modificaRowUtente()">
        <input type="hidden" id="id_modifica_utente" name="id_modifica_utente">
        <input type="text" id="modifica_username" name="modifica_username" placeholder="Modifica Username" required>
        <input type="password" id="modifica_password" name="modifica_password" placeholder="Modifica Password">
        <label for="modifica_isAdmin">Modifica isAdmin:</label>
        <input type="checkbox" id="modifica_isAdmin" name="modifica_isAdmin">
        <input type="submit" name="submit_modifica_utente" value="Modifica">
        <input type="button" onclick="resetFormUtente()" value="Reset">
    </form>

    <!-- Form nascosto per l'eliminazione -->
    <form id="form_elimina_utente" method="post" action="area_riservata.php#utenti">
        <input type="hidden" id="id_elimina_utente" name="id_elimina_utente">
    </form>
</div>

<script>
    function editRowUtente(id) {
        // Recupera i dati dalla riga e popola i campi di modifica
        var username = document.getElementById('username_' + id).innerHTML;
        var isAdmin = document.getElementById('isAdmin_' + id).innerHTML === 'Sì';

        // Imposta i valori nei campi di input di modifica
        document.getElementById('id_modifica_utente').value = id;
        document.getElementById('modifica_username').value = username;
        document.getElementById('modifica_isAdmin').checked = isAdmin;
    }

    function deleteRowUtente(id) {
        // Chiedi conferma prima di procedere con l'eliminazione
        var conferma = confirm("Sei sicuro di voler eliminare questa riga?");

        if (conferma) {
            // Imposta il valore dell'ID da eliminare in un campo nascosto
            document.getElementById('id_elimina_utente').value = id;

            // Invia il modulo per l'eliminazione
            document.getElementById('form_elimina_utente').submit();
        }
    }

    function resetFormUtente() {
        // Resetta i valori dei campi al loro stato iniziale o vuoto
        document.getElementById('id_modifica_utente').value = '';
        document.getElementById('modifica_username').value = '';
        document.getElementById('modifica_password').value = '';
        document.getElementById('modifica_isAdmin').checked = false;
    }

    function aggiungiRowUtente() {
        // Esegui azioni aggiuntive per l'aggiunta prima dell'invio del form
        var nuovo_username = document.getElementById('nuovo_username').value;
        var nuova_password = document.getElementById('nuova_password').value;

        if (nuovo_username === '' || nuova_password === '') {
            alert('Compila tutti i campi prima di aggiungere.');
            return false; // Blocca l'invio del form
        }

        return true; // Continua con la sottomissione del form
    }

    function modificaRowUtente() {
        // Esegui azioni aggiuntive per la modifica prima dell'invio del form
        var modifica_username = document.getElementById('modifica_username').value;
        // var modifica_password = document.getElementById('modifica_password').value;

        if (modifica_username === '') {
            alert('Compila il campo del nome utente prima di modificare.');
            return false; // Blocca l'invio del form
        }

        return true; // Continua con la sottomissione del form
    }
</script>