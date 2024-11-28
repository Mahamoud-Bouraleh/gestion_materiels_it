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

$message = ""; // Variable pour stocker le message

// Vérification que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['panne'])) {
    // Récupération des données du formulaire
    $panne = $conn->real_escape_string($_POST['panne']);

    // Insertion des données dans la base de données avec l'ID de l'utilisateur connecté
    $sql = "INSERT INTO pannes (utilisateur_id, date_declaration, materiel_panne, etat_actuel) 
            VALUES ('$id_utilisateur', NOW(), '$panne', 'Pannes')";

    if ($conn->query($sql) === TRUE) {
        $message = "Panne déclarée avec succès!";
    } else {
        $message = "Erreur lors de la déclaration de la panne : " . $conn->error;
    }
} else {
    $message = "Aucune donnée de panne reçue.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Déclarer une Panne</title>
<style>
       *{
    margin: 0;
    padding: 0;
}
    body {
        min-height: 100vh;
    background-image: url(laptop.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
    .container {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    textarea,
    input[type="date"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box
        -sizing: border-box;
        font-size: 16px;
    }
    .button-group {
        text-align: center;
    }
    button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #0056b3;
    }
    .message {
        margin-top: 20px;
        text-align: center;
        padding: 10px;
        border-radius: 4px;
        background-color: #f4f4f4;
        color: #333;
    }
    .success {
        background-color: #d4edda;
        color: #155724;
    }
    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
    .back-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: red; 
    color: white; 
    text-decoration: none; 
    border-radius: 5px; 
    font-family: Arial, sans-serif; /* Police de caractères */
    font-size: 16px; /* Taille de la police */
    text-align: center; /* Centrer le texte */
    cursor: pointer; /* Curseur pointeur */
    transition: background-color 0.3s; /* Transition pour l'effet hover */
}

.back-link:hover {
    background-color: darkred; /* Couleur de fond rouge foncé au survol */
}

.back-icon {
    margin-right: 5px; /* Espace entre l'icône et le texte */
}
nav{
    background-color: white;
    box-shadow: 3px 3px 5px rgba(0,0,0,0.1);

}
nav ul{
    width: 100%;
    list-style: none;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
nav li{
    height: 50px;
}
nav a{
    height: 100%;
    padding:0 30px ;
    text-decoration: none;
    display: flex;
    align-items: center;
    color: black;
}
nav a:hover{
    background-color: #f0f0f0;
}
nav li:first-child {
    margin-right: auto;
}

</style>
</head>
<body>
<nav>
    
    <ul>
      <li><a href="#">Administration</a></li>
      <li><a href="administrations.php">Acceuille</a></li>
      <li><a href="commander.html">commander</a></li>
      <li><a href="declarer_panne.html">Declarer_pannes</a></li>
      <li><a href="afficher_pannes.php">Afficher mes pannes</a></li>
      <li><a href="afficher_commande.php">Afficher mes commandes</a></li>
      
    </ul>
      </nav>
<div class="container">
    <h2>Declarer votre Panne</h2>
    <?php if (!empty($message)): ?>
        <div class="message <?php echo strpos($message, 'Erreur') === false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form action="declarer_panne.php" method="POST">
        <div class="form-group">
            <label for="panne">Panne  :</label>
            <textarea id="panne" name="panne" rows="4" required></textarea>
        </div>
        <div class="button-group">
            <button type="submit" name="submit_panne">Envoyer</button>
            <a href="administrations.php" class="back-link">
    <span class="back-icon">&#8592;</span> Retour
</a>


        </div>
    </form>
</div>
</body>
</html>
