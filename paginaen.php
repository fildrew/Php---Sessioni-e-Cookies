<?php
// Inizializza la sessione
session_start();

// Verifica se è stato effettuato il logout e distrugge le sessioni e i cookie
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'logout') {
    // Elimina tutte le variabili di sessione
    $_SESSION = array();

    // Distruggi la sessione
    session_destroy();

    // Elimina i cookie della lingua e della sessione
    setcookie('preferred_language', '', time() - 3600, '/');
    setcookie(session_name(), '', time() - 3600, '/');

    // Reindirizza l'utente alla pagina principale
    header('Location: index.php');
    exit();
}

// Il resto del tuo codice PHP rimane invariato
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Tabella delle Things</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Logo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Aggiunto tasto di logout nella navbar -->
                <li class="nav-item">
                    <form method="post" action="paginaen.php?action=logout">
                        <button type="submit" name="logout" class="btn btn-link">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Table</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>City</th>
                </tr>
            </thead>
            <tbody>
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

                // Query per recuperare i dati dalla tabella 'things'
                $query = "SELECT * FROM `english`";
                $result = $conn->query($query);

                // Popolamento della tabella con i dati del database
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['surname'] . "</td>";
                        echo "<td>" . $row['city'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nessun dato trovato nella tabella 'things'</td></tr>";
                }

                // Chiusura della connessione
                $conn->close();
                ?>
            </tbody>
        </table>
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