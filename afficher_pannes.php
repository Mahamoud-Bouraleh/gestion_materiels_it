<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes de l'utilisateur</title>
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
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .back-btn {
        display: block;
        width: fit-content;
        margin: 20px auto;
        background-color: red;
    }
    .back-btn:hover {
        background-color: #5a6268;
    }
    .back-icon {
        margin-right: 5px;
    }
    button {
        padding: 10px 20px;
        margin: 5px;
        border: none;
        background-color: #007BFF;
        color: white;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #0056b3;
    }
    button:active {
        background-color:green;
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
<nav>  <ul>
        <li><a href="#">Administration</a></li>
        <li><a href="administrations.php">Acceuille</a></li>
        <li><a href="commander.html">commander</a></li>
        <li><a href="declarer_panne.html">Declarer_pannes</a></li>
        <li><a href="afficher_pannes.php">Afficher mes pannes</a></li>
        <li><a href="afficher_commande.php">Afficher mes commandes</a></li>
        
      </ul></nav>
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

// Démarrez ou restaurez la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_id"])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}

// Récupérer l'ID de l'utilisateur connecté
$utilisateur_id = $_SESSION["utilisateur_id"];

// Récupérer les pannes de l'utilisateur connecté depuis la base de données
$sql = "SELECT panne_id, date_declaration, materiel_panne, etat_actuel FROM pannes WHERE utilisateur_id = $utilisateur_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannes de l'utilisateur</title>
    <style>
        /* Votre CSS reste inchangé */
    </style>
</head>
<body>
<h1>Pannes de l'utilisateur</h1>
<table>
    <tr>
        <th>Date de déclaration</th>
        <th>Matériel concerné</th>
        <th>État actuel</th>
        <th>Action</th> <!-- Nouvelle colonne pour le bouton de suppression -->
    </tr>
    <?php
    // Afficher les pannes de l'utilisateur
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["date_declaration"] . "</td>";
            echo "<td>" . $row["materiel_panne"] . "</td>";
            echo "<td>" . $row["etat_actuel"] . "</td>";
            // Bouton de suppression avec un formulaire pour envoyer l'ID de la panne à supprimer
            echo "<td>";
            echo "<form method='POST' action='supprimer_panne.php'>";
            echo "<input type='hidden' name='panne_id' value='" . $row["panne_id"] . "'>";
            echo "<button type='submit'>Supprimer</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Aucune panne trouvée.</td></tr>";
    }
    ?>
</table>
<button class="back-btn" onclick="history.go(-1);">
    <span class="back-icon">&#8592;</span> Retour
</button>
<?php
// Fermer la connexion à la base de données
$conn->close();
?>

</body>
</html>
