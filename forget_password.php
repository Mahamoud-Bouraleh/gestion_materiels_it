<?php

$servername = "localhost";
$username = "root";
$password = ""; // Mettez ici votre mot de passe MySQL
$dbname = "materiels_it";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'fpdf186/fpdf.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    // Vérifier si le nom et l'email correspondent à un utilisateur dans la base de données
    $select_user = mysqli_prepare($conn, "SELECT utilisateur_id FROM utilisateur WHERE nom = ? AND email = ?");
    mysqli_stmt_bind_param($select_user, "ss", $nom, $email);
    mysqli_stmt_execute($select_user);
    mysqli_stmt_store_result($select_user);

    if (mysqli_stmt_num_rows($select_user) > 0) {
        // Générer un nouveau mot de passe
        $new_password = generatePassword();
        $hashed_password = md5($new_password); // Hasher le nouveau mot de passe

        // Mettre à jour le mot de passe dans la table 'utilisateur'
        mysqli_stmt_bind_result($select_user, $utilisateur_id);
        mysqli_stmt_fetch($select_user);
        mysqli_stmt_close($select_user);

        $update_password = mysqli_prepare($conn, "UPDATE utilisateur SET mot_de_passe = ? WHERE utilisateur_id = ?");
        mysqli_stmt_bind_param($update_password, "si", $hashed_password, $utilisateur_id);
        mysqli_stmt_execute($update_password);

        // Envoyer un e-mail avec le nouveau mot de passe
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abokorhamoud7899@gmail.com'; // Remplacez par votre e-mail
        $mail->Password = 'zbbl rgew yakx deeh'; // Remplacez par votre mot de passe SMTP
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('abokorhamoud7899@gmail.com', 'Mohamoud'); // Remplacez par votre nom et votre e-mail
        $mail->addAddress($email);
        $mail->Subject = 'Nouveau mot de passe';
        $mail->Body = "Votre nouveau mot de passe est : $new_password";

        try {
            $mail->send();
            echo "Un nouveau mot de passe a été envoyé à votre adresse e-mail.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    } else {
        echo "Vos informations ne sont pas correctes.";
    }
}

// Fonction pour générer un mot de passe aléatoire
function generatePassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
