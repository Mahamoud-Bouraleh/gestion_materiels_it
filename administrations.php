<?php
session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login1.php");
    exit();
}

// Reste du code de la page

if (isset($_POST['deconnexion'])) {
    // Déconnecter l'utilisateur en supprimant toutes les variables de session
	session_destroy();    
    // Rediriger vers la page de connexion
    header('Location: /gestion_materil_it\login1.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>interface</title>
  <style>
    *{
    margin: 0;
    padding: 0;
}
body{
    min-height: 100vh;
    background-image: url(laptop.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
.sidebar{
position: fixed;
top: 0;
right: 0;
height: 100vh;
width: 250px;
z-index: 999;
background-color: rgba(255,255,255,0.2);
backdrop-filter: blur(10px);
box-shadow: -10px 0 10px rgba(0,0,0,0.1);
display: flex;
flex-direction: column;
align-items: flex-start;
justify-content: flex-start;
}
.sidebar li{
    width: 100%;
}
.sidebar a{
    width: 100%;
}
.menu-button{
    display: none;
}
@media(max-width:800px){
    hideOnMobile{
        display: none;
    }
}
.menu-button{
    display: block;
}
@media(max-width:400px){
    .sidebar{
        width: 100%;
    }
}
  </style>
  </head>
  <body>
  <nav><form method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>' class='logout-form'>
    <h2><input type='submit' name='deconnexion' value='Deconnexion' class='bouton'></h2>
</form>

    <ul class="sidebar">
        <li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
    <li class="hideOnMobile"><a href="administrations.php">Acceuille</a></li>
    <li class="hideOnMobile"><a href="commander.html">commander</a></li>
    <li class="hideOnMobile"><a href="declarer_panne.php">Declarer_pannes</a></li>
    <li class="hideOnMobile"><a href="afficher_commande.php">Afficher mes commandes</a></li>
    <li class="hideOnMobile"><a href="afficher_pannes.php">Afficher mes pannes</a></li>
    <li><a href="change_password_ad.php" class="logout">
					<i class='bx bxs-key' ></i>
					<span class="text">Changer le mot de passe</span>
				</a></li>
   
    </ul>
<ul>
  <li><a href="#">Administration</a></li>
  <li><a href="administrations.php">Acceuille</a></li>
  <li><a href="commander.html">commander</a></li>
  <li><a href="declarer_panne.html">Declarer_pannes</a></li>
  <li><a href="afficher_pannes.php">Afficher mes pannes</a></li>
  <li><a href="afficher_commande.php">Afficher mes commandes</a></li>
  <li><a href="../change_password_ad.php" class="logout">
					<i class='bx bxs-key' ></i>
					<span class="text">Changer le mot de passe</span>
				</a></li>
  
</ul>
  </nav>
  <script>
    function showSidebar(){
      const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'flex'
    }
    function hideSidebar(){
      const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'none'
    }
    
  </script>
  </body>
</html>