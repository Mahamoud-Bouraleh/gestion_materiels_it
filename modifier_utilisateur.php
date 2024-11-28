<?php
// Connexion à la base de données (à remplacer avec vos propres informations de connexion)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "materiels_it";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si l'ID de l'utilisateur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];

    // Requête SQL pour récupérer les informations de l'utilisateur avec l'ID spécifié
    $sql = "SELECT * FROM utilisateur WHERE utilisateur_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Récupérer les informations de l'utilisateur
        $userData = $result->fetch_assoc();

        // Afficher le formulaire de modification avec les informations de l'utilisateur pré-remplies
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier Utilisateur</title>
        </head>
        <body>
            <h1>Modifier Utilisateur</h1>
            <form action="update_user.php" method="POST">
                <input type="hidden" name="userId" value="<?php echo $userData['utilisateur_id']; ?>">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo $userData['nom']; ?>"><br><br>
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo $userData['prenom']; ?>"><br><br>
                <!-- Ajoutez d'autres champs ici pour les autres informations de l'utilisateur -->
                <button type="submit">Modifier</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "ID d'utilisateur non spécifié.";
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
