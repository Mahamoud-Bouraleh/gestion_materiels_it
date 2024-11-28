<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le mot de passe</title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover{
            background-color:green; 
        }
        .btn {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color:red;
    }

    .btn .bi-arrow-left {
        margin-right: 5px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Changer le mot de passe</h2>
        <form action="modifier_password_ad.php" method="post">
            <label for="username">Nom d'utilisateur:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="old_password">Ancien mot de passe:</label><br>
            <input type="password" id="old_password" name="old_password" required><br><br>
            
            <label for="new_password">Nouveau mot de passe:</label><br>
            <input type="password" id="new_password" name="new_password" required><br><br>
            
            <label for="confirm_password">Confirmer le nouveau mot de passe:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            
            <button type="submit" name="submit">Enregistrer</button>
            <a class="btn btn-primary" href="administrations.php">
                <span class="bi-arrow-left"></span>
                Retour
            </a>
        </form>
    </div>
</body>
</html>
