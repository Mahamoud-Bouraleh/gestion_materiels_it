
<?php
session_start();
$id_utilisateur = $_SESSION['utilisateur_id'];

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Votre mot de passe MySQL ici
$dbname = "materiels_it";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du formulaire
$commande = $_POST['commande'];
$quantite = $_POST['quantite'];

// Insertion des données dans la base de données avec l'ID de l'utilisateur connecté
$sql = "INSERT INTO commande (utilisateur_id, date_commande, materiel_commander, quantite, etat_actuel) 
        VALUES ('$id_utilisateur', NOW(), '$commande', '$quantite', 'Commander')";



if ($conn->query($sql) === TRUE) {
    $commande_id = $conn->insert_id;
    header("Location: afficher_commande.php"); 
} else {
    echo "Erreur lors de l'enregistrement de la commande : " . $conn->error;
}

$conn->close();
?>
