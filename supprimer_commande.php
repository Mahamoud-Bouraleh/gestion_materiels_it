<?php
// Vérifie si la méthode HTTP est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si l'ID de la commande est défini et n'est pas vide
    if (isset($_POST["commande_id"]) && !empty($_POST["commande_id"])) {
        // Récupère l'ID de la commande à supprimer
        $commande_id = $_POST["commande_id"];

        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "materiels_it";

        $conn = new mysqli($servername, $username, $password, $database);

        // Vérifie la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Requête SQL pour supprimer la commande
        $sql = "DELETE FROM commande WHERE commande_id = $commande_id";

        if ($conn->query($sql) === TRUE) {
            // Redirige vers la page précédente après la suppression
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Erreur lors de la suppression de la commande: " . $conn->error;
        }

        // Ferme la connexion à la base de données
        $conn->close();
    } else {
        echo "ID de commande non spécifié.";
    }
} else {
    echo "Accès refusé.";
}
?>
