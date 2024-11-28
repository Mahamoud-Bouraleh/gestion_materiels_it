<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "materiels_it";

$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'ID de la panne est défini
    if (isset($_POST["panne_id"])) {
        $panne_id = $_POST["panne_id"];

        // Requête SQL pour supprimer la panne de la base de données
        $sql = "DELETE FROM pannes WHERE panne_id = $panne_id";

        if ($conn->query($sql) === TRUE) {
            header("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            echo "Erreur lors de la suppression de la panne: " . $conn->error;
        }
    } else {
        echo "ID de la panne non spécifié.";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
