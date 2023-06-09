<?php 
    require_once('connexion.php');

    $request = "SELECT * FROM dn_objets WHERE dn_objets.Categorie IN (7, 8) GROUP BY Titre";

    $filtre = "";
    if (isset($_GET['select'])) {
        switch ($_GET['select']) {
            case "date_up":
                $filtre = "ORDER BY Date_sortie ASC";
                break;
            case "date_down":
                $filtre = "ORDER BY Date_sortie DESC";
                break;
            case "disp_yes":
                $filtre = "ORDER BY Disponibilite DESC";
                break;
            case "disp_no":
                $filtre = "ORDER BY Disponibilite ASC";
                break;
            case "cat":
                $filtre = "";
                break;
        }
    }
    $request .= " " . $filtre;

    $select_value = "";
        switch ($filtre) {
            case "ORDER BY Date_sortie ASC":
                $select_value = "date_up";
                break;
            case "ORDER BY Date_sortie DESC":
                $select_value = "date_down";
                break;
            case "ORDER BY Disponibilite DESC":
                $select_value = "disp_yes";
                break;
            case "ORDER BY Disponibilite ASC":
                $select_value = "disp_no";
                break;
            default:
                $select_value = "cat";
        }

        if (isset($_POST['action'])) {
            $id_produit = $_POST['id'];
            $dispo = $_POST['Disponibilite'];
            $action = $_POST['action'];
            $etat = $_POST['Etat'];

            $id_client = $_POST['select'];
            $id_client_rendu = $_POST['selected'];
            $etat_give = $_POST['etat_give'];
        
            if ($action === 'Emprunter') {
                $sql_update = "UPDATE dn_objets SET Disponibilite = 'Non' WHERE id =".$id_produit;
                $emprunt = "INSERT INTO dn_objets_has_dn_client (dn_objets_id, dn_client_id) VALUES ('$id_produit', '$id_client')";
                $result_emprunt = mysqli_query($CONNEXION, $emprunt);
                $result = mysqli_query($CONNEXION, $sql_update);
            } elseif ($action === 'Rendre') {
                $sql_update = "UPDATE dn_objets SET Disponibilite = 'Oui', Etat ='$etat_give' WHERE id =".$id_produit;
                $rendu = "DELETE FROM dn_objets_has_dn_client WHERE dn_objets_id=".$id_produit." AND dn_client_id=".$id_client_rendu;
                $result_rendu = mysqli_query($CONNEXION, $rendu);
                if ($result_rendu) {
                    $verif = mysqli_affected_rows($CONNEXION);
                    if ($verif == '1') {
                        $livre_succes = "Le livre a bien été rendu";
                        $result = mysqli_query($CONNEXION, $sql_update);
                    } else {
                        $livre_error = "Vous n'avez pas emprunté ce livre";
                    }
                }
            }
        }
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet">
        <title>Dixnez +</title>
    </head>

    <body>
        <header>
            <img src="images/icones/logo.svg">
            <nav>
                <ul>
                    <li><a href="home.php"><img src="images/icones/accueil.svg">ACCUEIL</a></li>
                    <li><a href="films.php"><img src="images/icones/films.svg">FILMS</a></li>
                    <li><a href="livres.php"><img src="images/icones/livres.svg">LIVRES</a></li>
                    <li><a href="musiques.php"><img src="images/icones/musiques.svg">MUSIQUES</a></li>
                    <li><a href="multimedias.php"><img src="images/icones/multi.svg">MULTIMÉDIAS</a></li>
                </ul>
            </nav>
            <div class="ajout">
                <a href="ajout.php"><img src="images/icones/ajout.svg">AJOUT</a>
                <a href="inscription.php"><img src="images/icones/">INSCRIPTION</a>
            </div>
        </header>

        <main>
            <div class="wrap">
                <div class="top">
                    <h1>Films</h1>
                    <form method="GET">
                        <select name="select" id="select" onchange="this.form.submit();">
                            <option value="cat" <?php echo ($select_value == "cat" ? 'selected' : ''); ?>>Catégorie</option>
                            <option value="date_up" <?php echo ($select_value == "date_up" ? 'selected' : ''); ?>>Date de sortie ↑</option>
                            <option value="date_down" <?php echo ($select_value == "date_down" ? 'selected' : ''); ?>>Date de sortie ↓</option>
                            <option value="disp_yes" <?php echo ($select_value == "disp_yes" ? 'selected' : ''); ?>>Disponible</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>Pas disponible</option>
                        </select>
                    </form><!-- Filtre en fonction du style -->
                </div>
                <?php if(isset($livre_succes)) {?>
                    <span class="livre_succes"><?php echo $livre_succes ?></span>
                <?php } if(isset($livre_error)) {?>
                    <span class="livre_error" ><?php echo $livre_error ?></span>
                <?php } ?>
                <?php if ($dn_objets = mysqli_query($CONNEXION, $request)): ?>
                <?php foreach($dn_objets as $dn_objet): ?>
                <div class="object">
                    <img class="image" src="<?php echo $dn_objet['Affiche']; ?>">
                    <div class="text">
                        <span class="id"><?php echo $dn_objet['id']; ?></span>
                        <span class="titre"><?php echo $dn_objet['Titre']; ?></span>
                        <span class="infos"><?php echo $dn_objet['Date_sortie']; ?> - <?php echo $dn_objet['Style']; ?> - <?php echo $dn_objet['Duree']; ?></span>
                        <span class="text"><?php echo $dn_objet['Description']; ?></span>
                        <span class="quantite">
                            <?php $request_quant = "SELECT COUNT(*) AS occurrences FROM dn_objets WHERE  dn_objets.Titre = '{$dn_objet['Titre']}' GROUP BY Titre ORDER BY id";
                                $result = mysqli_query($CONNEXION, $request_quant);
                                if ($result) {
                                    while($row = $result->fetch_assoc()) {
                                        $occurrences = $row["occurrences"];
                                        echo "Quantité : " . $occurrences . "<br>"; }
                                }
                            ?>
                        </span>
                        <span class="disponibilite">Produit disponible : <?php echo $dn_objet['Disponibilite']; ?></span>
                        <div class="reservation">
                            <?php if ($dn_objet['Disponibilite'] === 'Oui') { ?>
                                <button type="button" class="emprunter_btn display_btn">Emprunter</button>
                            <?php }elseif ($dn_objet['Disponibilite'] === 'Non') { ?>
                                <button type="button" class="rendre_btn display_btn">Rendre</button>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                        $request = "SELECT Etat, id, Disponibilite  FROM dn_objets WHERE Titre = '{$dn_objet['Titre']}' AND (dn_objets.Categorie = 7 OR dn_objets.Categorie = 8)";
                        $etats = mysqli_query($CONNEXION, $request);
                    ?>
                    <form method="POST" action="#">
                        <div class="emprunt">
                            <p>Choisissez l'état du produit :</p>
                            <?php while ($etat = mysqli_fetch_assoc($etats)): ?>
                                <div class="etat">
                                    <label for="product_<?php echo $etat['id']; ?>">
                                        <input type="radio" name="product_id" id="product_<?php echo $etat['id']; ?>" value="<?php echo $etat['id']; ?>">
                                        <span><?php echo $etat['Etat']; ?></span>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                            <button type="button" class="emprunterClose display_btn">Retour</button>
                        </div>
                        <?php
                            $request = "SELECT * FROM dn_client";
                            $mails = mysqli_query($CONNEXION, $request);
                        ?>
                        <div class="rendu">
                            <select name="selected" id="mail">
                            <?php while ($mail = mysqli_fetch_assoc($mails)): ?>
                                <option value="<?php echo $mail['id']; ?>"><?php echo $mail['Mail']; ?></option>
                            <?php endwhile; ?>
                            </select>
                            <select name="etat_give" id="etat_give">
                                <option value="Neuf">Neuf</option>
                                <option value="Très bon état">Très bon état</option>
                                <option value="Bon état">Bon état</option>
                                <option value="Ok">Ok</option>
                            </select>
                            <input type="hidden" name="id" value="<?php echo $dn_objet['id']; ?>">
                            <input type="hidden" name="Disponibilite" value="<?php echo $dn_objet['Disponibilite']; ?>">
                            <input type="hidden" name="Etat" value="<?php echo $dn_objet['Etat']; ?>">
                            <button type="submit" name="action" value="Rendre">Rendre</button>
                            <button type="button" class="rendreClose display_btn">Retour</button>
                        </div>
                        <?php
                            $request = "SELECT * FROM dn_client";
                            $mails = mysqli_query($CONNEXION, $request);
                        ?>
                        <div class="user_form" style="display: none">
                            <select name="select" id="mail">
                            <?php while ($mail = mysqli_fetch_assoc($mails)): ?>
                                <option value="<?php echo $mail['id']; ?>"><?php echo $mail['Mail']; ?></option>
                            <?php endwhile; ?>
                            </select>
                            <button type="submit" name="action" value="Emprunter">Valider</button>
                        </div>
                    </form>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <script src="js/display.js"></script>
            </div>
        </main>
        <footer>
        <img src="images/icones/logo2.svg">
            <p>Si vous avez des questions ou un problèmes, contactez-nous à l'adresse suivante :</p>
            <p><span>serviceclient@dixnez.com</span> ou au <span>06 10 11 12 13</span></p>
            <p>Le contenu et les plateformes disponibles peuvent varier selon la zone géographique.</p>
            <p>© 2023 Dixnez et ses sociétés affiliées. Tous droits réservés.</p>
        </footer>
    </body>
</html>