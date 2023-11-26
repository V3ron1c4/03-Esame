<?php
include 'db.php';

// Esegui la query per ottenere i dati 
$query = "SELECT * FROM portfolio";
$result = $conn->query($query);

// Verifica se ci sono risultati
if ($result->num_rows > 0) {
    // Converti i risultati in un array associativo
    $portfolioData = array();
    while ($row = $result->fetch_assoc()) {
        $portfolioData[] = $row;
    }

    // Restituisci i dati come JSON
    header('Content-Type: application/json');
    echo json_encode($portfolioData);
} else {
    echo "Nessun risultato trovato";
}

// Chiudi la connessione al database
$conn->close();
?>