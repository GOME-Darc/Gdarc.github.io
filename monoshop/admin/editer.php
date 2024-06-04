<?php 
session_start();

if(!isset($_SESSION['Gomedarc2003@'])){
    header("Location: ../login.php");
}
if(empty($_SESSION['Gomedarc2003@'])){
  header("Location: ../login.php");
}

if(!isset($_GET['pdt'])){
  header("Location: ../afficher.php");
}

if(empty($_GET['pdt']) AND !is_numeric($_GET['pdt'])){
    header("Location: ../afficher.php");
}

$id = $_GET['pdt'];

require("../config/commandes.php");
$Produits = getProduit($id);

//foreach ($produits as $produit){



   // $nom = $produit->nom;
   // $idpdt = $produit->id;
    //$image = $produit->image;
   // $prix = $produit->prix;
    //$description = $produit->description;
//}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><b><i>ARC Magasin de voitures</i></b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="../admin/">Nouveau</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="suppression.php">Supprimer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="afficher.php">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active " href="#" style="font-weight:bold; color:green; ">Modification</a>
                </li>
            </ul>
            <div style="display: flex; justify-content:flex-end; ">
                <a href="deconnexion.php" class="btn btn-danger">Se déconnecter</a>
            </div>
        </div>
    </div>
</nav>

<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"> 
            <?php foreach ($Produits as $Produit): ?>

                
            <form method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Titre de l'image</label>
                    <input type="name" class="form-control" name="image" value="" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" name="nom" value="" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Prix</label>
                    <input type="number" class="form-control" name="Prix" value="" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Description</label>
                    <textarea class="form-control" name="desc" required></textarea>
                </div>
                <button type="submit" name="Valider" class="btn btn-success">Enregistrer un nouveau produit</button>
            </form>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php 
if(isset($_POST['Valider'])) {
    if(isset($_POST['image']) && isset($_POST['nom']) && isset($_POST['Prix']) && isset($_POST['desc'])) {
        if(!empty($_POST['image']) && !empty($_POST['nom']) && !empty($_POST['Prix']) && !empty($_POST['desc'])) {
            $image = htmlspecialchars(strip_tags($_POST['image']));
            $nom = htmlspecialchars(strip_tags($_POST['nom']));
            $prix = htmlspecialchars(strip_tags($_POST['Prix']));
            $desc = htmlspecialchars(strip_tags($_POST['desc']));
            try {
                modifier($image, $nom, $prix, $desc, $id);

            }
             catch (Exception $e) 
             {
                echo $e->getMessage();
            }
        }
    }
}
?>
</body>
</html>
