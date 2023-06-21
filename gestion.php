<?php
    require_once('connexion.php');

    // Récupère les données saisies par l'utilisateur
    if(isset($_POST['ajouter'])) {
        $img_nom = $_FILES['image']['name'];
        $tmp_nom = $_FILES['image']['tmp_name'];
        $time = time();
        $new_nom_img = $time.$img_nom;
        $deplacer_img = move_uploaded_file($tmp_nom,'images/'.$new_nom_img);

        if($deplacer_img){
            
            $categorie = $_POST['categorie'];
            $titre = $_POST['titre'];
            $auteur = $_POST['auteur'];
            $date = $_POST['date'];
            $duree = $_POST['duree'];
            $etat = $_POST['etat'];
            $description = $_POST['description'];

            $request = "INSERT INTO dn_objets (Categorie, Titre, Auteur, Date_sortie, Duree, Etat, Description, Affiche)". "VALUES ('$categorie', '$titre', '$auteur', '$date', '$duree', '$etat', '$description', '$new_nom_img')";
            // Exécute la requête SQL
            var_dump($request);
            if (mysqli_query($CONNEXION, $request)) {
                $ajout_succes = "Votre objet a été ajouté à la base de données avec succès !";

                // Récupère id de la 1er requête
                $id_objets=mysqli_insert_id($CONNEXION);
                $styles = intval($_POST['style']);

                $request2 = "INSERT INTO dn_objets_has_dn_style (dn_objets_id, dn_style_id) VALUES ('$id_objets', '$styles')";

                if (mysqli_query($CONNEXION, $request2)) {
                    $succes = "Votre objet a été ajouté à la base de données avec succès";
                } else {
                    echo "Erreur : " . mysqli_error($CONNEXION);
                }
            } else {
                $ajout_error = "Erreur lors de l'ajout de l'élément !";
            }
        }
    }
?>

<?php 
// Récupère les données saisies par l'utilisateur
    if(isset($_POST['id'])) {
        // Récupérer les données du formulaire
        // Récupérer l'ID de l'élément à supprimer depuis le formulaire
        $id = intval($_POST["id"]);

        // Vérifie si la connexion a réussi
        if (!$CONNEXION) {
            die('Erreur de connexion : ' . mysqli_connect_error());
        }

        // Construire et exécuter la requête SQL de suppression
        $sql = "DELETE FROM dn_objets WHERE id = $id";

        // Exécute la requête SQL
        if ($CONNEXION->query($sql) === TRUE) {
            $supp_succes =  "L'élément a été supprimé avec succès.";
        } else {
            $supp_error = "Erreur lors de la suppression de l'élément : " . $CONNEXION->error;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
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
                <a href="ajout.php"><img src="images/icones/ajout.svg">GESTION</a>
            </div>
        </header>
        
        <main>
            <div class="wrap">
                <div>
                    <?php if(isset($ajout_succes)) {?>
                        <span class="ajout_succes"><?php echo $ajout_succes ?></span>
                    <?php } if(isset($ajout_error)) {?>
                        <span class="ajout_error" ><?php echo $ajout_error ?></span>
                    <?php } ?>
                    <?php if(isset($supp_succes)) {?>
                        <span class="supp_succes"><?php echo $supp_succes ?></span>
                    <?php } if(isset($supp_error)) {?>
                        <span class="supp_error" ><?php echo $supp_error ?></span>
                    <?php } ?>
                    <h1>Ajout</h1>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div>
                            <?php
                                $request = "SELECT * FROM dn_categorie";
                                $categories = mysqli_query($CONNEXION, $request);
                            ?>
                            <select name="categorie" id="input-cat" value="Categorie" required>
                                <option value="" disabled selected>Categorie</option>
                                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['Categorie']; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <div class="input-img">
                                <div class="text-import">
                                    <label id="label-file" for="img-file">
                                        <div class="icon-upload"></div>
                                    </label>
                                    <span id="import-picture" class="import-picture"><label>Image (en png): </label></span>
                                </div>
                                <input type="file" name="image"/>
                            </div>
                            <input type="text" name="titre" id="input-tit" placeholder="Titre" required>
                        </div>
                        <div>
                            <input type="text" name="auteur" id="input-aut" placeholder="Auteur" required>
                            <input type="text" name="date" id="input-dat" placeholder="Date de sortie" required>
                            <?php
                                $request = "SELECT * FROM dn_style";
                                $styles = mysqli_query($CONNEXION, $request);
                            ?>
                            <select name="style" id="input-sty" value="Style">
                                <option value="" disabled selected>Style</option>
                                <?php while ($style = mysqli_fetch_assoc($styles)): ?>
                                    <option value="<?php echo $style['id']; ?>"><?php echo $style['Style']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="duree" id="input-dur" placeholder="Durée">
                            <select name="etat" id="input-eta" value="Etat" required>
                                <option value="" disabled selected>Etat</option>
                                <option value="Neuf">Neuf</option>
                                <option value="Très bon état">Très bon état</option>
                                <option value="Bon état">Bon état</option>
                            </select>
                            <input type="text" name="description" id="input-des" placeholder="Description" required>
                        </div>
                        <button type="submit" name="ajouter" value="Ajouter">Ajouter</button>
                    </form>
                    <script>
                        //FONCTION QUI AFFICHE LE NOM DU FICHIER LORSQUE QU'IL EST CHARGE
                        const fileImg = document.getElementById('img-file');
                        fileImg.onchange = () => {
                            if (fileImg.files.length == 1) {
                                var selectedFiles = fileImg.files[0].name;
                                document.getElementById("import-picture").innerHTML=selectedFiles;
                            } else {
                                document.getElementById("import-picture").innerHTML="Importez 1 image maximum !";
                            }
                        }
                    </script>
                </div>
                <div>
                    <h1>Suppression</h1>
                    <form method="POST">
                        <?php
                            $request = "SELECT DISTINCT * FROM dn_objets";
                            $titres = mysqli_query($CONNEXION, $request);
                        ?>
                        <select id="id" name="id" required>
                            <option value="" disabled selected>Nom de l'objet à supprimer :</option>
                            <?php while ($titre = mysqli_fetch_assoc($titres)): ?>
                                <option value="<?php echo $titre['id'] ?>"><?php echo $titre['Titre']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit" name="supprimer" value="Supprimer">Supprimer</button>
                    </form>
                </div>
            </div>            
        </main>

        <footer>
        <img src="images/icones/logo2.svg">
            <p>Si vous avez des questions ou un problèmes, contactez-nous à l'adresse suivante :</p>
            <p><span>serviceclient@dixnez.com</span> ou au <span>06 10 11 12 13</span></p>
            <p>Le contenu et les plateformes disponibles peuvent varier selon la zone géographique.</p>
            <p>© 2023 Dixnez et ses sociétées affiliées. Tous droits réservés.</p>
        </footer>
    </body>
</html>