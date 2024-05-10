<?php
// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpesercizi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per la crittografia della password (usando password_hash)
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["regUsername"]) && isset($_POST["regPassword"])) {
    $regUsername = $_POST["regUsername"];
    $regPassword = hashPassword($_POST["regPassword"]);

    $insertQuery = "INSERT INTO utenti (email, password) VALUES ('$regUsername', '$regPassword')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<p>Registrazione avvenuta con successo!</p>";
    } else {
        echo "<p>Errore durante la registrazione: " . $conn->error . "</p>";
    }
}

// Accesso
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["loginUsername"]) && isset($_POST["loginPassword"])) {
    $loginUsername = $_POST["loginUsername"];
    $loginPassword = $_POST["loginPassword"];

    $selectQuery = "SELECT * FROM utenti WHERE username = '$loginUsername'";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($loginPassword, $row["password"])) {
            // Imposta il cookie della lingua sulla base della scelta dell'utente
            if (isset($_POST['lang'])) {
                $lang = $_POST['lang'];
                setcookie('preferred_language', $lang, time() + (365 * 24 * 60 * 60), '/');
            }

            // Ottieni la lingua corrente dal cookie (se appena impostato)
            $currentLanguage = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : $lang;

            // Reindirizza alla pagina corretta sulla base della lingua
            if ($currentLanguage === 'eng') {
                header('Location: paginaen.php');
                exit();
            } else {
                header('Location: paginaita.php');
                exit();
            }
        } else {
            echo "<p>Errore di accesso: Password errata</p>";
        }
    } else {
        echo "<p>Errore di accesso: Utente non trovato</p>";
    }
}

// Chiusura della connessione
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Registrazione e Accesso</title>
</head>

<body>

    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="register-tab" data-toggle="tab" href="#register" role="tab"
                    aria-controls="register" aria-selected="true">Registrazione</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login"
                    aria-selected="false">Accesso</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabsContent">
            <div class="tab-pane fade show active" id="register" role="tabpanel" aria-labelledby="register-tab">
                <h2 class="mt-3">Registrazione</h2>
                <form action="" method="post">
                    <!-- Campi di registrazione -->
                    <div class="form-group">
                        <label for="regUsername">Username:</label>
                        <input type="text" class="form-control" id="regUsername" name="regUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="regPassword">Password:</label>
                        <input type="password" class="form-control" id="regPassword" name="regPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrati</button>
                </form>
            </div>

            <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                <h2 class="mt-3">Accesso</h2>
                <form action="" method="post">
                    <!-- Campi di accesso -->
                    <div class="form-group">
                        <label for="loginUsername">Username:</label>
                        <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password:</label>
                        <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                    </div>
                    <!-- Aggiunto menu a tendina per la scelta della lingua -->
                    <div class="form-group">
                        <label for="lang">Lingua:</label>
                        <select class="form-control" id="lang" name="lang">
                            <option value="ita">ITA</option>
                            <option value="eng">ENG</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Accedi</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>

</html>