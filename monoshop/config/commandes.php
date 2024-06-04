<?php


function modifier($image, $nom, $prix, $desc, $id) {
    global $access;

    $req = $access->prepare("UPDATE produit SET image=?, nom=?, prix=?, description=? WHERE id=?");

    $req->execute(array($image, $nom, $prix, $desc, $id));

    $req->closeCursor();
}

function getProduit($id) {

    if (require("connexion.php")) {
        
        $req = $access->prepare("SELECT * FROM produit WHERE id =?");

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

function getAdmin($email, $password) {

    if (require("connexion.php")) {
        $req = $access->prepare("SELECT * FROM admin  WHERE email = ? AND motdepasse = ?");

        $req->execute(array($email, $password));

        if ($req->rowCount() == 1) {

            $data = $req->fetch();
            
            return $data;
        } else {
            return false; // Aucun résultat trouvé
        }
    $req->closeCursor();
    }
}

function ajouter($image, $nom, $prix, $desc) {

    if (require("connexion.php")) {

        $req = $access->prepare("INSERT INTO produit (image, nom, prix, description) VALUES (?, ?, ?, ?)");

        $req->execute(array($image, $nom, $prix, $desc));
        
        $req->closeCursor();
    }
}

function afficher() {
    if (require("connexion.php")) {
        $req = $access->prepare("SELECT * FROM produit ORDER BY id DESC");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    } else {
        return false;
    }
}

function supprimer($id) {
    if (require("connexion.php")) {
        $req = $access->prepare("DELETE FROM produit WHERE id=?");
        $req->execute(array($id));
    }
}
?>
