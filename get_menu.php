<?php
// Connessione al database e query per ottenere il menu
include 'db.php';

$query = "SELECT * FROM categorie_menu";
$result = $conn->query($query);

if (!$result) {
    die('Errore nella query: ' . $conn->error);
}

$menuData = array();

while ($row = $result->fetch_assoc()) {
    $menuData[] = $row;
}

$conn->close();

// Restituisci i dati come JSON
header('Content-Type: application/json');
echo json_encode($menuData);
?>