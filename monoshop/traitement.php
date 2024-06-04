
<?php

function ajouterClient($nom, $prenom, $telephone, $email, $compte) {

if (require("config/connexion.php")) {

    $req = $access->prepare("INSERT INTO client (nom, prenom, telephone, email, compte) VALUES ('$nom', '$prenom','$telephone' , '$email', '$compte')");


    $req->execute(array($nom, $prenom, $telephone, $email, $compte));
    
    $req->closeCursor();
}
}
function afficher() {
    if (require("config/connexion.php")) {
        $req = $access->prepare("SELECT * FROM client ORDER BY id DESC");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    } else {
        return false;
    }
}
function getProduit($id) {

    if (require("config/connexion.php")) {
        
        $req = $access->prepare("SELECT * FROM client WHERE id =?");

        $req->execute(array($id));

        if ($req->rowCount() == 1) {

            $data = $req->fetchAll(PDO::FETCH_OBJ);
            
            return $data;
        } else {
            return false; // Aucun résultat trouvé
        }
    $req->closeCursor();
    }
}


?>