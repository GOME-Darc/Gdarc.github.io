<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'darcshop';

// Connexion à la base de données
$conn = mysqli_connect($host, $username, $password, $database);

// Vérifier la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}


// Vérifier si l'utilisateur est authentifié en tant qu'administrateur
session_start();


if (!isset($_SESSION['Gomedarc2003@'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
    header("Location: login.php");
    exit(); // Arrêter l'exécution du script après la redirection
}


// Requête SQL pour récupérer les informations des clients avec les produits commandés, y compris les images des produits
$sql = "SELECT client.nom, client.prenom, client.email, client.indicatif, client.Telephone, client.num_bancaire, produit.id AS produit_id, produit.nom AS produit_nom, produit.image 
        FROM client 
        INNER JOIN commande_client ON client.id = commande_client.client_id
        INNER JOIN produit ON commande_client.produit_id = produit.id";
$result = mysqli_query($conn, $sql);

// Vérifier si des commandes ont été trouvées
if (mysqli_num_rows($result) > 0) {
    // Afficher les commandes dans un tableau HTML
    echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Liste des commandes (Admin)</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container'>
            <h2 class='text-center mb-5'>Liste des commandes (Admin)</h2>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Indicatif du pays</th>
                        <th>Numéro de téléphone</th>
                        <th>Numéro bancaire</th>
                        <th>ID du produit</th>
                        <th>Nom du produit</th>
                        <th>Image du produit</th>
                    </tr>
                </thead>
                <tbody>";

    // Parcourir les résultats de la requête
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nom'] . "</td>";
        echo "<td>" . $row['prenom'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['indicatif'] . "</td>";
        echo "<td>" . $row['Telephone'] . "</td>";
        echo "<td>" . $row['num_bancaire'] . "</td>";
        echo "<td>" . $row['produit_id'] . "</td>";
        echo "<td>" . $row['produit_nom'] . "</td>";
        echo "<td><img src='" . $row['image'] . "' width='100'></td>";
        echo "</tr>";
    }

    echo "</tbody>
        </table>
    </div>
    </body>
    </html>";

} else {
    // Aucune commande trouvée
    echo "Aucune commande trouvée.";
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
