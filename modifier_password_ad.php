<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = ""; // Mettez ici votre mot de passe MySQL
$dbname = "materiels_it";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du formulaire
$username = $_POST['username'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Vérification de l'utilisateur et de l'ancien mot de passe
$sql = "SELECT * FROM Utilisateur WHERE nom='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['mot_de_passe'];
    if (password_verify($old_password, $hashed_password)) {
        // Vérification si le nouveau mot de passe correspond à sa confirmation
        if ($new_password === $confirm_password) {
            // Cryptage du nouveau mot de passe
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            // Mise à jour du mot de passe
            $update_sql = "UPDATE Utilisateur SET mot_de_passe='$new_hashed_password' WHERE nom='$username'";
            if ($conn->query($update_sql) === TRUE) {
                header("Location: administrations.php");
            } else {
                echo "Erreur lors de la mise à jour du mot de passe: " . $conn->error;
            }
        } else {
            echo "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
        }
    } else {
        echo "Ancien mot de passe incorrect.";
    }
} else {
    echo "Nom d'utilisateur incorrect.";
}

$conn->close();
?>
