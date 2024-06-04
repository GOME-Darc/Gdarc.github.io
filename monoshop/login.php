<?php
session_start();


include "config/commandes.php";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login_darcshop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>

</head>
<body>
    <br>
    <br>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
        
            <form method="POST">
  <div class="mb-3">
  <div style="display: flex; justify-content:flex-end; ">
      <a href="retour.php" class="btn btn-danger"> Se deconnecter</a>
      </div>
    <label for="email" class="form-label">Email </label>
    <input type="email" class="form-control" name="email" style="width: 80%">
  <div class="mb-3">
    <label for="motdepasse" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" name="motdepasse" style="width: 80%">
  </div>
  <input type="submit" class="btn btn-success" name="envoyer" value="Se connecter">
  

<p style="padding:0;">Chers clients, Cette page est uniquement reserver pour l'administrateur</p>

            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>

<?php 
if (isset($_POST['envoyer'])){
    if(!empty($_POST['email']) AND !empty($_POST['motdepasse'])){
        $email =htmlspecialchars($_POST['email']); 
        $motdepasse =htmlspecialchars($_POST['motdepasse']); 
       
        $admin = getAdmin($email, $motdepasse);

        if($admin){
            $_SESSION['Gomedarc2003@'] = $admin;

            header("Location: admin/");
        }else{

            echo "<span style='color: red; font-weight: bold; font-size: 1.2em;'>Email ou Mot de passe Incorrect</span>";


            
        }

    }
}

?>