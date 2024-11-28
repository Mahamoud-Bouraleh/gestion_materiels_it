<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit; // Arrête l'exécution du script après la redirection
};

if(isset($_POST['delete_selected'])){
   if(!empty($_POST['selected_messages'])) {
      foreach($_POST['selected_messages'] as $delete_id){
         mysqli_query($conn, "DELETE FROM message WHERE id = '$delete_id'") or die('query failed');
      }
      header('location:admin_contacts.php');
      exit; // Arrête l'exécution du script après la redirection
   } else {
      $no_messages_error = "Il n'y a pas de messages sélectionnés à supprimer.";
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM message WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
   exit; // Arrête l'exécution du script après la redirection
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> messages </h1>

   <?php if(isset($no_messages_error)) { ?>
      <div class="error-message"><?php echo $no_messages_error; ?></div>
   <?php } ?>

   <form action="" method="post">
      <button type="submit" name="delete_selected" onclick="return confirm('Delete selected messages?');" class="delete-btn">Supprimer les messages sélectionnés</button>
   
   <div class="box-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM message") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
      
   ?>
   <div class="box">
      <input type="checkbox" name="selected_messages[]" value="<?php echo $fetch_message['id']; ?>">
      <p>id utilisateur: <span><?php echo $fetch_message['user_id']; ?></span> </p>
      <p> nom : <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> numero : <span><?php echo $fetch_message['number']; ?></span> </p>
      <p> email : <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> message : <span><?php echo $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts_repondre.php?message_id=<?php echo $fetch_message['id']; ?>" class="delete-btn">répondre</a>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">supprimer</a>
   </div>
   <?php
      };
   }else{
      echo '<p class="empty">vous n\'avez pas des  messages!</p>';
   }
   ?>
   </div>
   </form>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>