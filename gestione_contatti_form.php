<?php
include 'db.php';

// READ
$sql_read_contatti = "SELECT * FROM contatti";
$result_read_contatti = $conn->query($sql_read_contatti);

if ($result_read_contatti->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>NOME</th><th>COGNOME</th><th>EMAIL</th><th>NUMERO</th><th>OGGETTO</th><th>MESSAGGIO</th><th>DATA INSERIMENTO</th><th>AZIONI</th></tr>";

    while ($row_contatti = $result_read_contatti->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row_contatti["id"] . "</td>";
        echo "<td id='nome_contatti_" . $row_contatti["id"] . "'>" . $row_contatti["nome"] . "</td>";
        echo "<td id='cognome_contatti_" . $row_contatti["id"] . "'>" . $row_contatti["cognome"] . "</td>";
        echo "<td id='email_contatti_" . $row_contatti["id"] . "'>" . $row_contatti["email"] . "</td>";
        echo "<td id='numero_contatti_" . $row_contatti["id"] . "'>" . $row_contatti["numero"] . "</td>";
        echo "<td id='oggetto_contatti_" . $row_contatti["id"] . "'>" . $row_contatti["oggetto"] . "</td>";
        echo "<td id='messaggio_contatti_" . $row_contatti["id"] . "'>" . $row_contatti["messaggio"] . "</td>";
        echo "<td>" . $row_contatti["data_inserimento"] . "</td>";

        // Aggiungi link per l'eliminazione
        echo "<td><a href='area_riservata.php#contatti-form' onclick='deleteRowContatti(" . $row_contatti["id"] . ")'>Elimina</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nessun risultato trovato.";
}


// DELETE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_elimina_contatti"])) {
    $id_elimina_contatti = $_POST["id_elimina_contatti"];

    // Esegui l'operazione di eliminazione utilizzando prepared statements
    $sql_delete_contatti = $conn->prepare("DELETE FROM contatti WHERE id = ?");
    $sql_delete_contatti->bind_param("i", $id_elimina_contatti);

    if ($sql_delete_contatti->execute()) {
        echo "Eliminazione riuscita!";
    } else {
        echo "Errore durante l'eliminazione: " . $sql_delete_contatti->error;
    }

    $sql_delete_contatti->close();
}

// Chiudi la connessione
$conn->close();
?>

<!-- Form nascosto per l'eliminazione -->
<div class="gestione-form">
  
    <form id="form_elimina_contatti" method="post" action="area_riservata.php#contatti-form">
        <input type="hidden" id="id_elimina_contatti" name="id_elimina_contatti">
    </form>

</div>

<script>
    
    function deleteRowContatti(id) {
        // Chiedi conferma prima di procedere con l'eliminazione
        var conferma = confirm("Sei sicuro di voler eliminare questa riga?");

        if (conferma) {
            // Imposta il valore dell'ID da eliminare in un campo nascosto
            document.getElementById('id_elimina_contatti').value = id;

            // Invia il modulo per l'eliminazione
            document.getElementById('form_elimina_contatti').submit();
        }
    }

</script>