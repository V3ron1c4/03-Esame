<?php
// Informazioni per la connessione al database
$servername_db = "31.11.39.138";
$username_db = "Sql1752173";
$password_db = "31!!C10cc0l@t@b1@nc@!!31";
$dbname_db = "Sql1752173_1";

// Connessione al databaase usando MySQLi
$conn = new mysqli($servername_db, $username_db, $password_db, $dbname_db);

// Verifica la connessione
if ($conn->connect_error) {
    // Se la connessione fallisce, mostra un messaggio di errore e termina lo script
    die ("Connessione al database fallita: " . $conn->connect_error);
}

?>