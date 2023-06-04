<?php
$id_produit = $_POST['id'];
$dispo = $_POST['Disponibilite'];
$action = $_POST['action'];
$etat = $_POST['Etat'];

// Connexion à la base de données
$connect = mysqli_connect('localhost', 'root', '', 'dixnez');

if (isset($_POST['action'])) {
    if ($action == 'Emprunter') {
        $sql_update = "UPDATE dn_objets SET Disponibilite = 'Non' WHERE id =".$id_produit;
        echo $id_produit;
    } elseif ($action == 'Rendre') {
        $sql_update = "UPDATE dn_objets SET Disponibilite = 'Oui' WHERE id =".$id_produit;
        if ($etat == 'Neuf') {
            $sql_update = "UPDATE dn_objets SET Etat = 'Très Bon Etat' WHERE id =".$id_produit;
        } elseif ($etat == 'Bon etat') {
            $sql_update = "UPDATE dn_objets SET Etat ='Bon Etat' WHERE id =".$id_produit;
        } elseif ($etat == 'Moyen') {
            $sql_update = "UPDATE dn_objets SET Etat = 'Moyen' WHERE id =".$id_produit;
        }
    }

    $result = mysqli_query($connect, $sql_update);
}

// Ferme la connexion à la base de données
mysqli_close($connect);
?>