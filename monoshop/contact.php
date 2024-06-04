<?php

include 'config/connexion.php';


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "darcshop";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Définir le jeu de caractères de la connexion
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit(); // Arrêter le script en cas d'erreur de connexion
}


session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND numero = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <style>
      body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
          background-color: #f4f4f4;
      }

      .contact {
          width: 80%;
          margin: 50px auto;
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          text-align: center;
      }

      .contact h3 {
          color: #333;
          margin-bottom: 20px;
      }

      .contact form {
          display: flex;
          flex-direction: column;
          align-items: center;
      }

      .contact input[type="text"],
      .contact input[type="email"],
      .contact input[type="number"],
      .contact textarea {
          margin-bottom: 10px;
          padding: 8px;
          border: 1px solid #ccc;
          border-radius: 5px;
          font-size: 14px;
          width: 100%;
          box-sizing: border-box;
      }

      .contact input[type="submit"] {
          background-color: #007bff;
          color: #fff;
          border: none;
          padding: 10px 20px;
          border-radius: 5px;
          cursor: pointer;
          transition: background-color 0.3s ease;
      }

      .contact input[type="submit"]:hover {
          background-color: #0056b3;
      }

      .error {
          color: red;
      }

      .success {
          color: green;
      }
   </style>

</head>
<body>
    

<section class="contact">

   <form action="" method="post">
      <h3>Entrer en contact</h3>
      <input type="text" name="name" placeholder="Entrer votre nom" required maxlength="20">
      <input type="email" name="email" placeholder="Entrer votre Email" required maxlength="50">
      <input type="number" name="number" min="0" max="9999999999" placeholder="Entrez votre numero de telephone" required onkeypress="if(this.value.length == 10) return false;">
      <textarea name="msg" placeholder="entrer votre message" cols="30" rows="10"></textarea>
      <input type="submit" value="Envoyer le message" name="send">
   </form>

</section>

<script src="js/script.js"></script>

</body>
</html>
