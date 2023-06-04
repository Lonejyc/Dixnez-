<?php 
    require_once('connexion.php');

    if (isset($_GET['action'])) {
        $id_produit = $_GET['id_produit'];
        $dispo = $_GET['Disponibilite'];
        $action = $_GET['action'];
        $etat = $_GET['Etat'];

        if ($action == 'Emprunter') {
            $dispo = "Non";
            $sql_update = "UPDATE dn_objets SET Disponibilite = $dispo WHERE id = $id_produit";
        } elseif ($action == 'Rendre') {
            $dispo = "Oui";
            $sql_update = "UPDATE dn_objets SET Disponibilite = $dispo WHERE id = $id_produit";
            if ($etat == 'Neuf') {
                $etat = "Bon etat";
                $sql_update = "UPDATE dn_objets SET Etat = $etat WHERE id = $id_produit";
            } elseif ($etat == 'Bon etat') {
                $etat = "Moyen";
                $sql_update = "UPDATE dn_objets SET Etat = $etat WHERE id = $id_produit";
            } elseif ($etat == 'Moyen') {
                $etat = "Abimé";
                $sql_update = "UPDATE dn_objets SET Etat = $etat WHERE id = $id_produit";
            } else {
                $etat = $etat;
                $sql_update = "UPDATE dn_objets SET Etat = $etat WHERE id = $id_produit";
            }
        }

        $result = mysqli_query($CONNEXION, $sql_update);
    }

    $request = "SELECT * FROM dn_objets WHERE dn_objets.Categorie = 9 GROUP BY Titre";

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
                    <form action="" method="GET">
                        <select name="select" id="select" onchange="this.form.submit();">
                            <option value="cat" <?php echo ($select_value == "cat" ? 'selected' : ''); ?>>Catégorie</option>
                            <option value="date_up" <?php echo ($select_value == "date_up" ? 'selected' : ''); ?>>Date de sortie ↑</option>
                            <option value="date_down" <?php echo ($select_value == "date_down" ? 'selected' : ''); ?>>Date de sortie ↓</option>
                            <option value="disp_yes" <?php echo ($select_value == "disp_yes" ? 'selected' : ''); ?>>Disponible</option>
                            <option value="disp_no" <?php echo ($select_value == "disp_no" ? 'selected' : ''); ?>>Pas disponible</option>
                        </select>
                    </form><!-- Filtre en fonction du style -->
                </div>
                <?php if ($dn_objets = mysqli_query($CONNEXION, $request)): ?>
                <?php foreach($dn_objets as $dn_objet): ?>
                <div class="object">
                    <span class="image"><?php echo $dn_objet['Affiche']; ?></span>
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
                            <button type="button" class="emprunter_btn display_btn">Emprunter</button>
                            <button type="button" class="rendre_btn display_btn">Rendre</button>
                        </div>
                    </div>
                    <?php
                        $request = "SELECT Etat FROM dn_objets WHERE Titre = '{$dn_objet['Titre']}' AND (dn_objets.Categorie = 9)";
                        $etats = mysqli_query($CONNEXION, $request);
                    ?>
                    <form method="GET">
                        <div class="emprunt">
                            <p class="etat">Choisissez l'état du produit :</p>
                            <?php while ($etat = mysqli_fetch_assoc($etats)): ?>
                                <div class="but">
                                    <button type="submit" name="action" value="Emprunter"><?php echo $etat['Etat']; ?></button>
                                </div>
                            <?php endwhile; ?>
                            <button type="button" class="emprunterClose display_btn">Retour</button>
                        </div>
                        <div class="rendu">
                            <button type="submit" name="action" value="Rendre">Rendre</button>
                            <button type="button" class="rendreClose display_btn">Retour</button>
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