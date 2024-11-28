<?php
// Démarrez la session
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "materiels_it";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $nom = $_POST['nom'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Préparer la requête SQL pour récupérer l'utilisateur
    $sql = "SELECT * FROM utilisateur WHERE nom='$nom' AND mot_de_passe='$mot_de_passe'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Authentification réussie, récupérer l'utilisateur
        $row = $result->fetch_assoc();
        $utilisateur_id = $row['utilisateur_id'];
        $type_utilisateur = $row['type_utilisateur'];

        // Stocker l'utilisateur_id dans une variable de session
        $_SESSION['utilisateur_id'] = $utilisateur_id;

        // Redirection en fonction du type de l'utilisateur
        switch ($type_utilisateur) {
            case 'utilisateur_it':
                header("Location: admin.php");
                exit();
            case 'administration':
                header("Location: administration/administrations.php");
                exit();
            default:
                // Redirection par défaut si le type d'utilisateur n'est pas reconnu
                header("Location: login.html");
                exit();
        }
    } else {
        // Redirection si l'authentification a échoué
        header("Location: login1.php");
        exit();
    }
}

$conn->close();
?>
