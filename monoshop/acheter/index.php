<?php 
session_start();

if(!isset($_SESSION['Gomedarc2003@'])) {
    // Si l'utilisateur n'est pas connecté, vous pouvez effectuer une action ici, comme rediriger vers une page de connexion.
    // Par exemple :
    // header("Location: login.php");
}

$host = 'localhost';
$username = 'root';
$passwordb = ''; 
$database = 'darcshop';

$conn = mysqli_connect($host, $username, $passwordb, $database);

if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

if (!empty($_POST)) {
    extract($_POST);

    if (isset($_POST['Valider'])) {
        // Assurez-vous que les noms des champs dans le formulaire correspondent aux clés utilisées pour extraire les valeurs du tableau $_POST.
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
        $indicatif = mysqli_real_escape_string($conn, $_POST['indicatif']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $num_bancaire = mysqli_real_escape_string($conn, $_POST['num_bancaire']);

        // Préparer la requête SQL d'insertion des données
        $sql = "INSERT INTO client (nom, prenom, indicatif, Telephone, email, num_bancaire)
                VALUES ('$nom', '$prenom', '$indicatif', '$telephone','$email', '$num_bancaire')";

        // Exécuter la requête SQL
        if (mysqli_query($conn, $sql)) {
            // Si l'insertion réussit, vous pouvez rediriger l'utilisateur vers une page de succès par exemple.
            header("Location: ../success.php");
            exit;
        } else {
            echo "Erreur lors de l'enregistrement des données : " . mysqli_error($conn);
        }
    }
}

//mysqli_close($conn);
// Requête SQL pour récupérer les informations des clients avec les produits commandés, y compris les images des produits
$sql_select_clients = "SELECT client.*, produit.image 
                        FROM client 
                        INNER JOIN commande_client ON client.id = commande_client.client_id
                        INNER JOIN produit ON commande_client.produit_id = produit.id";
$result = mysqli_query($conn, $sql_select_clients);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            user-select: none;
        }

        .container {
            width: 100%;
            max-width: 600px;
        }
        .product-image {
            max-width: 50%;
            height: auto;
            margin-bottom: 20px; /* Ajout d'un peu d'espace en bas de l'image */
        }
        .green-price {
            color: green;
            font-weight: bold; /* Assurez-vous que le prix est en gras pour le mettre en valeur */
        }
    </style>
</head>
<body>
<div class="album py-5 bg-body-tertiary">
    <div class="container">
    <h2 class="text-center mb-5" style="color: red; border: 2px solid black; padding: 10px; font-weight: bold;">Formulaire d'Achat</h2>
        <!-- Afficher les informations du produit -->
        <em><h2>Nom de la voiture: <?= $_GET['nom'] ?></h2></em>
        <?php
        // Prix du produit
        $prix = $_GET['prix'];

        // Afficher le prix avec le symbole "$" en couleur verte
        echo '<h4>Prix -> <span style="color: green;">' . $prix . '</span><span style="color: green;">$</span></h4>';
        ?>
        <img src="<?= $_GET['image'] ?>" alt="Image du produit" class="product-image">

        <form method="POST" action="">
    <div class="mb-3 row align-items-center">
        <label for="nom" class="col-sm-2 col-form-label"><b>Nom :</b></label>
        <div class="col-sm-10">
            <input type="text" name="nom" placeholder="Entrez votre" class="form-control mb-3" required>
        </div>
        <label for="prenom" class="col-sm-2 col-form-label"><b>Prénom :</b></label>
        <div class="col-sm-10">
            <input type="text" name="prenom" placeholder="entrez votre prenom" class="form-control mb-3" required>
        </div>
        <label for="email" class="col-sm-2 col-form-label"><b>Email :</b></label>
        <div class="col-sm-10">
            <input type="email" name="email" placeholder="Entrez votre Email" class="form-control mb-3" required>
        </div>
        <label for="telephone" class="col-sm-2 col-form-label"><b>Numéro de téléphone :</b></label>
        <div class="col-sm-4 mb-3">
            <select name="indicatif" class="form-select" required>
                <option value="" disabled selected>Choisissez un indicatif</option>
                <option value="1">+1 - USA</option>
                <option value="33">+33 - France</option>
                <option value="44">+44 - Royaume-Uni</option>
                <option value="241">+241 - Gabon</option>
                <option value="255">+255 - Cote D'Ivoire</option>
                <option value="228">+228 - TOGO</option>
                <option value="229">+229 - BENIN</option>
                <option value="235">+235 - Tchad</option>
                <option value="233">+233 - Ghana</option>
                <option value="234">+234 - Nigeria</option>
            </select>
        </div>
        <div class="col-sm-6 mb-3">
            <input type="number" name="telephone" placeholder="Entrez votre numero" class="form-control" required onkeypress="if(this.value.length == 10) return false;">
        </div>
        <label for="compte" class="col-sm-2 col-form-label"><b>Numéro bancaire :</b></label>
        <div class="col-sm-10">
            <input type="number" name="num_bancaire" placeholder="Entrez votre numero bancaire" class="form-control mb-3" required onkeypress="if(this.value.length == 15) return false;">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            <input type="submit" name="Valider" value="Payer" class="btn btn-primary btn-lg">
        </div>
    </div>
</form>

        
        
    </div>
</div>
</body>
</html>
