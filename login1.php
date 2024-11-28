<?php
session_start(); // Ensure session is started

$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "materiels_it";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'fpdf186/fpdf.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['Connecter'])) {
    // Check if the login form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form values
        $nom = $_POST['nom'];
        $mot_de_passe = $_POST['mot_de_passe'];
    
        // Prepare SQL query to retrieve the user
        $stmt = $conn->prepare("SELECT utilisateur_id, type_utilisateur, mot_de_passe FROM utilisateur WHERE nom = ?");
        $stmt->bind_param("s", $nom);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Authentication successful, retrieve the user
            $row = $result->fetch_assoc();
            $utilisateur_id = $row['utilisateur_id'];
            $type_utilisateur = $row['type_utilisateur'];
            $hashed_password = $row['mot_de_passe'];
    
            // Verify password
            if (password_verify($mot_de_passe, $hashed_password)) {
                // Store the utilisateur_id in a session variable
                $_SESSION['utilisateur_id'] = $utilisateur_id;
    
                // Debug messages
                error_log("Type utilisateur : " . $type_utilisateur);
    
                // Redirect based on the user type
                switch ($type_utilisateur) {
                    case 'utilisateur_it':
                        header("Location: admin.php");
                        exit();
                    case 'administration':
                          header("Location: administration/administrations.php");
                        exit();
                    default:
                         header("Location: login.html");
                        exit();
                }
            } else {
                // Incorrect password
                error_log("Mot de passe incorrect pour l'utilisateur : " . $nom);
                $erreur = "Mot de passe incorrect";
                header("Location: login1.php?erreur=$erreur");
                exit();
            }
        } else {
            // User not found
            error_log("Utilisateur non trouvé : " . $nom);
            $erreur = "Utilisateur non trouvé";
            header("Location: login1.php?erreur=$erreur");
            exit();
        }
    }
}

if (isset($_POST['submit'])) {
    $nomss = $_POST['nome'];
    $emailss = $_POST['emaile'];

    // Check if the name and email match a user in the database
    $select_user = mysqli_prepare($conn, "SELECT utilisateur_id FROM utilisateur WHERE nom = ? AND email = ?");
    mysqli_stmt_bind_param($select_user, "ss", $nomss, $emailss);
    mysqli_stmt_execute($select_user);
    mysqli_stmt_store_result($select_user);

    if (mysqli_stmt_num_rows($select_user) > 0) {
        // Generate a new password
        $new_password = generatePassword();
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password

        // Update the password in the 'utilisateur' table
        mysqli_stmt_bind_result($select_user, $utilisateur_id);
        mysqli_stmt_fetch($select_user);
        mysqli_stmt_close($select_user);

        $update_password = mysqli_prepare($conn, "UPDATE utilisateur SET mot_de_passe = ? WHERE utilisateur_id = ?");
        mysqli_stmt_bind_param($update_password, "si", $hashed_password, $utilisateur_id);
        mysqli_stmt_execute($update_password);

        // Send an email with the new password
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abokorhamoud7899@gmail.com'; // Replace with your email
        $mail->Password = 'zbbl rgew yakx deeh'; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('abokorhamoud7899@gmail.com', 'Mohamoud'); // Replace with your name and email
        $mail->addAddress($emailss);
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

// Function to generate a random password
function generatePassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/3ea0bb51d0.js" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #F6F5F7;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: sans-serif;
            height: 100vh;
            margin: -20px 0 50px;
        }

        h1 {
            font-weight: bold;
            margin: 0;
        }

        p {
            font-size: 14px;
            font-weight: 100;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
        }

        small {
            font-size: 12px;
        }

        a {
            color: #333333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }

        button {
            border-radius: 20px;
            border: 1px solid #FF4B2B;
            background-color: #FF4B2B;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background-color: transparent;
            border-color: #ffffff;
        }

        form {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        input {
            background-color: #eeeeee;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, .22);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
            margin-top: 100px; /* Added top margin */
        }

        .container-form {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .container-signin-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .container-signin-container {
            transform: translateX(100%);
        }

        .container-forget-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .container-forget-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: #FF416C;
            background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
            background: linear-gradient(to right, #FF4B2B, #FF416C);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #ffffff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        
        <div class="container-form container-signin-container">
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Connexion</h1>
                <?php
                if (isset($_GET['erreur'])) {
                    echo "<p style='color: red;'>" . htmlspecialchars($_GET['erreur']) . "</p>";
                }
                ?>
                <input type="text" placeholder="Nom" name="nom" required>
                <input type="password" placeholder="Mot de passe" name="mot_de_passe" required>
                <button type="submit" name="Connecter">Se connecter</button>
                <a href="#" id="forgotPassword">Mot de passe oublié ?</a>
            
            </form>
        </div>

        <div class="container-form container-forget-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Mot de passe oublié</h1>
                <input type="text" placeholder="Nom" name="nome" required>
                <input type="email" placeholder="Email" name="emaile" required>
                <button type="submit" name="submit">Envoyer</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bienvenue</h1>
                    <p>Pour rester connecté avec nous, veuillez vous connecter avec vos informations personnelles</p>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Bonjour !</h1>
                    <p>Entrez vos informations personnelles pour réinitialiser votre mot de passe</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const forgotPasswordLink = document.getElementById('forgotPassword');
        const container = document.getElementById('container');

        forgotPasswordLink.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });
    </script>
</body>
</html>
