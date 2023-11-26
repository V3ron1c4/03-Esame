<?php
include 'db.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();

    if (isset($_POST["username"], $_POST["password"])) {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $stmt = $conn->prepare("SELECT * FROM utenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password_hash = $row["password"];

            if (password_verify($password, $stored_password_hash)) {
                $_SESSION['user_id'] = $row['idUtente'];
                $_SESSION['username'] = $row['username'];

                if ($row['isAdmin'] == 1) {
                    // L'utente ha accesso all'area riservata
                    echo json_encode(['success' => true]);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'errors' => ['Utente non autorizzato.']]);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'errors' => ['Credenziali non valide.']]);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'errors' => ['Utente non trovato.']]);
            exit();
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/stile_login.css" type="text/css">
    <script src="login.js"></script>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <!-- Stampa gli errori all'interno di un div -->
        <div class="errors-container">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
        <form method="post" action="login.php" id="form_login" novalidate onsubmit="return validateLoginForm(event)">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="submit" id="login-btn" value="login">LOGIN</button>
        </form>
    </div>
</body>

</html>